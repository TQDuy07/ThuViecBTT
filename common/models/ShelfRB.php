<?php
namespace common\models;

use backend\models\ShelfRD;
use Faker\Factory;
use yii\base\BaseObject;
use Yii;
use common\models\Shelf;
use yii\helpers\FileHelper;

class ShelfRB extends BaseObject implements \yii\queue\JobInterface
{
    public $name;
    public $description;
    public $location;
    public $created_at;
    public $path;
//    public $insert_id;
    public $message;

    public function execute($queue)
    {

        $model = new Shelf();
        $model->name = $this->name;
        $model->description = $this->description;
        $model->location = $this->location;
        $model->created_at = $this->created_at;
        $path = $this->path;
        FileHelper::createDirectory($path);
        chmod($path , 0777);
        $model->save();






//        for($i=0;$i<=5;$i++){
            echo $this->message.' Inserted success'.PHP_EOL;
//            $sql = Yii::$app->db->$queue->execute();
//        }



//        print_r($shelf);
//        exit();
//        Yii::$app->db->$queue->execute($shelf->saveShelf());
    }
}