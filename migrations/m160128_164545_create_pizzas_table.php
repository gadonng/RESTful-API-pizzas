<?php

use yii\db\Schema;
use yii\db\Migration;

class m160128_164545_create_pizzas_table extends Migration
{
    public function up()
    {
        $this->createTable('pizzas', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
        ]);
    }

    public function down()
    {
        $this->dropTable('pizzas');
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
