<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%customer}}`.
 */
class m240707_010841_add_gender_id_column_to_customer_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('{{%customer}}', 'gender');
        $this->addColumn('{{%customer}}', 'gender_id', $this->integer());
        $this->addForeignKey(
            'fk-customer-gender_id',
            '{{%customer}}',
            'gender_id',
            '{{%gender}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-customer-gender_id', '{{%customer}}');
        $this->dropColumn('{{%customer}}', 'gender_id');
        $this->addColumn('{{%customer}}', 'gender', $this->string());
    }
}
