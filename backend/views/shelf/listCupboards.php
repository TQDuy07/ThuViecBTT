<?php

use common\models\Shelf;
use yii\widgets\ListView;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use rmrevin\yii\fontawesome\FAS;
use common\models\Cupboards;
/**
 * @var $dataShelf
 * @var $name
 */

?>
<div>
    <h2 style="color: mediumvioletred"> <?php echo($name); ?></h2>
</div>
<?php
echo GridView::widget([
    'dataProvider' => $dataShelf,
    'columns' => [
        [
            'label'=>'id',
            'format' => 'raw',
            'value'=>function ($data) {
                return Html::a($data['id_cupboards'], "list-files?id=".$data['id_cupboards']);
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
    ]
]);

?>
