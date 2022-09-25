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

//print_r($dataShelf);

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

<!--<menu>-->
<!--    <button onclick="showShelf()">Library</button>-->
<!---->
<!--    --><?php
////    for( $i=0;$i < 5;$i++){?>
<!--    <div  style="margin-left: 50px">-->
<!--        <input  onclick="showCupboards()" class="shelf" type="button" value="--><?php //echo "Phim"; ?><!--"> </div>-->
<!--<!--    -->--><?php ////}?>
<!---->
<!--    <div  style="margin-left: 100px"><input onclick="showFile()" id="cupboards" type="hidden" value="phan_1"> </div>-->
<!--    <div  style="margin-left: 150px"><input  id="file" type="hidden" value="tap_1"> </div>-->
<!--</menu>-->
<script>
    function showShelf()
    {

        // var shelf = document.getElementById('shelf');
        var shelf = document.querySelectorAll(''`[class^="shelf"]`);
        var cupboards = document.getElementById('cupboards');
        var file = document.getElementById('file');
        if(shelf.type == "button")
        {
            shelf.type = "hidden";
            cupboards.type = "hidden";
            file.type = "hidden";
        }else {
            shelf.type = "button";
        }

    }
    function showCupboards()
    {
        if(cupboards.type == "button")
        {
            cupboards.type = "hidden";
            file.type = "hidden";
        }else {
            cupboards.type = "button";
        }

    }
    function showFile()
    {
        if(file.type == "button")
        {
            file.type = "hidden";
        }else {
            file.type = "button";
        }
    }
</script>
