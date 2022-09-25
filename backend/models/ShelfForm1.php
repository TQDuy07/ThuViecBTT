<?php

namespace backend\models;

use Yii;
use yii\base\Model;

class ShelfForm1 extends Model
{
    public $name;
    public $description;
    public $location;
    public $created_at;

    private $model;

    public function rules()
    {
        return [
            [['name', 'email'], 'required'],
            ['email', 'email'],
        ];
    }
    public function save()
    {
echo "asd";
    }
}