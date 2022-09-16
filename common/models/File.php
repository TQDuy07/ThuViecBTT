<?php

namespace common\models;

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
            $checkTrans = 0;
            $transaction = Yii::$app->db->beginTransaction();

            // Check exist directory
            if (file_exists($path))
            {
                $addDate = Yii::$app->formatter->asDatetime('NOW', 'php:Y-m-d__H:i:s');
                $model->location = $nameshelf."/".$nameCupboards."/".$model->name->baseName."_".$addDate.".".$model->name->extension;

                $path = "../../Library/".$nameshelf."/".$nameCupboards."/".$model->name->baseName."_".$addDate.".".$model->name->extension;
                chmod($model->name->tempName , 0777);
                $model->name->name = $model->name->baseName."_".$model->created_at.".".$model->name->extension;
            }
//            print_r($model->name);
//            exit();
            if(!$model->save()){$checkTrans += 1;}
            if(!copy($model->name->tempName, $path)){$checkTrans += 1;}
            chmod($path , 0777);

            if($checkTrans === 0)
            {
                $transaction->commit();
                return true;
            }
            else{
                $transaction->rollBack();
                return false;
            }
        }
    }
}
