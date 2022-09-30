<?php

namespace common\models;

use backend\models\FileRD;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use trntv\aceeditor\AceEditor;
use Yii;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;
use function PHPUnit\Framework\equalToIgnoringCase;

/**
 * This is the model class for table "{{%file}}".
 *
 * @property int $id_file
 * @property int $id_cupboards
 * @property int $id_shelf
 * @property string $name
 * @property string $location
 * @property string $created_at
 */
class File extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%file}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_cupboards', 'id_shelf'  ], 'required'],
            [['id_cupboards'], 'integer'],
            [['created_at'], 'safe'],
//            [['name'], 'image', 'skipOnEmpty' => false],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_file' => 'Id File',
            'id_shelf' => 'Id Shelf',
            'id_cupboards' => 'Id Cupboards',
            'name' => 'Name',
            'location' => 'Location',
            'created_at' => 'Created At',
        ];
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\FileQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\FileQuery(get_called_class());
    }
    public static function sql()
    {
        return new \common\models\query\FileQuery(get_called_class());
    }

    /**
     * Get Model
     * @return File
     */
    public function getModel()
    {
        if (!$this->model) {
            $this->model = new File();
        }
        return $this->model;
    }

    public function checkSize()
    {
        $model = new File();
        $model->name = UploadedFile::getInstance($model, 'name');
        $checkSize = "true";
        $sizeFile = $model->name->size;
        if ($sizeFile > 5)
        {
            $checkSize = "false";
        }
        return $checkSize;
    }

    public function saveFile()
    {
        if ($this->validate()) {
//            $model = $this->getModel();
            $model = new File();
            $model->name = UploadedFile::getInstance($model, 'name');
            /// xu ly shelf
            $model->id_shelf = $this->id_shelf;
            $nameShelf1 = Shelf::find()
                ->select('name')
                ->where(['id_shelf' => $model->id_shelf])
                ->one();
            $nameshelf = $nameShelf1->name;
            

            /// xu ly cupboards
            $model->id_cupboards = $this->id_cupboards;
            $nameCupboards1 = Cupboards::find()
                ->select('name')
                ->where(['id_cupboards' => $model->id_cupboards])
                ->one();
            //print_r($nameShelf);
            $nameCupboards = $nameCupboards1->name;




            // xu lu location
            $model->location = $nameshelf."/".$nameCupboards."/".$model->name;

            $model->created_at = Yii::$app->formatter->asDatetime('NOW', 'php:Y-m-d H:i:s');

            $path =  "../../Library/".$nameshelf."/".$nameCupboards."/".$model->name->baseName.".".$model->name->extension;

            //check actions
//            $checkTrans = 0;
//            $transaction = Yii::$app->db->beginTransaction();

            // Check exist directory
            if (file_exists($path))
            {
                $addDate = Yii::$app->formatter->asDatetime('NOW', 'php:Y-m-d__H:i:s');
                $model->location = $nameshelf."/".$nameCupboards."/".$model->name->baseName."_".$addDate.".".$model->name->extension;

                $path = "../../Library/".$nameshelf."/".$nameCupboards."/".$model->name->baseName."_".$addDate.".".$model->name->extension;
//                chmod($model->name->tempName , 0777);
                $model->name->name = $model->name->baseName."_".$model->created_at.".".$model->name->extension;
            }
//            var_dump($model->name);
//            $model->name->tempName."<br>";
//            exit();
//            echo $path;//            echo __FILE__;
//            echo basename($model->name->tempName)."<br>";
//            echo pathinfo($model->name->tempName, PATHINFO_EXTENSION) ;
//            exit();
//            print_r($model->name);
//            exit();
//            if(!$model->save()){$checkTrans += 1;}
            copy($model->name->tempName, $path);
            chmod($path , 0777);

//            if($checkTrans === 0)
//            {
//                /*Redis*/
//                $cupboards = new FileRD();
//                $cupboards->id_file = $insert_id = Yii::$app->db->getLastInsertID();
//                $cupboards->id_cupboards = $model->id_cupboards;
//                $cupboards->id_shelf = $model->id_shelf;
//                $cupboards->name = $model->name;
//                $cupboards->location = $model->location;
//                $cupboards->created_at = $model->created_at;
//                $cupboards->save();
//                $transaction->commit();
//                return true;
//            }
//            else{
//                $transaction->rollBack();
//                return false;
//            }
            $path2 =  "Library/".$nameshelf."/".$nameCupboards."/".$model->name->baseName.".".$model->name->extension;
            $connection = new AMQPStreamConnection('docker_rabbitmq', 5672, 'guest', 'guest');
            $channel = $connection->channel();
            $channel->queue_declare('file',
                false,
                false,
                false,
                false);

            $arr = [];
            array_push($arr, $model->id_cupboards);
            array_push($arr, $model->id_shelf);
            array_push($arr, $model->name->name);
            array_push($arr, $model->location);
            array_push($arr, $model->created_at);
            array_push($arr, $path2);
            array_push($arr, $model->name->tempName);



//                echo "-------------------<br>";
            $modelJS = json_encode($arr);
//            print_r($modelJS);exit();
//                echo "-------------------<br>";
//                print_r(json_decode($modelJS));

            $msg = new AMQPMessage($modelJS);

//                print_r($msg);exit();

            $channel->basic_publish($msg, '', 'file');
            $channel->close();
            $connection->close();

            return true;
        }
    }

    public function copyFile($tempName, $path)
    {
        echo __FILE__;
        echo getcwd();
//        if(!copy($tempName, $path)){
//            return false;
//        }else{
//            return true;
//        }
    }
}
