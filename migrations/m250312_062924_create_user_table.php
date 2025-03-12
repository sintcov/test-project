<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user}}`.
 */
class m250312_062924_create_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(64)->notNull(),
            'surname' => $this->string(64)->notNull(),
            'patronymic' => $this->string(64)->notNull(),
            'phone' => $this->string(17)->notNull(),
            'username' => $this->string(64)->notNull(),
            'password' => $this->string()->notNull(),
            'auth_key' => $this->string(),
            'subscribe_to_new_books' => $this->boolean(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user}}');
    }
}
