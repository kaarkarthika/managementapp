<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use backend\models\DonationTypeMaster;
/* @var $this yii\web\View */
/* @var $model backend\models\DonationManagementSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="donation-management-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>
    <div class="row">
            
            <div class="col-sm-12"  style="margin-top: 10px;margin-bottom: -35px;">                
                <div class='col-sm-2 form-group'>
                    <?php
                    
                    $ar = DonationTypeMaster::find()->where(['active_status'=>1])->asArray()->all();
                    $ar = ArrayHelper::map($ar,'donation_type','donation_type'); ?>
                    <?= $form->field($model, 'donation_type')->dropDownList($ar,['prompt'=>'Select Donation Type',])->label(false) ?> 
                </div>
                <div class="col-sm-2 form-group">
                    <?= $form->field($model, 'donationAmount')->textInput(['maxlength' => true,'onkeypress'=>'return isNumberKey(event)','placeholder'=>'Search PhoneNumber'])->label(false) ?>
                </div>
                <div class="col-sm-2 form-group">
                    <?= $form->field($model, 'created_at')->textInput(['maxlength' => true,'placeholder'=>'Donation From Date'])->label(false) ?>
                </div>
                <div class="col-sm-2 form-group">
                    <?= $form->field($model, 'updated_at')->textInput(['maxlength' => true,'placeholder'=>'Donation To Date'])->label(false) ?>
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
