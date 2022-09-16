<?php


use yii\helpers\Html;
use common\models\Shelf;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var Shelf $model */
/** @var ActiveForm $form */
/** @var $file_exist */
//echo getcwd();
?>
<div class="shelf-_form">
<h3 style="color: brown">Shelf</h3>
    <br>
    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'name') ?>
        <?= $form->field($model, 'description') ?>


    
        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary','onclick'=>'return checkNameShelf()']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- shelf-_form -->
<?php
if($file_exist === "true"){
    ?>
    <script>
        alert("Directory exist!!!");
    </script>
    <?php
}
?>

