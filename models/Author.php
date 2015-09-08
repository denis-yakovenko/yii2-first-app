<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "author".
 *
 * @property integer $id
 * @property string $firstname
 * @property string $lastname
 *
 * @property Book[] $books
 */
class Author extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'author';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['firstname', 'lastname'], 'required'],
            [['firstname', 'lastname'], 'string', 'max' => 255],
            [['name'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'firstname' => 'Имя',
            'lastname' => 'Фамилия',
            'name' => 'Ф.И.О. автора',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBooks()
    {
        return $this->hasMany(Book::className(), ['author_id' => 'id']);
    }

    /**
     * returns array of full names of authors
     */
    public static function getFullNamesList()
    {
        $authors=Author::find()->all();
        $data = array();
        foreach ($authors as $item)
            $data[$item->id] = $item->firstname . ' '. $item->lastname;     
        return $data;
    }

    /**
     * sets full name of author
     */
    public function __set($name, $value) {
        if ($name === 'name') {
            $this->name = $this->firstname . ' '. $this->lastname;
        } else {
            parent::__set($name, $value);
        }
    }
 
    /**
     * gets full name of author
     */
    public function __get($name) {
        if ($name === 'name') {
            return $this->firstname . ' '. $this->lastname;
        }
        return parent::__get($name);
    }

}
