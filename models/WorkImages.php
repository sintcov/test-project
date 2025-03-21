<?php

namespace app\models;

use yii\imagine\Image;
use yii\base\Model;
use Yii;


class WorkImages extends Model
{
    
    public $files = [];
    private $types = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];


    public function addImage($id,  $files_type, $files_tmp_name, $uploaddir, $width, $height):string
    {


        $info = pathinfo($_FILES['upload_image']['name']);
        $new_name = $id.'_'.Yii::$app->security->generateRandomString();
        $new_name = $new_name.'.'.$info["extension"];
        
        if (in_array($files_type, $this->types)) {

            // путь к файлу (папка.файл)
            $uploadfile = $uploaddir.'/'.$new_name;
        
            // Если фаил уже существует, то удаляем
            if (file_exists($uploadfile)){
                unlink($uploadfile);
            }

            if (Image::thumbnail($files_tmp_name, $width, $height)->save(Yii::getAlias('@webroot/'.$uploadfile, ['quality' => 100]))) {

            }else{

                throw new \Exception('Не удалось загрузить изображение');

            }
        }   
        
        return $new_name;
    }


    

}