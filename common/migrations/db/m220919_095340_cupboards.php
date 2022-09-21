<?php

use yii\db\Migration;

/**
 * Class m220919_095340_cupboards
 */
class m220919_095340_cupboards extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('cupboards',
        [
            'id_cupboards' => $this->primaryKey(),
            'id_shelf' => $this->integer(),
            'name' => $this->string(255),
            'description' => $this->string(255),
            'location' => $this->string(255),
            'created_at' => $this->dateTime()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220919_095340_cupboards cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220919_095340_cupboards cannot be reverted.\n";

        return false;
    }
    */
}
