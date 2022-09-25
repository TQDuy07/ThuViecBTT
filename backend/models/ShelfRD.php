<?php

namespace backend\models;

use common\models\Shelf;
use Yii;


/**
 * This is the model class for table "{{%shelf}}".
 *
 * @property int $id_shelf
 * @property string $name
 * @property string $description
 * @property string $location
 * @property string|null $created_at
 */
class ShelfRD extends \yii\redis\ActiveRecord
{
    /**
     * @return array the list of attributes for this record
     */
    public function attributes()
    {
        return [
            'id_shelf' ,
            'name' ,
            'description' ,
            'location' ,
            'created_at' ,
        ];
    }

    public static function primaryKey()
    {
        return ['id_shelf'];
    }

//    public function getOrders()
//    {
//        return $this->hasMany(Shelf::className(), ['customer_id' => 'id']);
//    }

    public static function find()
    {
        return new ShelfQuery(get_called_class());
    }
}
class ShelfQuery extends \yii\redis\ActiveQuery
{
    /**
     * Defines a scope that modifies the `$query` to return only active(status = 1) customers
     */
    public function active()
    {
        return $this->all();
    }
}
