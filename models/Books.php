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

    public $author_id;

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
            [['title', 'year_release', 'description', 'isbn'], 'required'],  
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
            'title' => 'Title',
            'year_release' => 'Year Release',
            'description' => 'Description',
            'isbn' => 'Isbn',
            'photo' => 'Photo',
        ];
    }



    public function getAuthorsBook()
    {
        return $this->hasMany(AutorsBook::class, ['book_id' => 'id']);
    }


    public function authors()
    {

        $author = ' ';
        $model = Yii::$app->db->createCommand('SELECT ab.author_id, b.year_release, a.id, a.FIO 
            FROM books b, authors a, autors_book ab
                WHERE  b.id = :id AND ab.author_id = a.id AND :id = ab.book_id')
                ->bindValue(':id', $this->id)
                ->queryAll();
                

        foreach ($model as $key => $item) {

            $author .= $item["FIO"] . ', ';
        }  

        return $author;
    }

    public function saveInfoImg($result_original_image)
    {
        $logo = Books::findOne($this->id);
        $logo->photo = $result_original_image;
        $logo->save();
}


}
