<?php

namespace common\models;

use common\models\query\CupboardsQuery;
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

            $path = '../../Library/'.$nameShelf."/".$model->name;

            // check actions
            $checkTrans = 0;
            $transaction = Yii::$app->db->beginTransaction();
            // Check exist directory
            $directory = "../../Library/".$nameShelf."/".$model->name;
            if (file_exists($directory)) { $checkTrans += 1; }
            if (!$model->save()){ $checkTrans += 1; }
            if(!FileHelper::createDirectory($path, $mode = 0777, $recursive = true)){ $checkTrans += 1;}
            if($checkTrans === 0)
            {
                $transaction->commit();
                return true;
            }
            else{
                $transaction->rollBack();
                return false  ;
            }
        }
    }
}
