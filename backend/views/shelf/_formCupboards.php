<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Cupboards $model */
/** @var ActiveForm $form */
/** @var $file_exist */

$shelfs = \common\models\Shelf::find()
    ->select('name')
    ->indexBy('id_shelf')
    ->column();

?>
<div class="shelf-_formCupboards">
    <h3 style="color: brown">Cupboards</h3>
    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'id_shelf')->dropDownList( $shelfs )->label("Name Shelf")
        ?>
        <?= $form->field($model, 'name')->label("Name Cupboards") ?>
        <?= $form->field($model, 'description')->label("Description Cupboards") ?>

    
        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'onclick' => 'return checkNameCupboards()']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- shelf-_formCupboards -->
<?php
if($file_exist === "true"){
    ?>
    <script>
        alert("Directory exist!!!");
    </script>
<?php
}
?>
