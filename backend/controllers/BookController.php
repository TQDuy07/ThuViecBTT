<?php

namespace backend\controllers;

use Codeception\Command\Console;
use common\models\Book;
use yii\data\ActiveDataProvider;
use yii\rest\ActiveController;
use yii\filters\auth\HttpBasicAuth;


class BookController extends ActiveController
{

    public $modelClass = Book::class;

    public function actionAddBook($name, $author)
    {
        $security = \Yii::$app->security;
        $book = new Book();
        $book->name = $name;
        $book->author = $author;
        if ($book->save())
        {
            echo "asdas";
        }
        else
        {
            var_dump($book->errors);
        }
    }

    public function actions() {
        $actions = parent::actions();
        // không cho người dùng xóa và tạo dữ liệu
        unset($actions['delete'], $actions['create']);
        // lấy các thành phần truy vấn ví dụ như là truy vấn với tham số như
        // lấy dữ liệu với status la active :
        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];
        return $actions;
    }

    public function prepareDataProvider()
    {
        $query = Book::find()->where('id >= :id',[':id' => '5']);
        return new ActiveDataProvider(['query' => $query,]);
    }

    public function actionCreate()
    {
        echo "asdasD";
    }

    /*
     * Page Index
     */
    public function actionIndex()
    {

        return new ActiveDataProvider([
            'query' => Book::find(),
        ]);
    }

    public function actionView($id)
    {
        return Book::findOne($id);
    }


    protected function verbs()
    {
        return [
            'index' => ['GET', 'HEAD'],
            'view' => ['GET', 'HEAD'],
            'create' => ['POST'],
            'update' => ['PUT', 'PATCH'],
            'delete' => ['DELETE'],
        ];
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        // remove authentication filter
        $auth = $behaviors['authenticator'];
        unset($behaviors['authenticator']);

        // add CORS filter
        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::class,
        ];

        // re-add authentication filter
        $behaviors['authenticator'] = $auth;
        // avoid authentication on CORS-pre-flight requests (HTTP OPTIONS method)
        $behaviors['authenticator']['except'] = ['options'];

        return $behaviors;
    }


}
