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
 * @var $dataFile
 */

?>
<div>

</div>
<table class="table tblSec">
    <th>id</th>
    <th>name</th>
    <th>desciprtion</th>
    <th>created_at</th>
    <?php foreach ($dataFile as $dataFile){
//        var_dump($dataFile);
//        print_r($dataSh[1]);
        ?>
        <tr>
            <td><?php echo $dataFile['id_file']; ?></td>
            <td><?php echo $dataFile['name']; ?></td>
            <td><?php echo $dataFile['location']; ?></td>
            <td><?php echo $dataFile['created_at']; ?></td>
        </tr>
    <?php }?>
</table>