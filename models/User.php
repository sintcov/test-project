<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $name
 * @property string $surname
 * @property string $patronymic
 * @property string $username
 * @property string $password
 * @property string $auth_key
 */
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{

    public function beforeSave($insert) {

        if (parent::beforeSave($insert)) {

            if ($insert) {

                $this->password = Yii::$app->getSecurity()->generatePasswordHash($this->password);
           
            }

            return true;
        }

        return false;
    }

    

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'surname', 'patronymic', 'username', 'password', 'phone'], 'required'],
            [['name', 'surname', 'patronymic', 'username'], 'string', 'max' => 64],
            [['phone'], 'string', 'max' => 17],
            [['subscribe_to_new_books'], 'number'],
            
            [['password', 'auth_key'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'surname' => 'Surname',
            'patronymic' => 'Patronymic',
            'username' => 'Username',
            'password' => 'Password',
            'auth_key' => 'Auth Key',
            'phone' => 'Phone',
        ];
    }

    # Формирование парета абонентов для рассылки смс
    public function subscribeToNewBooks($book, $author)
    {

        $array = [];
        $result = User::find()->select(['id', 'subscribe_to_new_books'])->whrer(['subscribe_to_new_books' => 1])->asArray()->all();

        foreach ($result as $key => $item)
        {

            $array[] = [
                'id' => $item["id"],
                'to' => $item["phone"],
                'text' => 'Новая книга ' . $book . ' от автора ' . $author
            ];

        }

        return  $result;
    }
  

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

  
    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        //   return static ::findOne(['access_token' => $token]);
    }

    public function setPassword($password)
    {
        $this->password = Yii::$app->security->generatePasswordHash($password);
    }
    

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->auth_key === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        //  return $this->password === $password;
        return \Yii::$app->security->validatePassword($password, $this->password);
    }

    public function generateAuthKey(){
       return $this->auth_key = \Yii::$app->getSecurity()->generateRandomString();
    }

}
