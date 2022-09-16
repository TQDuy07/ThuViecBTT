<?php

use common\models\Shelf;
use yii\widgets\ListView;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use rmrevin\yii\fontawesome\FAS;

/**
 * @var $dataShelf
 */


?>
<div><h2 style="color: mediumvioletred">List Shelf</h2></div>
<?php
echo GridView::widget([
    'dataProvider' => $dataShelf,
    'columns' => [
        [
            'label'=>'id',
            'format' => 'raw',
            'value'=>function ($data) {
                return Html::a($data['id_shelf'], "list-cupboards?id=".$data['id_shelf']);
            },
        ],
        [
            'label'=>'name',
            'format' => 'raw',
            'value'=>function ($data) {
                return Html::a($data['name']);
            },
        ],
        [
            'label'=>'description',
            'format' => 'raw',
            'value'=>function ($data) {
                return Html::a($data['description']);
            },
        ],
        [
            'label'=>'location',
            'format' => 'raw',
            'value'=>function ($data) {
                return Html::a($data['location']);
            },
        ],
        [
            'label'=>'created_at',
            'format' => 'raw',
            'value'=>function ($data) {
                return Html::a($data['created_at']);
            },
        ],
//        [
//            'class' => \common\widgets\ActionColumn::class,
//            'template' => '{login} {view} {update} {delete}',
//            'options' => ['style' => 'width: 140px'],
//            'buttons' => [
//                'login' => function ($url) {
//                    return Html::a(
//                        FAS::icon('sign-in-alt', ['aria' => ['hidden' => true], 'class' => ['fa-fw']]),
//                        $url,
//                        [
//                            'title' => Yii::t('backend', 'Login'),
//                            'class' => ['btn', 'btn-xs', 'btn-secondary']
//                        ]
//                    );
//                },
//            ],
//            'visibleButtons' => [
//                'login' => Yii::$app->user->can('administrator')
//            ]
//
//        ],
    ]

]);

//print_r($dataShelf->sort);


//echo ListView::widget([
//    'dataProvider' => $dataShelf,
////    'itemView' => function($shelf){
////        return $this->render('index',[
////            'shelf' => $shelf
////        ]);
////    },
//
//]);
?>
