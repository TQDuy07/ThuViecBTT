<?php

namespace backend\models;

use common\models\Shelf;
use Yii;


/**
 * This is the model class for table "{{%shelf}}".
 *
 * @property int $id_file
 * @property int $id_cupboards
 * @property int $id_shelf
 * @property string $name
 * @property string $location
 * @property string|null $created_at
 */
class FileRD extends \yii\redis\ActiveRecord
{
    /**
     * @return array the list of attributes for this record
     */
    public function attributes()
    {
        return [
            'id_file',
            'id_cupboards',
            'id_shelf' ,
            'name' ,
            'location' ,
            'created_at' ,
        ];
    }

    public static function primaryKey()
    {
        return ['id_file'];
    }

//    public function getOrders()
//    {
//        return $this->hasMany(Shelf::className(), ['customer_id' => 'id']);
//    }

    public static function find()
    {
        return new FileQuery(get_called_class());
    }
}
class FileQuery extends \yii\redis\ActiveQuery
{
    /**
     * Defines a scope that modifies the `$query` to return only active(status = 1) customers
     */
    public function active()
    {
        return $this->all();
    }
}
