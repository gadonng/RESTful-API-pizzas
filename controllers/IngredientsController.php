<?php

namespace app\controllers;

use Yii;
use yii\rest\ActiveController;
use app\models\Ingredients;

class IngredientsController extends ActiveController
{
    public $modelClass = 'app\models\Ingredients';
}