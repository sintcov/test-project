<?php

namespace app\models;

use yii\imagine\Image;
use yii\base\Model;
use Yii;


class WorkImages extends Model
{
    
    public $files = [];
    private $types = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];


    public function addImage($name,  $files_type, $files_tmp_name, $uploaddir, $width, $height){
        
        if (in_array($files_type, $this->types)) {

            // путь к файлу (папка.файл)
            $uploadfile = $uploaddir.'/'.$name;
        
            // Если фаил уже существует, то удаляем
            if (file_exists($uploadfile)){
                unlink($uploadfile);
            }

            if (Image::thumbnail($files_tmp_name, $width, $height)->save(Yii::getAlias('@webroot/'.$uploadfile, ['quality' => 100]))) {

                return 200;
            }
        }    
    }


    

}