<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\MarriageCertificateSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="marriage-certificate-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

     <div class="row">
            <div class="col-sm-12"  style="margin-top: 10px;margin-bottom: -35px;">
                <div class='col-sm-2 form-group' >
                    <?= $form->field($model, 'wedding_venue')->textInput(['maxlength' => true,'placeholder'=>true])->label(false)  ?>
                </div>
                <div class="col-sm-3 form-group">
                    <?= $form->field($model, 'created_at')->textInput(['maxlength' => true,'placeholder'=>'Wedding Date(From)'])->label(false) ?>
                </div>
                <div class="col-sm-3 form-group">
                    <?= $form->field($model, 'updated_at')->textInput(['maxlength' => true,'placeholder'=>'Wedding Date(To)'])->label(false) ?>
                </div>
                <div class="form-group col-sm-4">
                    <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
                    <?= Html::submitButton('Download', ['class' => 'btn btn-success','name'=>'download']) ?>
                    <?= Html::a('Reset', ['index'],['class' => 'btn btn-default']) ?>
                </div>
            </div>            
        </div>
        <hr style="border-color: #ddd;">

    <?php ActiveForm::end(); ?>

</div>
