<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Breadcrumbs;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use backend\models\IncomeTypeMaster;
$session = Yii::$app->session;
if(isset($_SESSION['color_code'])){
    $color_code=$_SESSION['color_code'];
}else
{
    $color_code="#ed1c24";
}
$idd = "";
if(array_key_exists('id', $_GET)){
    $idd = $_GET['id'];
}
$isCrd = $isref = "hidden";
// if($model->income_type=='CARD'){
//     $isCrd = "";
// }else/* if($model->donation_type=='CASH'||$model->donation_type=='OTHERS')*/ 
if($model->income_type!=""){
    $isref = "";
}
?>
<style>
    textarea{
        resize: none;
    }
    .score {
        background-color: #0c9cce;
        color: #fff;
        font-weight: 600;
        border-radius: 50%;
        width: 40px;
        height: 40px;
        line-height: 40px;
        text-align: center;
        margin: auto;
        /* padding: 21% 14%;*/
    }
    .checkbox input[type="checkbox"] {
        cursor: pointer;
        opacity: 0;
        z-index: 1;
        outline: none !important;
    }
    .upper {
        text-transform: uppercase;
    }
    .checkbox-custom input[type="checkbox"]:checked + label::before {
        background-color: #5fbeaa;
        border-color: #5fbeaa;
    }
    .checkbox label::before {
        -o-transition: 0.3s ease-in-out;
        -webkit-transition: 0.3s ease-in-out;
        background-color: #ffffff;
        /* border-radius: 3px; */
        border: 1px solid #cccccc;
        content: "";
        display: inline-block;
        height: 17px;
        left: 0!important;
        margin-left: -20px!important;
        position: absolute;
        transition: 0.3s ease-in-out;
        width: 17px;
        outline: none !important;
    }
    .checkbox input[type="checkbox"]:checked + label::after {
        content: "\f00c";
        font-family: 'FontAwesome';
        color: #fff;
        position: relative;
        right: 59px;
        bottom: 1px;
    }
    .checkbox label {
        display: inline-block;
        padding-left: 5px;
        position: relative;
    }
    #incomemanagement-incomeamount{
        text-align: right;
    }
</style>
<div class="donation-management-form">
    <div id="page-content">
        <div class="">
            <div class="eq-height">
                <div class="panel">
                    <div class="panel-body">
                            <?php $form = ActiveForm::begin(['options' => ['enctype'=>'multipart/form-data']]); ?>
                            <input type="hidden" id="getId" value="<?php echo $idd; ?>">
                            <div class="row">
                                <div class='col-sm-4 form-group mb_0' >
                                    <?php
                                    $ar = IncomeTypeMaster::find()->where(['active_status'=>1])->asArray()->all();
                                    $ar = ArrayHelper::map($ar,'incomeMode','incomeMode'); ?>
                                    <?= $form->field($model, 'income_type')->dropDownList($ar,['prompt'=>'SELECT..',]); ?> 
                                </div> 
                                <div class='col-sm-4 form-group mb_0' >
                                    <?php
                                        if($model->income_date!=""){
                                            $model->income_date = date('d-m-Y',strtotime($model->income_date));
                                            if(strpos($model->income_date, '1970') ||strpos($model->income_date, '0000')){
                                                $model->income_date = "-";
                                            }

                                        }
                                     ?>
                                    <?= $form->field($model, 'income_date')->textInput(['maxlength' => true]) ?>
                                </div>
                                <div class='col-sm-2 form-group mb_0'>
                                    <?= $form->field($model, 'incomeAmount')->textInput(['maxlength' => true,'onkeypress'=>'return isNumberKey(event)']) ?>
                                </div>                          
                            </div>
                            <div class="row" id="refNumber" <?php echo $isref; ?>> 
                                <div class='col-sm-4 form-group mb_0' id="refNumber" >
                                    <?= $form->field($model, 'reference_number')->textInput(['maxlength' => true]) ?>
                                </div>                   
                            </div>
                            <div class="row" id="cardDetails" <?php echo $isCrd; ?>> 
                                <div class='col-sm-4 form-group mb_0'>
                                    <?= $form->field($model, 'card_number')->textInput(['maxlength' => true]) ?>
                                </div>
                                <div class='col-sm-4 form-group mb_0'>
                                    <?= $form->field($model, 'bankName')->textInput(['maxlength' => true]) ?>
                                </div>
                                <div class='col-sm-4 form-group mb_0'>
                                    <?= $form->field($model, 'cardHolderName')->textInput(['maxlength' => true]) ?>
                                </div>
                            </div>
                            <div class="row"> 
                                <div class="col-sm-12 form-group mb_0">
                                    <fieldset class="scheduler-border">
                                        <legend class="scheduler-border">Payer Information</legend> 
                                        
                                            <div class="col-sm-6 form-group mb_0">
                                                <?= $form->field($model, 'payer_name')->textInput(['maxlength' => true]) ?>
                                            </div>
                                            <div class="col-sm-6 form-group mb_0">
                                                <?= $form->field($model, 'contact_number')->textInput(['maxlength' => true,'onkeypress'=>'return isNumberKey(event)']) ?>
                                            </div>
                                            <div class="col-sm-6 form-group mb_0">
                                                <?= $form->field($model, 'payer_address')->textarea(['rows' => 2]) ?>
                                            </div>
                                            <div class="col-sm-6 form-group mb_0">
                                                <?= $form->field($model, 'payer_description')->textarea(['rows' => 2]) ?>
                                            </div>
                                    </fieldset>  
                                </div>              
                            </div>
                            <div class="row">
                                <div class="form-group mb_0 pull-right">
                                    <?= Html::submitButton($model->isNewRecord ? 'Save' : 'Save', ['class' => $model->isNewRecord ? 'btn btn-create createBtn btn-success' : 'btn btn-primary','required'=>true]) ?>
                                    <?= Html::a('Cancel', ['index'], ['class' => 'btn btn-default']) ?>
                                </div>
                            </div>
                            
                            <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $('body').on('change','#incomemanagement-income_type',function(){
        $('#refNumber').hide();
        $('#cardDetails').hide(); 
        var ty = $('#incomemanagement-income_type').val();
        // if(ty=='CARD'){
        //     $('#cardDetails').show();
        //     $('#refNumber').hide();
        // }else /*if(ty=='CASH'||ty=='OTHERS')*/
        if(ty!="" && ty!='undefined'){
            $('#refNumber').show();
            $('#cardDetails').hide();
        }
            
    });

    function isNumberKey(evt)
    {
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
        return true;
    }

    $('input#incomemanagement-income_date').daterangepicker({
        'singleDatePicker': true,
        'showDropdowns': true,
        'timePicker': false,
        'timePicker24Hour': 'false',
        'autoApply':'true',
        // 'minDate': '<?php echo date('d-m-Y h:i A'); ?>',
        // "startDate": '<?php echo date('d-m-Y h:i A'); ?>',        
        'format': 'DD-MM-YYYY'
        
    });

</script>
