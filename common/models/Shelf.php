<?php

namespace common\models;
use Yii;
use yii\base\BaseObject;

class Shelf extends BaseObject implements \yii\queue\JobInterface
{
    public $message;
    public $phone;

    public function execute($queue)
    {
//echo "asd";
        for($i=0;$i<=5;$i++){
            echo $i.$this->message.' Inserted'.PHP_EOL;
            $sql = Yii::$app->db->createCommand()->insert('shelf',[
                'name' => '111',
                'description' => '111',
                'location' => '111',
                'created_at' => '2022-09-22 10:11:57'

            ])->execute();
        }

    }
}






//
//namespace common\models;
//
//use backend\models\ShelfForm;
//use backend\models\ShelfRD;
//use common\models\query\ShelfQuery;
//use kartik\widgets\Alert;
//use Yii;
//use yii\base\Exception;
//use yii\helpers\FileHelper;
//
///**
// * This is the model class for table "{{%shelf}}".
// *
// * @property int $id_shelf
// * @property string $name
// * @property string $description
// * @property string $location
// * @property string $created_at
// */
//class Shelf extends \yii\db\ActiveRecord
//{
//    private $model;
//    /**
//     * {@inheritdoc}
//     */
//    public static function tableName()
//    {
//        return '{{%shelf}}';
//    }
//
//    /**
//     * {@inheritdoc}
//     */
//    public function rules()
//    {
//        return [
//            [['name', 'description'], 'required'],
//            [['name'] ,'required',
////                /**
////                 * @param name $name
////                 */
////                'when' => function ($name) {
////                    return $name == "123123";
////                },
//
////                'whenClient' => 'function checkName(){
////                    var shelf = document.getElementById("shelf-name").value;
////                    var regex = new RegExp("^([a-z]|[A-Z]|[0-9]|[_-])*$");
////
////                    if (!regex.test(shelf))
////                    {
////                        alert("Name không chứa khoảng trắng và kí tự đặt biệt, có thể chứa [ _- ] !!! ");
////                        return false;
////                    }
////                }'
//            ],
//            [['created_at'], 'safe'],
//            [['name'], 'string', 'max' => 50],
//            [['description', 'location'], 'string', 'max' => 255],
//        ];
//    }
//
//    /**
//     * {@inheritdoc}
//     */
//    public function attributeLabels()
//    {
//        return [
//            'id_shelf' => 'Id Shelf',
//            'name' => 'Name',
//            'description' => 'Description',
//            'location' => 'Location',
//            'created_at' => 'Created At',
//        ];
//    }
//
//    /**
//     * {@inheritdoc}
//     * @return ShelfQuery the active query used by this AR class.
//     */
//    public static function find()
//    {
//        return new ShelfQuery(get_called_class());
//    }
//
//    /**
//     * Get Model
//     * @return Shelf
//    */
//    public function getModel()
//    {
//        if (!$this->model) {
//            $this->model = new Shelf();
//        }
//        return $this->model;
//    }
//    public function checkFileExist()
//    {
//        $model = $this->getModel();
//        $file_exist = "false";
//        if (trim($model->name) != ""){
//
//            $model->location = $model->name;
//
//            $model->created_at = Yii::$app->formatter->asDatetime('NOW', 'php:Y-m-d H:i:s');
//
//            $path = '../../Library/'.$model->name;
//
//            // check actions
//            $checkTrans = 0;
//            $transaction = Yii::$app->db->beginTransaction();
//            // Check exist directory
//            $directory = "../../Library/".$model->name;
//            if (file_exists($directory)) {  $file_exist = "true"; }
//            return $file_exist;
//        }else{
//            return $file_exist;
//        }
//    }
//
//    public function saveShelf()
//    {
//        if ($this->validate()) {
//            $model = $this->getModel();
//            $model->name = trim($this->name);
//            $model->description = $this->description;
//            $model->location = $model->name;
//
//            $model->created_at = Yii::$app->formatter->asDatetime('NOW', 'php:Y-m-d H:i:s');
//
//
//
//            $path = '../../Library/'.$model->name;
//
//            // check actions
//            $checkTrans = 0;
//            $transaction = Yii::$app->db->beginTransaction();
//            // Check exist directory
//            $directory = "../../Library/".$model->name;
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
//
//        }
//
//    }
//
//
//
//}
