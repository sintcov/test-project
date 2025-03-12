<?php

namespace tests;
use app\models\User;
use Yii;
use PHPUnit\Framework\TestCase;

class UserTest  extends TestCase
{

    /*
    public function getConnection()
    {
        $pdo = new \PDO($GLOBALS['DB_DSN'], $GLOBALS['DB_USER'], $GLOBALS['DB_PASSWD']);

        return $this->createDefaultDBConnection($pdo, $GLOBALS['DB_DBNAME']);
    }

    public function getDataSet()
    {
        return $this->createXMLDataSet(dirname(__FILE__).'/../_data/users.xml');
    }
*/

    
    public function setUp():void
    {

        User::deleteAll();

        Yii::$app->db->createCommand()->insert(User::tableName(), [
            'username' => 'user',
            'email' => 'user@email.com',
        ])->execute();

    }

    

    public function testValidateExistedValue()
    {
        $user = new User([
            'username' => 'user',
            'email' => 'user@email.com',
        ]);

        $this->assertFalse($user->validate(), 'model is not valid');
        $this->assertArrayHasKey('username', $user->getErrors(), 'check exitsted username error');
        $this->assertArrayHasKey('email', $user->getErrors(), 'check exitsted email error');
    }


    public function testValidateCorrectValue()
    {
        $user = new User([
            'username' => 'CorrectUsername',
            'email' => 'correct@email.com',
        ]);

        $this->assertTrue($user->validate(), 'correct model is valid');
    }


    public function testValidateWrongValue()
    {
        $user = new User([
            'username' => 'Wrong % Username',
            'email' => 'wrong_email',
        ]);


        $this->assertFalse($user->validate(), 'validate incorrect username and email');
        $this->assertArrayHasKey('username', $user->getErrors(), 'check incorrect username error');
        $this->assertArrayHasKey('email', $user->getErrors(), 'check incorrect email error');
    }
    

    public function testSaveIntoDatabase()
    {
        $user = new User([
            'username' => 'TestUsername',
            'email' => 'test@email.com',
        ]);

        $this->assertTrue($user->save(), 'model is saved');

    }



}
