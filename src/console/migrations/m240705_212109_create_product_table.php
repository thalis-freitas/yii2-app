<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%product}}`.
 */
class m240705_212109_create_product_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%product}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull()->unique(),
            'price' => $this->decimal(10, 2)->notNull(),
            'photo' => $this->string(),
            'customer_id' => $this->integer()->notNull(),

            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->createIndex(
            'idx-product-customer_id',
            '{{%product}}',
            'customer_id'
        );

        $this->addForeignKey(
            'fk-product-customer_id',
            '{{%product}}',
            'customer_id',
            '{{%customer}}',
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
            'fk-product-customer_id',
            '{{%product}}'
        );

        $this->dropIndex(
            'idx-product-customer_id',
            '{{%product}}'
        );

        $this->dropTable('{{%product}}');
    }
}
