<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%address}}`.
 */
class m240705_211805_create_address_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%address}}', [
            'id' => $this->primaryKey(),
            'zip_code' => $this->string()->notNull(),
            'street' => $this->string()->notNull(),
            'number' => $this->string()->notNull(),
            'city' => $this->string()->notNull(),
            'state' => $this->string()->notNull(),
            'complement' => $this->string(),

            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%address}}');
    }
}
