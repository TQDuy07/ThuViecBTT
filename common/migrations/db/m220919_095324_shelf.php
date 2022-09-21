<?php

use yii\db\Migration;

/**
 * Class m220919_095324_shelf
 */
class m220919_095324_shelf extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('shelf',
        [
            'id_shelf' => $this->primaryKey(),
            'name' => $this->string(50)->notNull(),
            'description' => $this->string(255)->notNull(),
            'location' => $this->string(255)->notNull(),
            'created_at' => $this->dateTime(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220919_095324_shelf cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220919_095324_shelf cannot be reverted.\n";

        return false;
    }
    */
}
