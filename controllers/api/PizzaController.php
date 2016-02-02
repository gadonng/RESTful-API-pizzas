<?php

namespace app\controllers\api;

use Yii;
use yii\rest\ActiveController;
use app\models\Pizzas;

class PizzaController extends ActiveController
{
    public $modelClass = 'app\models\Pizza';
}