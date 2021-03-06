<?php

use yii\db\Schema;
use yii\db\Migration;

class m160202_085821_create_ingredient extends Migration
{
    public function up()
    {
        $this->createTable('ingredient', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
        ]);
    }

    public function down()
    {
        $this->dropTable('ingredient');
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
