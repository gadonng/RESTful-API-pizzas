<?php

use yii\db\Schema;
use yii\db\Migration;

class m160202_090003_create_junction_pizza_and_ingredient extends Migration
{
    public function up()
    {
        $this->createTable('pizza_ingredient', [
            'pizza_id' => $this->integer(),
            'ingredient_id' => $this->integer(),
            'PRIMARY KEY(pizza_id, ingredient_id)',
            'quantity' => $this->integer()->notNull(),
        ]);

        $this->createIndex('idx-pizza_ingredient-pizza_id', 'pizza_ingredient', 'pizza_id');
        $this->createIndex('idx-pizza_ingredient-ingredient_id', 'pizza_ingredient', 'ingredient_id');

        $this->addForeignKey('fk-pizza_ingredient-pizza_id', 'pizza_ingredient', 'pizza_id', 'pizza', 'id', 'CASCADE');
        $this->addForeignKey('fk-pizza_ingredient-ingredient_id', 'pizza_ingredient', 'ingredient_id', 'ingredient', 'id', 'CASCADE');
    }

    public function down()
    {
        $this->dropTable('pizza_ingredient');
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
