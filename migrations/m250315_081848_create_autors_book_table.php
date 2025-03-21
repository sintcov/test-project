<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%autors_book}}`.
 */
class m250315_081848_create_autors_book_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%autors_book}}', [
            'id' => $this->primaryKey(),
            'author_id' => $this->integer()->notNull(),
            'book_id' => $this->integer()->notNull(),
        ]);

        $this->createIndex(
            'idx-autors_book-author_id',
            'autors_book',
            'author_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-autors_book-author_id',
            'autors_book',
            'author_id',
            'authors',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-autors_book-book_id',
            'autors_book',
            'book_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-autors_book-book_id',
            'autors_book',
            'book_id',
            'books',
            'id',
            'CASCADE'
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%autors_book}}');
    }
}
