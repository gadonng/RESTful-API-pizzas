<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * PizzaIngredient model
 *
 * @property integer $pizza_id
 * @property integer $ingredient_id
 * @property integer $quantity
 */
class PizzaIngredient extends ActiveRecord
{
	public function rules()
    {
        return [
            ['quantity', 'required'],
            ['quantity', 'integer', 'min' => 1],
        ];
    }

	public static function tableName()
	{
		return "pizza_ingredient";
	}

	/**
	* Defines the relationship with the ingredients
	*/

    public function getIngredient()
    {
        return $this->hasOne(Ingredient::className(), ['id' => 'ingredient_id']);
    }

    /**
	* Defines the relationship with the pizzas
	*/

    public function getPizza()
    {
        return $this->hasOne(Pizza::className(), ['id' => 'pizza_id']);
    }
}
