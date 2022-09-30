<?php

namespace common\models;

use backend\models\ShelfForm;
use backend\models\ShelfRD;
use common\models\query\ShelfQuery;
use kartik\widgets\Alert;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use Yii;
use yii\base\Exception;
use yii\helpers\FileHelper;

use yii\helpers\Json;

/**
 * This is the model class for table "{{%shelf}}".
 *
 * @property int $id_shelf
 * @property string $name
 * @property string $description
 * @property string $location
 * @property string $created_at
 */
class Shelf extends \yii\db\ActiveRecord
{
    private $model;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%shelf}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'description'], 'required'],
            [['name'] ,'required',
//                /**
//                 * @param name $name
//                 */
//                'when' => function ($name) {
//                    return $name == "123123";
//                },

//                'whenClient' => 'function checkName(){
//                    var shelf = document.getElementById("shelf-name").value;
//                    var regex = new RegExp("^([a-z]|[A-Z]|[0-9]|[_-])*$");
//
//                    if (!regex.test(shelf))
//                    {
//                        alert("Name không chứa khoảng trắng và kí tự đặt biệt, có thể chứa [ _- ] !!! ");
//                        return false;
//                    }
//                }'
            ],
            [['created_at'], 'safe'],
            [['name'], 'string', 'max' => 50],
            [['description', 'location'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_shelf' => 'Id Shelf',
            'name' => 'Name',
            'description' => 'Description',
            'location' => 'Location',
            'created_at' => 'Created At',
        ];
    }

    /**
     * {@inheritdoc}
     * @return ShelfQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ShelfQuery(get_called_class());
    }

    /**
     * Get Model
     * @return Shelf
    */
    public function getModel()
    {
        if (!$this->model) {
            $this->model = new Shelf();
        }
        return $this->model;
    }
    public function checkFileExist()
    {
        $model = $this->getModel();
        $file_exist = "false";
        if (trim($model->name) != ""){

            $model->location = $model->name;

            $model->created_at = Yii::$app->formatter->asDatetime('NOW', 'php:Y-m-d H:i:s');

            $path = '../../Library/'.$model->name;

            // check actions
            $checkTrans = 0;
            $transaction = Yii::$app->db->beginTransaction();
            // Check exist directory
            $directory = "../../Library/".$model->name;
            if (file_exists($directory)) {  $file_exist = "true"; }
            return $file_exist;
        }else{
            return $file_exist;
        }
    }

    public function queuesShelf()
    {
//        if(Yii::$app->queues->push(new ShelfRB([
//            'name' => 'Shelf',
//            'message' => 'Create new shelf',
//        ])))
//        {
//            echo "ok";
//        }else{echo "noy ok";}
        Yii::$app->queues->push(new ShelfRB([
            'name' => 'Shelf',
            'message' => 'Create new shelf',
        ]));
    }
    public function setModel()
    {
        $model = $this->getModel();
        $model->name = trim($this->name);
        $model->description = $this->description;
        $model->location = $model->name;
        $model->created_at = Yii::$app->formatter->asDatetime('NOW', 'php:Y-m-d H:i:s');
        $path = '../../Library/'.$model->name;
        return $model;
    }
    public function saveShelf()
    {
        if ($this->validate()) {
            $model = $this->getModel();
            $model->name = trim($this->name);
            $model->description = $this->description;
            $model->location = $model->name;

            $model->created_at = Yii::$app->formatter->asDatetime('NOW', 'php:Y-m-d H:i:s');



            $path = 'Library/'.$model->name;

            // check actions
//            $checkTrans = 0;
//            $transaction = Yii::$app->db->beginTransaction();
            // Check exist directory
            $directory = "../../Library/".$model->name;
            ///////queues
//            if (file_exists($directory)) { $checkTrans += 1; }
//            if (!$model->save()){ $checkTrans += 1; }else{$insert_id = Yii::$app->db->getLastInsertID();}
//            if(!FileHelper::createDirectory($path, $mode = 0775, $recursive = true)){ $checkTrans += 1;}
//            if($checkTrans === 0)
//            {
//                /*Redis*/
//                $shelf = new ShelfRD();
//                $shelf->id_shelf = $insert_id;
//                $shelf->name = $model->name;
//                $shelf->description = $model->description;
//                $shelf->location = $model->location;
//                $shelf->created_at = $model->created_at;
//                $shelf->save();
//                $transaction->commit();
//                return true;
//            }
//            else{
//                $transaction->rollBack();
//                return false;
//            }

            if (file_exists($directory)) {
                return false;
            }
            else
            {
                $connection = new AMQPStreamConnection('docker_rabbitmq', 5672, 'guest', 'guest');
                $channel = $connection->channel();
                $channel->queue_declare('shelf',
                    false,
                    false,
                    false,
                    false);

                $arr = [];
                array_push($arr, $model->name);
                array_push($arr, $model->description);
                array_push($arr, $model->location);
                array_push($arr, $model->created_at);
                array_push($arr, $path);


//                print_r($arr);
//                echo "-------------------<br>";
                $modelJS = json_encode($arr);
//                print_r($modelJS);
//                echo "-------------------<br>";
//                print_r(json_decode($modelJS));

                $msg = new AMQPMessage($modelJS);

//                print_r($msg);exit();

                $channel->basic_publish($msg, '', 'shelf');
                $channel->close();
                $connection->close();

                return true;
            }
        }

    }



}
