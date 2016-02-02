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
class Ingredient extends ActiveRecord
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['name', 'required'],
            ['name', 'unique'],
            ['name', 'string', 'min' => 1, 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    public function getPizzaIngredients()
    {
        return $this->hasMany(PizzaIngredient::className(), ['ingredient_id' => 'id']);
    }

    public function getPizzas()
    {
        return $this->hasMany(Pizza::className(), ['id' => 'pizza_id'])
                    ->viaTable('pizzaIngredients');
    }
}
