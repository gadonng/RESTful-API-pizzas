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
class Ingredients extends ActiveRecord
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
}
