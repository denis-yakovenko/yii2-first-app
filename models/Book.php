<?php

namespace app\models;

use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "book".
 *
 * @property integer $id
 * @property string $name
 * @property string $date_create
 * @property string $date_update
 * @property string $preview
 * @property string $date
 * @property integer $author_id
 */
class Book extends \yii\db\ActiveRecord
{
    /**
     * @var UploadedFile file attribute
     */
    public $preview_file;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'book';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'id',
            'name' => 'Название',
            'date_create' => 'Дата добавления',
            'date_update' => 'Дата обновления',
            'preview' => 'Превью',
            'date' => 'Дата выхода книги',
            'author_id' => 'Автор',
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['author_id'], 'integer'],
            [['name', 'preview'], 'string', 'max' => 255],
            [['date'], 'safe'],
            [['date'] , 'date'],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(Author::className(), ['id' => 'author_id']);
    }

    /**
     * @inheritdoc
     * @return AuthorQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AuthorQuery(get_called_class());
    }

    public function beforeSave($insert) {
        /* sets date of create, if operation is insert */
        $insert ? $this->date_create = Yii::$app->formatter->asDate('now', 'yyyy-MM-dd') : null;
        /* sets date of update for every update operation */
        $this->date_update = Yii::$app->formatter->asDate('now', 'yyyy-MM-dd');
        /* calls function to save image file, if it exists in request */
        $this->saveImage();
        return parent::beforeSave($insert);
    }

    public function beforeDelete() {
        /* calls function to delete previos image file, if it exists */
        $this->dropImage();
        return parent::beforeDelete();
    }

    /*
    * delete previos image file, if it exists
    */
    public function dropImage(){
        if ($this->preview!='' && file_exists('uploads/' . $this->preview)) {
            unlink('uploads/' . $this->preview);
        }
        return true;
    }

    /*
    * save image file, if it exists in request
    */
    public function saveImage(){
        if ($this->load(Yii::$app->request->post())) {
            $this->preview_file = UploadedFile::getInstance($this, 'preview_file');
            if ($this->preview_file) {
                $this->dropImage();
                $fileName = Yii::$app->security->generateRandomString() . '.' . $this->preview_file->extension;
                $this->preview_file->saveAs('uploads/' . $fileName);
                $this->preview = $fileName;
            }
        }
        return true;
    }

}
