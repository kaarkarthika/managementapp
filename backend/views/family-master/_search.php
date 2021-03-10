<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\FamilyMasterSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="family-master-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <div class="row">            
            <div class="col-sm-12" style="margin-top: 10px;margin-bottom: -35px;">
                <div class='col-sm-2 form-group' >
                    <?= $form->field($model, 'familyHeadName')->textInput(['maxlength' => true,'placeholder'=>true])->label(false)  ?>
                </div>
                <div class="col-sm-2 form-group">
                    <?= $form->field($model, 'contactNumber')->textInput(['maxlength' => true,'onkeypress'=>'return isNumberKey(event)','placeholder'=>true])->label(false) ?>
                </div>
                <div class="col-sm-2 form-group">
                    <?= $form->field($model, 'createdAt')->textInput(['maxlength' => true,'placeholder'=>'From Date'])->label(false) ?>
                </div>
                <div class="col-sm-2 form-group">
                    <?= $form->field($model, 'updatedAt')->textInput(['maxlength' => true,'placeholder'=>'To Date'])->label(false) ?>
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
