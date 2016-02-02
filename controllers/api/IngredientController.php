<?php

namespace app\controllers\api;

use Yii;
use yii\rest\ActiveController;
use app\models\Ingredients;

class IngredientController extends ActiveController
{
    public $modelClass = 'app\models\Ingredient';
}