<?php

use yii\data\SqlDataProvider;
use yii\grid\GridView;
use yii\widgets\DetailView;
use yii\helpers\Html;
use common\models\File;
use yii\data\ActiveDataProvider;
use yii\db\Query;


/**
 * @var $provider
 */


/////////////////////////////////////////// model File
?>
<div><h2>List File</h2></div>
<?php


echo GridView::widget([
    'dataProvider' => $provider,
//    'totalCount' => $countFile,
    'columns' => [
        [
            'label'=>'id',
            'format' => 'raw',
            'value'=>function ($data) {
                return Html::a($data['id_file']);
            },
        ],
        [
            'label'=>'Name File',
            'format' => 'raw',
            'value'=>function ($data) {
                return Html::a($data['nameFile']);
            },
        ],

        [
            'label'=>'Name Shelf',
            'format' => 'raw',
            'value'=>function ($data) {
                return Html::a($data['nameShelf']);
            },
        ],
        [
            'label'=>'Name Cupboards',
            'format' => 'raw',
            'value'=>function ($data) {
                return Html::a($data['nameCupboards']);
            },
        ],
        [
            'label'=>'location',
            'format' => 'raw',
            'value'=>function ($data) {
                return Html::a($data['locationFile']);
            },
        ],
        [
            'label'=>'created_at',
            'format' => 'raw',
            'value'=>function ($data) {
                return Html::a($data['created_atFile']);
            },
        ],
    ]
]);
