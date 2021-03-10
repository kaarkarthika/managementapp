<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Breadcrumbs;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use backend\models\ExpensesMaster;
use backend\models\CommiteeManagement;

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
$isal = "hidden";
if($model->type==1){
    $isal = "";
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
</style>
<div class="relationship-master-form">
    <div id="page-content">
        <div class="">
            <div class="eq-height">
                <div class="panel">
                    <div class="panel-body">
                            <?php $form = ActiveForm::begin(['options' => ['enctype'=>'multipart/form-data']]); ?>
                            <input type="hidden" id="getId" value="<?php echo $idd; ?>">
                            <div class="row">
                                <div class='col-sm-4 form-group' >
                                     <?php          
                       echo  $form->field($model, 'type')->dropDownList(ArrayHelper::map(ExpensesMaster::find()->all(),'auto_id','expenses_name'), ['prompt'=>'SELECT..']) ?>
                                </div> 
                                <div class='col-sm-4 form-group' >
                                    <?php
                                        if($model->exe_date!=""){
                                            $model->exe_date = date('d-m-Y',strtotime($model->exe_date));
                                            if(strpos($model->exe_date, '1970') ||strpos($model->exe_date, '0000')){
                                                $model->exe_date = "-";
                                            }

                                        }
                                     ?>
                                    <?= $form->field($model, 'exe_date')->textInput(['maxlength' => true]) ?>
                                </div>
                                <div class='col-sm-4 form-group' >
                                    <?= $form->field($model, 'amount')->textInput(['maxlength' => true,'onkeypress'=>'return isNumberKey(event)']) ?>
                                </div>  

                            </div>
                            <div class="row">
                            <div class='col-sm-4 form-group' id="salary_data" <?php echo $isal; ?> >
                                <?php          
                       echo  $form->field($model, 'committe_staff')->dropDownList(ArrayHelper::map(CommiteeManagement::find()->where(['employee_type'=>'STAFF'])->all(),'id','name'), ['prompt'=>'SELECT..']) ?>
                                </div>
                                <div class="col-sm-4 form-group mb_0">
                                    <?= $form->field($model, 'narration')->textarea(['rows' => 2,'placeholder'=>'If Required']) ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group pull-right">
                                    <?= Html::submitButton($model->isNewRecord ? 'Save' : 'Save', ['class' => $model->isNewRecord ? 'btn btn-create createBtn btn-success' : 'btn btn-primary','required'=>true]) ?>
                                    <?= Html::a('Cancel',['index'], ['class' =>'btn btn-default']) ?>
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
    

    function isNumberKey(evt)
    {
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
        return true;
    }

    $('input#expensesmanagement-exe_date').daterangepicker({
        'singleDatePicker': true,
        'showDropdowns': true,
        'timePicker': false,
        'timePicker24Hour': 'false',
        'autoApply':'true',
        // 'minDate': '<?php echo date('d-m-Y h:i A'); ?>',
        // "startDate": '<?php echo date('d-m-Y h:i A'); ?>',        
        'format': 'DD-MM-YYYY'
        
    });

     $('body').on('change','#expensesmanagement-type',function(){
        $('#salary_data').hide();
        var ty = $('#expensesmanagement-type').val();
        if(ty==1){
            $('#salary_data').show();
        }else /*if(ty=='CASH'||ty=='OTHERS')*/if(ty!="" && ty!='undefined'){
            $('#salary_data').hide();
        }
            
    });

</script>

</style>
