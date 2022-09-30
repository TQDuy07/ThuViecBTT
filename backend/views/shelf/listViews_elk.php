<?php

use common\models\Shelf;
use yii\widgets\ListView;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use rmrevin\yii\fontawesome\FAS;

/**
 * @var $dataSh
 */


?>
<div><h2 style="color: mediumvioletred">List Shelf</h2></div>

<table class="table tblSec">
    <th>id</th>
    <th>name</th>
    <th>desciprtion</th>
    <th>location</th>
    <th>created_at</th>
    <?php foreach ($dataSh as $dataSh){
//        print_r($dataSh[1]);
        ?>
        <tr>
            <td>
                <?php
                echo Html::a($dataSh['1'], "list-cupboards-rd?id=".$dataSh['1']); ?>
            </td>
            <td><?php echo $dataSh[3]; ?></td>
            <td><?php echo $dataSh[5]; ?></td>
            <td><?php echo $dataSh[7]; ?></td>
            <td><?php echo $dataSh[9]; ?></td>
        </tr>
    <?php }?>
</table>

