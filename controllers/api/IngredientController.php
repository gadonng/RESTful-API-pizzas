<?php

namespace app\controllers\api;

use Yii;
use yii\rest\ActiveController;
use app\models\Ingredient;
use app\models\Pizza;
use app\models\PizzaIngredient;
use yii\web\HttpException;
use yii\web\Link;

class IngredientController extends ActiveController
{
    public $modelClass = 'app\models\Ingredient';

    /**
    * This method allows to see all the relationships for an ingredient to pizzas
    * @param integer id the id of the ingredient
    */

    public function actionViewLinkPizza($id)
    {
    	$ingredient = Ingredient::find()->where(['id' => $id])->one();
    	if (!$ingredient)
    		throw new HttpException(404, "Ingredient with id:".$id.", Not found.");
    	$to_return = [
	    				'id' => $ingredient->id,
	    				'name' => $ingredient->name,
	    				'relationships' =>
	    				[
	    					'pizza' => 
	    					[
	    						'data' => 
	    						[]
	    					]
	    				]
	    			];
	    $i = 0;
    	foreach ($ingredient->pizzaIngredients as $pizzaIngredient)
    	{
    		$to_return['relationships']['pizza']['data'][$i] = $pizzaIngredient->pizza->toArray();
    		$to_return['relationships']['pizza']['data'][$i]['quantity'] = $pizzaIngredient->quantity;
    		$to_return['relationships']['pizza']['data'][$i][Link::REL_SELF] = $pizzaIngredient->pizza->getLinks();
    		$i++;
    	}
    	return $to_return;
    }

    /**
    * This method allows to create relationships for an ingredient to pizzas
    * @param integer id the id of the ingredient
    */

    public function actionCreateLinkPizza($id)
    {
    	$ingredient = Ingredient::find()->where(['id' => $id])->one();
    	if (!$ingredient)
    		throw new HttpException(404, "Ingredient with id:$id, Not found.");
    	$params = Yii::$app->request->bodyParams;
    	foreach ($params["data"] as $array_pizza) {
    		$pizza = Pizza::find()->where(['id' => $array_pizza["id"]])->one();
    		if (!$pizza)
    			throw new HttpException(404, "Pizza with id:$id, Not found.");
    		else if (!isset($array_pizza["quantity"]))
    			throw new HttpException(409, "You must enter a quantity when assigning an ingredient to a pizza.");
    		else
    		{
    			$pizza_ingredient = PizzaIngredient::find()->where(['pizza_id' => $pizza->id, 'ingredient_id' => $ingredient->id]);
    			/*if (!$pizza_ingredient)
    			{*/
    				$pizza_ingredient = new PizzaIngredient;
    				$pizza_ingredient->pizza_id = $pizza->id;
    				$pizza_ingredient->ingredient_id = $ingredient->id;
    				$pizza_ingredient->quantity = $array_pizza["quantity"];
    				$pizza_ingredient->save();
    			//}
    		}
    	}
    }

    /**
    * This method allows to update relationships for an ingredient to pizzas
    * @param integer id the id of the ingredient
    */

    public function actionUpdateLinkPizza($id)
    {
    	$ingredient = Ingredient::find()->where(['id' => $id])->one();
    	if (!$ingredient)
    		throw new HttpException(404, "Ingredient with id:$id, Not found.");
    	$params = Yii::$app->request->bodyParams;
    	foreach ($params["data"] as $array_pizza) {
    		$pizza = Pizza::find()->where(['id' => $array_pizza["id"]])->one();
    		if (!$pizza)
    			throw new HttpException(404, "Pizza with id:$id, Not found.");
    		else if (!isset($array_pizza["quantity"]))
    			throw new HttpException(409, "You must enter a quantity when assigning an ingredient to a pizza.");
    		else
    		{
    			$pizza_ingredient = PizzaIngredient::find()->where(['pizza_id' => $pizza->id, 'ingredient_id' => $ingredient->id]);
    			if ($pizza_ingredient)
    			{
    				$pizza_ingredient->quantity = $array_pizza["quantity"];
    				$pizza_ingredient->save();
    			}
    		}
    	}
    }

    /**
    * This method allows to delete relationships for an ingredient to pizzas
    * @param integer id the id of the ingredient
    */

    public function actionDeleteLinkPizza($id)
    {
    	$ingredient = Ingredient::find()->where(['id' => $id])->one();
    	if (!$ingredient)
    		throw new HttpException(404, "Ingredient with id:$id, Not found.");
    	$params = Yii::$app->request->bodyParams;
    	foreach ($params["data"] as $array_pizza) {
    		$pizza = Pizza::find()->where(['id' => $array_pizza["id"]])->one();
    		if (!$pizza)
    			throw new HttpException(404, "Pizza with id:$id, Not found.");
    		else if (!isset($array_pizza["quantity"]))
    			throw new HttpException(409, "You must enter a quantity when assigning an ingredient to a pizza.");
    		else
    		{
    			$pizza_ingredient = PizzaIngredient::find()->where(['pizza_id' => $pizza->id, 'ingredient_id' => $ingredient->id]);
    			if ($pizza_ingredient)
    			{
    				$pizza_ingredient->delete();
    			}
    		}
    	}
    }
}