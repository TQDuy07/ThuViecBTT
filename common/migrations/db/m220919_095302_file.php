<?php

use yii\db\Migration;

/**
 * Class m220919_095302_file
 */
class m220919_095302_file extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('file',
        [
            'id_file' => $this->primaryKey(),
            'id_cupboards' => $this->integer(),
            'id_shelf' => $this->integer(),
            'name' => $this->string(255),
            'location' => $this->string(255),
            'created_at' => $this->dateTime()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220919_095302_file cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220919_095302_file cannot be reverted.\n";

        return false;
    }
    */
}
