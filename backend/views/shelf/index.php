<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use rmrevin\yii\fontawesome\FAS;

/* @var $this yii\web\View */
/* @var $model backend\models\ShelfForm1 */


?>
<div class="card-header">
    <?php echo Html::a(FAS::icon('stream').' '.Yii::t('backend', 'List Views {modelClass}', [
            'modelClass' => '',
        ]), ['list-views'], ['class' => 'btn btn-success']) ?>
</div>

<div class="card-header" >
    <?php echo Html::a(FAS::icon('stream').' '.Yii::t('backend', 'List Views With Redis {modelClass}', [
            'modelClass' => '',
        ]), ['list-views-rd'], ['class' => 'btn btn-success','style'=>'background:red']) ?>
</div>

<div class="card-header">
    <?php echo Html::a(FAS::icon('stream').' '.Yii::t('backend', 'Add New {modelClass}', [
            'modelClass' => 'Shelf',
        ]), ['create-shelf'], ['class' => 'btn btn-success']) ?>
</div>
<div class="card-header">
    <?php echo Html::a(FAS::icon('stream').' '.Yii::t('backend', 'Add New {modelClass}', [
            'modelClass' => 'Cupboards',
        ]), ['create-cupboards'], ['class' => 'btn btn-success']) ?>
</div>
<div class="card-header">
    <?php echo Html::a(FAS::icon('stream').' '.Yii::t('backend', 'Add New {modelClass}', [
            'modelClass' => 'File',
        ]), ['create-file'], ['class' => 'btn btn-success']) ?>
</div>

