<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%customer}}`.
 */
class m240705_212001_create_customer_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%customer}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'registration_number' => $this->string()->notNull()->unique(),
            'photo' => $this->string(),
            'gender' => $this->string(),
            'address_id' => $this->integer(),

            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->createIndex(
            'idx-customer-address_id',
            '{{%customer}}',
            'address_id'
        );

        $this->addForeignKey(
            'fk-customer-address_id',
            '{{%customer}}',
            'address_id',
            '{{%address}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'fk-customer-address_id',
            '{{%customer}}'
        );

        $this->dropIndex(
            'idx-customer-address_id',
            '{{%customer}}'
        );

        $this->dropTable('{{%customer}}');
    }
}
