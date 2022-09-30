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
 * @var $dataCupboards
 * 
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
    <?php foreach ($dataCupboards as $dataCupboards){
//        print_r($dataCupboards["_source"]);
        $id = $dataCupboards["_source"]["id_cupboards"];
        $name = $dataCupboards["_source"]["name"];
        $description = $dataCupboards["_source"]["description"];
        $location = $dataCupboards["_source"]["location"];
        $created_at = $dataCupboards["_source"]["created_at"];
        ?>
        <tr>
            <td>
                <?php
                echo Html::a($id, "list-file-elk?id=".$id); ?>
            </td>
            <td><?php echo $name; ?></td>
            <td><?php echo $description; ?></td>
            <td><?php echo $location; ?></td>
            <td><?php echo $created_at; ?></td>
        </tr>
    <?php }?>
</table>