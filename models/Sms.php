<?php

namespace app\models;

use yii\base\Model;
use app\models\User;
use app\models\Authors;

class Sms extends Model
{

   public function sendingSms($book, $authorId)
   {


        $author = Authors::find()->select(['id', 'FIO'])->where(['id' => $authorId])->asArray()->one();

        $users = new User();
        $abonens = $users->subscribeToNewBooks($book, $author["FIO"]);

        $apikey = 'XXXXXXXXXXXXYYYYYYYYYYYYZZZZZZZZXXXXXXXXXXXXYYYYYYYYYYYYZZZZZZZZ';

        $send = array(
            'apikey' => $apikey,
            'from' => 'INFORM',
            'send' =>  $abonens
        );

        $result = file_get_contents('https://smspilot.ru/api2.php', false, stream_context_create(array(
            'http' => array(
                'method' => 'POST',
                'header' => "Content-Type: application/json\r\n",
                'content' => json_encode( $send ),
            ),
        )));

        if (!$result) {

            throw new \Exception('Не удалось разослать СМС');

        }



       
    }

}