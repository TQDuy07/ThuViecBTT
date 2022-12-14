<?php

namespace common\models;

use backend\models\CupboardsRD;
use common\models\query\CupboardsQuery;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use Yii;
use yii\helpers\FileHelper;

/**
 * This is the model class for table "{{%cupboards}}".
 *
 * @property int $id_cupboards
 * @property int $id_shelf
 * @property string $name
 * @property string $description
 * @property string $location
 * @property string $created_at
 */
class Cupboards extends \yii\db\ActiveRecord
{
    private $model;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%cupboards}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_shelf', 'name', 'description'], 'required'],
            [['id_shelf'], 'integer'],
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
            'id_cupboards' => 'Id Cupboards',
            'id_shelf' => 'Id Shelf',
            'name' => 'Name',
            'description' => 'Description',
            'location' => 'Location',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Get Model
     * @return Cupboards
     */
    public function getModel()
    {
        if (!$this->model) {
            $this->model = new Cupboards();
        }
        return $this->model;
    }

    /**
     * {@inheritdoc}
     * @return CupboardsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CupboardsQuery(get_called_class());
    }

    public function checkFileExist()
    {
        $model = $this->getModel();
        $model->name = trim($this->name);

        $file_exist = "false";
        if (trim($model->name) != ""){
            /// xu ly shelf
            $model->id_shelf = $this->id_shelf;
            $nameShelf1 = Shelf::find()
                ->select('name')
                ->where(['id_shelf' => $model->id_shelf])
                ->one();
            //print_r($nameShelf);
            $nameShelf = $nameShelf1->name;

            // Check exist directory
            $directory = "../../Library/".$nameShelf."/".$model->name;

            if (file_exists($directory)) {  $file_exist = "true"; }
//        print_r($directory);echo $file_exist;
//        exit();
            return $file_exist;
        }else{
            return $file_exist;
        }
    }

    public function saveCupboards()
    {
        if ($this->validate()) {
            $model = $this->getModel();
            $model->name = trim($this->name);
            $model->description = $this->description;



            /// xu ly shelf
            $model->id_shelf = $this->id_shelf;
            $nameShelf1 = Shelf::find()
                ->select('name')
            ->where(['id_shelf' => $model->id_shelf])
            ->one();
            //print_r($nameShelf);
            $nameShelf = $nameShelf1->name;

            // xu lu location
            $model->location = $nameShelf."/".$model->name;

            $model->created_at = Yii::$app->formatter->asDatetime('NOW', 'php:Y-m-d H:i:s');

            $path = 'Library/'.$nameShelf."/".$model->name;

            // check actions
//            $checkTrans = 0;
//            $transaction = Yii::$app->db->beginTransaction();
            // Check exist directory
            $directory = "../../Library/".$nameShelf."/".$model->name;
//            if (file_exists($directory)) { $checkTrans += 1; }
//            if (!$model->save()){ $checkTrans += 1; }
//            if(!FileHelper::createDirectory($path, $mode = 0777, $recursive = true)){ $checkTrans += 1;}
//            if($checkTrans === 0)
//            {
//                /*Redis*/
//                $cupboards = new CupboardsRD();
//                $cupboards->id_cupboards = $insert_id = Yii::$app->db->getLastInsertID();
//                $cupboards->id_shelf = $model->id_shelf;
//                $cupboards->name = $model->name;
//                $cupboards->description = $model->description;
//                $cupboards->location = $model->location;
//                $cupboards->created_at = $model->created_at;
//                $cupboards->save();
//                $transaction->commit();
//                return true;
//            }
//            else{
//                $transaction->rollBack();
//                return false  ;
//            }
            if (file_exists($directory)) {
                return false;
            }
            else
            {
                $connection = new AMQPStreamConnection('docker_rabbitmq', 5672, 'guest', 'guest');
                $channel = $connection->channel();
                $channel->queue_declare('cupboards',
                    false,
                    false,
                    false,
                    false);

                $arr = [];
                array_push($arr, $model->id_shelf);
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

                $channel->basic_publish($msg, '', 'cupboards');
                $channel->close();
                $connection->close();

                return true;
            }
        }
    }
}
