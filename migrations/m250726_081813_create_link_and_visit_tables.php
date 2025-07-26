<?php

use yii\db\Migration;

class m250726_081813_create_link_and_visit_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('link', [
            'id' => $this->primaryKey(),
            'url' => $this->text()->notNull(),
            'short_url' => $this->text()->notNull(),
        ]);
        $this->createTable('visit', [
            'id' => $this->primaryKey(),
            'link_id' => $this->integer()->notNull(),
            'ip' => $this->text()->notNull(),
            'counter' => $this->integer()->notNull()->defaultValue(0),
        ]);
        $this->createIndex(
            'idx-visit-link_id',
            'visit',
            'link_id'
        );
        $this->addForeignKey(
            'fk-visit-link_id',
            'visit',
            'link_id',
            'link',
            'id',
            'RESTRICT'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-visit-link_id', 'visit');
        $this->dropIndex('idx-visit-link_id', 'visit');
        $this->dropTable('visit');
        $this->dropTable('link');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250726_081813_create_link_and_visit_tables cannot be reverted.\n";

        return false;
    }
    */
}
