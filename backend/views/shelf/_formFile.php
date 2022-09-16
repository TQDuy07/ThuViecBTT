<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\File $model */
/** @var ActiveForm $form
 *  @var $selectedShelf
 *  @var $sizeFile
// *  @var $cupboards
 */

$shelfs = \common\models\Shelf::find()
    ->select('name')
    ->indexBy('id_shelf')
    ->column();

$cupboards = \common\models\Cupboards::find()
    ->select('name')
    ->where(['id_shelf' => $selectedShelf])
    ->indexBy('id_cupboards')
    ->column();
//echo $selectedShelf."shelf"."<br>";
//echo $selectedShelf."shelf";
?>

<div class="shelf-_formFile">
    <h3 style="color: brown">File</h3>
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
        <?= $form->field($model, 'id_shelf')->dropDownList($shelfs,
            ['prompt'=>'Select Shelf',
                'onchange'=>'changeCupboards()',
                 'options' => [$selectedShelf=>['selected'=>true]]
            ],

            [

            ]

        )->label("Name Shelf") ?>
<!--    --><?//= $form->dropDownList($model,'id_shelf',$shelfs, array('options' => array('2'=>array('selected'=>true))))?>
        <div id="" >
            <input id="shelf" name="selectedShelf" value="noShelf" type="hidden">
        </div>

        <?= $form->field($model, 'id_cupboards')->dropDownList(  $cupboards )->label('Name Cupboards') ?>
        <?= $form->field($model, 'name')->fileInput()->label('Choose File Upload') ?>
    
        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- shelf-_formFile -->

<script>
    var select = document.getElementById('file-id_shelf').text;
    // var shelf = select.options[select.selectedIndex].value;
    var valueShelf = document.getElementById('shelf');
    var form = document.getElementById('w0');

    // let htmlInput = "<input type=\"text\" id=\"selectedShelf\" class=\"form-control\" name=\"selectedShelf\" value=\"selectedShelf\" > ";
    function changeCupboards() {
        // valueShelf.innerHTML = htmlInput;
        valueShelf.value = "yesShelf";
        form.submit();

    }
</script>

<?php
if($sizeFile == "false"){
    ?>
    <script>
        alert("File must be less than 100MB !!!");
    </script>
    <?php
}
?>