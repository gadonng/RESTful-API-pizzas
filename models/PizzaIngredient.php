<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * Ingredients model
 *
 * @property integer $id
 * @property string $name
 */
class PizzaIngredient extends ActiveRecord
{
    public function getIngredient()
    {
        return $this->hasOne(Ingredient::className(), ['id' => 'ingredient_id']);
    }

    public function getPizza()
    {
        return $this->hasOne(Pizza::className(), ['id' => 'pizza_id']);
    }
}
