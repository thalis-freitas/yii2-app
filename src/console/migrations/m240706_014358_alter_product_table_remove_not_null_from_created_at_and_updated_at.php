<?php

use yii\db\Migration;

/**
 * Class m240706_014358_alter_product_table_remove_not_null_from_created_at_and_updated_at
 */
class m240706_014358_alter_product_table_remove_not_null_from_created_at_and_updated_at extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('{{%product}}', 'created_at', $this->integer());
        $this->alterColumn('{{%product}}', 'updated_at', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('{{%product}}', 'created_at', $this->integer()->notNull());
        $this->alterColumn('{{%product}}', 'updated_at', $this->integer()->notNull());
    }
}
