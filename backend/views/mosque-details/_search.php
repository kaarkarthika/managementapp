<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\MosqueDetailsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="mosque-details-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>
        <div class="row">
            <div class="col-sm-2" ></div>
            <div class="col-sm-1">
                <label>Search</label>
            </div>
            <div class="col-sm-8">
                <div class='col-sm-3 form-group' >
                    <?= $form->field($model, 'name')->textInput(['maxlength' => true,'placeholder'=>'Search Name'])->label(false) ?>
                </div>
                <div class="col-sm-3 form-group">
                    <?= $form->field($model, 'phoneNumber')->textInput(['maxlength' => true,'onkeypress'=>'return isNumberKey(event)','placeholder'=>'Search PhoneNumber'])->label(false) ?>
                </div>
                <div class="form-group col-sm-5">
                    <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
                    <?= Html::submitButton('Download', ['class' => 'btn btn-success','name'=>'download']) ?>
                    <?= Html::a('Reset', ['index'],['class' => 'btn btn-default']) ?>
                </div>
            </div>            
        </div>
        <hr style="border-color: #ddd;">


    <?php ActiveForm::end(); ?>
</div>
