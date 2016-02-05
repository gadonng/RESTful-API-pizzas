<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\Link;
use yii\web\Linkable;
use yii\helpers\Url;

/**
 * Pizza model
 *
 * @property integer $id
 * @property string $name
 */
class Pizza extends ActiveRecord
{

    /**
    * Rules of validation
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
    * Gives the table name for accessing the model in db
    */

    public static function tableName()
    {
        return "pizza";
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
    * Defines the relationshîp with the junction table pizza_ingredient
    */

    public function getPizzaIngredients()
    {
        return $this->hasMany(PizzaIngredient::className(), ['pizza_id' => 'id']);
    }

    /**
    * Defines the relationship with the ingredients
    */

    public function getIngredients()
    {
        return $this->hasMany(Ingredient::className(), ['id' => 'ingredient_id'])
                    ->via('pizzaIngredients'); // the relationship needs the junction table to work
    }

    /**
    * Makes the relationships available with the expand property in the Ingredients routes.
    *
    */

    public function extraFields()
    {
        $fields = parent::fields();
        $fields['relationships']['ingredient'] = function($pizza){
            $to_return['data'] = [];
            $i = 0;
            foreach ($pizza->pizzaIngredients as $pizzaIngredient) // for each relationship we set datas and links
            {
                $to_return['data'][$i] = $pizzaIngredient->ingredient->toArray();
                $to_return['data'][$i]['quantity'] = $pizzaIngredient->quantity;
                $to_return['data'][$i][Link::REL_SELF] = $pizzaIngredient->ingredient->getLinks();
                $i++;
            }
        };
        return $fields;
    }

    /**
    * Creates the Links for accessing Pizza elements 
    */

    public function getLinks()
    {
        return [
            Link::REL_SELF => Url::base(true).'/pizzas/'.$this->id,
        ];
    }
}
