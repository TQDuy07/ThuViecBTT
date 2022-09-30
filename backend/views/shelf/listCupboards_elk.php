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
 * @var $dataCup
 * @var $dataCupCount
 */

?>
<div>

</div>
<table class="table tblSec">
    <th>id</th>
    <th>name</th>
    <th>desciprtion</th>
    <th>location</th>
    <th>created_at</th>
    <?php foreach ($dataCup as $dataCup){
//        var_dump($dataCup);
//        print_r($dataSh[1]);
        ?>
        <tr>
            <td>
                <?php
                echo Html::a($dataCup['id_cupboards'], "list-files-rd?id=".$dataCup['id_cupboards']); ?>
            </td>
<!--            <td>--><?php //echo $dataCup['id_shelf']; ?><!--</td>-->
            <td><?php echo $dataCup['name']; ?></td>
            <td><?php echo $dataCup['description']; ?></td>
            <td><?php echo $dataCup['location']; ?></td>
            <td><?php echo $dataCup['created_at']; ?></td>
        </tr>
    <?php }?>
</table>