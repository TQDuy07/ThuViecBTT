<?php

namespace backend\controllers;

use backend\models\CupboardsRD;
use backend\models\FileRD;
//use backend\models\ShelfForm;
use common\models\Cupboards;
use common\models\File;
use common\models\Shelf;
use common\models\ShelfRB;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\data\SqlDataProvider;
use yii\data\ActiveDataProvider;
use yii\redis\Connection;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;


class ShelfController extends Controller
{
    public function actionCreate()
    {
        return $this->render('create');
    }
    public function actionCreateShelf()
    {


//        Yii::$app->cache->set('duy', 123123);
        $model = new Shelf();
//        $model->setScenario('create');
        if ($model->load(Yii::$app->request->post()) && $model->saveShelf()) {
            return $this->redirect(['index']);
        }
        $file_exist = $model->checkFileExist();

        return $this->render('_form',[
            'model' => $model,
            'file_exist' => $file_exist,
        ]);
    }

    public function actionCreateCupboards()
    {
        $model = new Cupboards();
//        $model->setScenario('create');
        if ($model->load(Yii::$app->request->post()) && $model->saveCupboards()) {
            return $this->redirect(['index']);
        }

        $file_exist = $model->checkFileExist();
//        if(!$file_exist == "false"){

        return $this->render('_formCupboards',[
            'model' => $model,
            'file_exist' => $file_exist
        ]);
    }

    public function actionCreateFile()
    {
        $model = new File();
        // CHECK USER-SELECTED
        $checkShelf = Yii::$app->request->post('selectedShelf');
        $selectedShelf = "no";
        if($checkShelf == "yesShelf"){
            // shelf SELECTED
            $chooseShelf = Yii::$app->request->post('File')['id_shelf'];
            $selectedShelf = $chooseShelf;

        }else {
            $sizeFile = $model->checkSize();
            if ($sizeFile == "true" && $model->load(Yii::$app->request->post()))
            {
                if ($model->load(Yii::$app->request->post()) && $model->saveFile()) {
                    return $this->redirect(['index']);
                }
            }
        }




        return $this->render('_formFile',[
            'model' => $model,
            'selectedShelf' => $selectedShelf,
            'chooseShelf' => $chooseShelf,
            'sizeFile' => $sizeFile
        ]);
    }

    public function actionIndex()
    {
        //echo "da vao";
        return $this->render('index');
    }

    public function actionListViews()
    {
        $dataShelf = new ActiveDataProvider([
            'query' => Shelf::find(),
            'sort' => ['attributes' => ['id_shelf']],
            'pagination' => [
                'pageSize' => 10,
            ]
        ]);
        /////////////////////////show tree folder
        $sqlShelf = Yii::$app->db->createCommand('SELECT * FROM shelf')->queryAll();

        return $this->render('listViews',
        [
            'dataShelf' => $dataShelf,
            'sqlShelf' => $sqlShelf,

        ]);
    }


    public function actionListCupboards()
    {
        $id = Yii::$app->request->get();
        $dataShelf = new ActiveDataProvider([
            'query' => Cupboards::find()->where(['id_shelf' => $id]),
            'sort' => ['attributes' => ['id_cupboards']],
            'pagination' => [
                'pageSize' => 10,
            ]
        ]);

        $model = $dataShelf->getModels();
        $name = $model['name'];

        $id1 =$id['id'];

        $sqlShelf = Yii::$app->db->createCommand('SELECT name FROM shelf where id_shelf ='.$id1)->queryOne();
        $name  = $sqlShelf['name'];

        return $this->render('listCupboards',
        [
            'id' => $id,
            'dataShelf' => $dataShelf,
            'name' => $name

        ]);
    }

    public function actionListFiles()
    {
        $result = Yii::$app->request->get();
//        print_r(Yii::$app->request->get());
        $idCup = $result['id'];
        $id = $result['id'];

        $nameCup1 = Yii::$app->db->createCommand('SELECT cupboards.name as "nameCup", shelf.name as "nameShelf" 
FROM cupboards 
LEFT JOIN shelf
ON cupboards.id_shelf = shelf.id_shelf
where cupboards.id_cupboards ='.$idCup)->queryOne();
        $nameCup  = $nameCup1['nameCup'];
        $nameShelf = $nameCup1['nameShelf'];


        $count = Yii::$app->db->createCommand('
            SELECT COUNT(*) FROM file 
        ')->queryScalar();

        $provider = new SqlDataProvider([
            'sql' => 'SELECT *,file.created_at as "created_atFile",file.location as "locationFile" , cupboards.name as "nameCupboards" , shelf.name as "nameShelf" , file.name as "nameFile"
            FROM `file` 
            LEFT JOIN cupboards
            ON cupboards.id_cupboards = file.id_cupboards
            LEFT JOIN shelf
            ON cupboards.id_shelf = shelf.id_shelf
            
            WHERE file.id_cupboards = :idCup',
            'params' => [':idCup' => $id],
            'totalCount' => $count,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
//        print_r($provider->sql);

        $models = $provider->getModels();
//print_r($provider);exit();
        return $this->render('listFiles',
            [
                'id' => $id,
                'provider' => $provider,
                'model' => $models,
                'nameCup' => $nameCup,
                'nameShelf'=>$nameShelf
            ]);
    }

    //////////////////////////REDISSSSS????

    public function actionListViewsRd()
    {
        $redis = Yii::$app->redis;

        $idShelf =  $redis->executeCommand('LRANGE',['shelf_rd', '0', '-1']);

        $dataSh = array();
        foreach ($idShelf as $id_Sh){
            $rowShelf =  $redis->executeCommand('HGETALL',[ 'shelf_rd:a:'.$id_Sh]);
            $dataSh[$id_Sh] = $rowShelf;
        }
        return $this->render('listViews_rd',
            [
                'dataSh' => $dataSh,
            ]);
    }
    public function actionListCupboardsRd()
    {
        $idReq = Yii::$app->request->get();

        $redis = Yii::$app->redis;
        $dataCup = new CupboardsRD();
        $dataCupCount = new CupboardsRD();
        $dataCupCount = CupboardsRD::find()->where(['id_shelf' => $idReq])->count();
        $dataCup = CupboardsRD::find()->where(['id_shelf' => $idReq])->asArray()->all();

        return $this->render('listCupboards_rd',
            [
                'dataCup' => $dataCup,
                'dataCupCount'=>$dataCupCount,
            ]);
    }
    public function actionListFilesRd()
    {
        $idReq = Yii::$app->request->get();

        $redis = Yii::$app->redis;
        $dataFile = new FileRD();
        $dataFile = FileRD::find()->where(['id_cupboards' => $idReq])->asArray()->all();

        return $this->render('listFile_rd',
            [
                'dataFile' => $dataFile,
            ]);
    }
}
