<?php

namespace app\controllers\api;

use Yii;
use yii\rest\ActiveController;
use app\models\Ingredient;
use app\models\Pizza;
use app\models\PizzaIngredient;
use yii\web\HttpException;
use yii\web\Link;

class PizzaController extends ActiveController
{
    public $modelClass = 'app\models\Pizza';

    /**
    * This method allows to see all the relationships for a pizza to ingredients
    * @param integer id the id of the pizza
    */

    public function actionViewLinkIngredient($id)
    {
    	$pizza = Pizza::find()->where(['id' => $id])->one();
    	if (!$pizza)
    		throw new HttpException(404, "Pizza with id:".$id.", Not found.");
    	$to_return = [
	    				'id' => $pizza->id,
	    				'name' => $pizza->name,
	    				'relationships' =>
	    				[
	    					'ingredient' => 
	    					[
	    						'data' => 
	    						[]
	    					]
	    				]
	    			];
	    $i = 0;
    	foreach ($pizza->pizzaIngredients as $pizzaIngredient) // for each relationship we set datas and links
    	{
    		$to_return['relationships']['ingredient']['data'][$i] = $pizzaIngredient->ingredient->toArray();
    		$to_return['relationships']['ingredient']['data'][$i]['quantity'] = $pizzaIngredient->quantity;
    		$to_return['relationships']['ingredient']['data'][$i][Link::REL_SELF] = $pizzaIngredient->ingredient->getLinks();
    		$i++;
    	}
    	return $to_return;
    }

    /**
    * This method allows to create relationships for a pizza to ingredients
    * @param integer id the id of the pizza
    */

    public function actionCreateLinkIngredient($id)
    {
    	$pizza = Pizza::find()->where(['id' => $id])->one();
    	if (!$pizza)
    		throw new HttpException(404, "Pizza with id:$id, Not found.");
    	$params = Yii::$app->request->bodyParams;
    	foreach ($params["data"] as $array_ingredient) {
    		$ingredient = Ingredient::find()->where(['id' => $array_ingredient["id"]])->one();
    		if (!$ingredient)
    			throw new HttpException(404, "Ingredient with id:$id, Not found.");
    		else if (!isset($array_ingredient["quantity"]))
    			throw new HttpException(409, "You must enter a quantity when assigning an ingredient to a pizza.");
    		else
    		{
    			$pizza_ingredient = PizzaIngredient::find()->where(['pizza_id' => $pizza->id, 'ingredient_id' => $ingredient->id]);
    			/*if (!$pizza_ingredient)
    			{*/
    				$pizza_ingredient = new PizzaIngredient;
    				$pizza_ingredient->pizza_id = $pizza->id;
    				$pizza_ingredient->ingredient_id = $ingredient->id;
    				$pizza_ingredient->quantity = $array_ingredient["quantity"];
    				$pizza_ingredient->save();
    			//}
    		}
    	}
    }

    /**
    * This method allows to update all relationships for a pizza to ingredients
    * @param integer id the id of the pizza
    */

    public function actionUpdateLinkIngredient($id)
    {
    	$pizza = Pizza::find()->where(['id' => $id])->one();
    	if (!$pizza)
    		throw new HttpException(404, "Pizza with id:$id, Not found.");
    	$params = Yii::$app->request->bodyParams;
    	foreach ($params["data"] as $array_ingredient) {
    		$ingredient = Ingredient::find()->where(['id' => $array_ingredient["id"]])->one();
    		if (!$ingredient)
    			throw new HttpException(404, "Ingredient with id:$id, Not found.");
    		else if (!isset($array_ingredient["quantity"]))
    			throw new HttpException(409, "You must enter a quantity when assigning an ingredient to a ingredient.");
    		else
    		{
    			$pizza_ingredient = PizzaIngredient::find()->where(['pizza_id' => $pizza->id, 'ingredient_id' => $ingredient->id]);
    			var_dump($pizza_ingredient);
    			if ($pizza_ingredient)
    			{
    				$pizza_ingredient->quantity = $array_ingredient["quantity"];
    				$pizza_ingredient->save();
    			}
    		}
    	}
    }

    /**
    * This method allows to delete relationships for a pizza to ingredients
    * @param integer id the id of the pizza
    */

    public function actionDeleteLinkIngredient($id)
    {
    	$pizza = Pizza::find()->where(['id' => $id])->one();
    	if (!$pizza)
    		throw new HttpException(404, "Pizza with id:$id, Not found.");
    	$params = Yii::$app->request->bodyParams;
    	foreach ($params["data"] as $array_ingredient) {
    		$ingredient = Ingredient::find()->where(['id' => $array_ingredient["id"]])->one();
    		if (!$ingredient)
    			throw new HttpException(404, "Ingredient with id:$id, Not found.");
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