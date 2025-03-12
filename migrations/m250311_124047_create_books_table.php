<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%books}}`.
 */
class m250311_124047_create_books_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
         $this->createTable('books',	[
            'id' => $this->primaryKey(),
            'author_id' => $this->integer()->notNull(),
            'title' => $this->string()->notNull(),
            'year_release' => $this->date()->notNull(),
            'description' => $this->text()->notNull(),
            'isbn' => $this->string(17)->notNull(),
            'photo' => $this->string(),
            
            
        ]);
    }
    

    public function down()
    {
        $this->dropTable('books');

        return false;
    }
}
