<?php

use yii\db\Schema;
use yii\db\Migration;

class m160128_164516_create_ingredients_table extends Migration
{
    public function up()
    {
        $this->createTable('ingredients', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
        ]);
    }

    public function down()
    {
        $this->dropTable('ingredients');
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
