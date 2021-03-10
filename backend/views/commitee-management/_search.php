<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\CommiteeManagementSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="commitee-management-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div class="row">
            <div class="col-sm-12" style="margin-top: 10px;margin-bottom: -35px;">
                <div class='col-sm-2 form-group' >
                   <!--  <?php 
                    //$a= array('Employee'=>'EMPLOYEE','Imam'=>'IMAM') ?>
                    <?//= $form->field($model, 'select_type')->dropDownList($a,['prompt'=>'SELECT Emplyee Type..'])->label(false)  ?> -->
                     <?php
                    $a= array('COMMITEEE'=>'COMMITEEE','STAFF'=>'STAFF') ?>
                    <?= $form->field($model, 'employee_type')->dropDownList($a,['prompt'=>'SELECT..'])->label(false) ?>
                </div>
                <div class='col-sm-2 form-group' >
                    <?= $form->field($model, 'name')->textInput(['maxlength' => true,'placeholder'=>true])->label(false)  ?>
                </div>
                <div class="col-sm-2 form-group">
                    <?= $form->field($model, 'created_at')->textInput(['maxlength' => true,'placeholder'=>'Added Date(From)'])->label(false) ?>
                </div>
                <div class="col-sm-2 form-group">
                    <?= $form->field($model, 'updated_at')->textInput(['maxlength' => true,'placeholder'=>'Added Date(To)'])->label(false) ?>
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
