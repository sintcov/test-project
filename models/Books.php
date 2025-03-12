<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "books".
 *
 * @property int $id
 * @property int $author_id
 * @property string $title
 * @property string $year_release
 * @property string $description
 * @property string $isbn
 * @property string $photo
 */
class Books extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'books';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['author_id', 'title', 'year_release', 'description', 'isbn'], 'required'],
            [['author_id'], 'integer'],
            [['year_release'], 'safe'],
            [['description'], 'string'],
            [['title', 'photo'], 'string', 'max' => 255],
            [['isbn'], 'string', 'max' => 17],
            
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'author_id' => 'Author ID',
            'title' => 'Title',
            'year_release' => 'Year Release',
            'description' => 'Description',
            'isbn' => 'Isbn',
            'photo' => 'Photo',
        ];
    }

    public function getAuthor()
    {
        return $this->hasOne(Authors::className(), ['id' => 'author_id']);
    }

}
