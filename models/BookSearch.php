<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Book;

/**
 * BookSearch represents the model behind the search form about `app\models\Book`.
 */
class BookSearch extends Book
{

    public $date_from;
    public $date_to;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'author_id'], 'integer'],
            [['name', 'date_create', 'date_update', 'preview', 'date'], 'safe'],
            [['date_from, date_to'], 'date', 'on'=>'search'],
            [['date_from, date_to'], 'safe', 'on'=>'search'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        $attributeLabels = parent::attributeLabels();
        $attributeLabels['date_from'] = 'с';
        $attributeLabels['date_to'] = 'по';
        return $attributeLabels;
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Book::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination'=>array(
                'pageSize'=>3,
            ),
        ]);

        /* table of authors joins to show real names of authors */
        $query->joinWith(['author']);

        $dataProvider->sort->attributes['author.name'] = [
            'asc' => ['author.firstname' => SORT_ASC, 'author.lastname' => SORT_ASC],
            'desc' => ['author.firstname' => SORT_DESC, 'author.lastname' => SORT_DESC],
        ];

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $this->load($params);

        /* save the date values for filtering models */
        isset($params['BookSearch']['date_from'])?$this->date_from = $params['BookSearch']['date_from']:null;
        isset($params['BookSearch']['date_to'])?$this->date_to = $params['BookSearch']['date_to']:null;

        /* filter model */
        $query
            ->andFilterWhere(['author_id' => $this->author_id])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['>=', 'date', !$this->date_from==null? date('Y-m-d', strtotime($this->date_from)):null])
            ->andFilterWhere(['<=', 'date', !$this->date_to==null? date('Y-m-d', strtotime($this->date_to)):null])
        ;

        return $dataProvider;
    }
}
