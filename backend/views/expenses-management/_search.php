<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\models\ExpensesMaster;
use backend\models\CommiteeManagement;

/* @var $this yii\web\View */
/* @var $model backend\models\ExpensesManagementSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="expenses-management-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div class="row" >
            <div class="col-sm-12" style="margin-top: 10px;margin-bottom: -35px;">
                <div class='col-sm-2 form-group' >
                    <?php
                    //$a= array('Salary'=>'SALARY','Rent'=>'RENT','Miscellenous'=>'MISCELLENOUS') ?>
                    <!-- <?//= $form->field($model, 'type')->dropDownList($a,['prompt'=>'Select Expenses Trpe..'])->label(false)   ?> -->
                   <?php  echo  $form->field($model, 'type')->dropDownList(ArrayHelper::map(ExpensesMaster::find()->all(),'auto_id','expenses_name'), ['prompt'=>'SELECT..'])->label(false)?>
                </div>
                <div class="col-sm-2 form-group">
                    <?= $form->field($model, 'amount')->textInput(['maxlength' => true,'placeholder'=>true])->label(false) ?>
                </div>
                <div class="col-sm-2 form-group">
                    <?= $form->field($model, 'created_at')->textInput(['maxlength' => true,'placeholder'=>true])->label(false) ?>
                </div>
                <div class="col-sm-2 form-group">
                    <?= $form->field($model, 'updated_at')->textInput(['maxlength' => true,'placeholder'=>true])->label(false) ?>
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
