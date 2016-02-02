<?php

use yii\db\Schema;
use yii\db\Migration;

class m160202_085851_create_pizza extends Migration
{
    public function up()
    {
        $this->createTable('pizza', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
        ]);
    }

    public function down()
    {
        $this->dropTable('pizza');
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
