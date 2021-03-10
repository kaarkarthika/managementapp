<?php
   use yii\helpers\Html;
   use yii\widgets\ActiveForm;
   use yii\widgets\Breadcrumbs;
   use yii\helpers\Url;
   use yii\helpers\ArrayHelper;
   use backend\models\DesignationMaster;

   $session = Yii::$app->session;
   /* @var $this yii\web\View */
   /* @var $model backend\models\CategoryManagement */
   /* @var $form yii\widgets\ActiveForm */
if(isset($_SESSION['color_code'])){
$color_code=$_SESSION['color_code'];
}
else
{
$color_code="#ed1c24";
}

$isal = "hidden";
if($model->employee_type =='STAFF'){
    $isal = "";
}
?>
<style>
  textarea{
    resize: none;
  }
  /*.btn-success{
    background-color:<?php //echo $color_code;?>;
   color: #fff;
   border-color: <?php //echo $color_code;?>;
  }
  .clssdyna{
    background-color:<?php //echo $color_code;?>;
   color: #fff;
   border-color: <?php //echo $color_code;?>;
  }
  .btn-success:hover, .btn-success:active, .btn-success.hover {
    background-color:<?php //echo $color_code;?>;
  }
  .btn-success:hover {   
    border-color:<?php //echo $color_code;?>;
  }*/

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
   #commiteemanagement-salary{
    text-align: right;
   }
</style>
<div class="relationship-master-form">
    <div id="page-content">
        <div class="">
            <div class="eq-height">
                <div class="panel">
                    <div class="panel-body">
                        <?php $form = ActiveForm::begin(['options' => ['enctype'=>'multipart/form-data']]); ?>
                        <div class="row">
                            <div class='col-sm-4 form-group' >
                                <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                                <?= $form->field($model, 'hidden_Input')->hiddenInput(['id'=>'hidden_Input','class'=>'form-control','value'=>$token_name])->label(false)?>
                            </div>
                            <div class="col-sm-4 form-group">
                                <?= $form->field($model, 'contactNumber')->textInput(['maxlength'=>true,'onkeypress'=>'return isNumberKey(event)']) ?>
                            </div>
                            <div class="col-sm-4">
                                <?php
                                $a= array('COMMITEEE'=>'COMMITEEE','STAFF'=>'STAFF') ?>
                                <?= $form->field($model, 'employee_type')->dropDownList($a,['prompt'=>'SELECT..']) ?>
                            </div>
                            
                        </div>
                        <div class="row">
                          <div class="col-sm-4">
                                <?php          
                       echo  $form->field($model, 'select_type')->dropDownList(ArrayHelper::map(DesignationMaster::find()->all(),'designationId','desigantionName'), ['prompt'=>'SELECT..']) ?>
                            </div>
                            <div class="col-sm-4" id="salary_data" <?php echo $isal; ?>>
                                <?= $form->field($model, 'salary')->textInput() ?>
                            </div>
                            <div class="col-sm-4">
                                <?php
                                if($model->asOnDate!=""){
                                    $model->asOnDate = date('d-m-Y',strtotime($model->asOnDate));
                                    if(strpos($model->asOnDate, '1970') ||strpos($model->asOnDate, '0000')){
                                        $model->asOnDate = "-";
                                    }
                                }
                                ?>
                                <?= $form->field($model, 'asOnDate')->textInput(['maxlength' => true]) ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-2">
                                <?= $form->field($model, 'education')->textInput(['maxlength' => true,'placeholder'=>'Education (Optional)']) ?>
                            </div>
                            <div class="col-sm-2 form-group">
                                <?= $form->field($model, 'age')->textInput(['placeholder'=>'Optional']) ?>
                            </div>
                            <div class="col-sm-4">
                                <?= $form->field($model, 'present_address')->textarea(['rows' => 3]) ?>
                            </div>
                            <div class="col-sm-4">
                                <?= $form->field($model, 'permanent_address')->textarea(['rows' => 3]) ?>
                            </div>
                        </div>
                        <?php /*
                        <div class="row">
                            <div class="col-sm-4">
                                <?= $form->field($model, 'benefits1')->textarea(['rows' => 3]) ?>
                            </div>
                            <div class="col-sm-4">
                                <?= $form->field($model, 'benefits2')->textarea(['rows' => 3]) ?>
                            </div>
                            <div class="col-sm-4">
                                <?= $form->field($model, 'benefits3')->textarea(['rows' => 3]) ?>
                            </div>
                        </div>

                        */ ?>
                        <div class="row"> 

                            <div class="col-sm-4">
                                <?= $form->field($model, 'comments')->textarea(['rows' => 3]) ?>
                            </div>
                            <div class="col-sm-4">
                              <?php 
                              if($model->isNewRecord){
                                  $model->active_status = 1;
                                }?>
                                <?= $form->field($model, 'active_status', [
                                  'template' => "<div class='checkbox checkbox-custom' style='margin-top:30px; margin-left:20px;'>{input}<label>Active</label></div>{error}",
                                ])->checkbox([],false) ?>
                            </div>
                        </div>
                        <div class="form-group pull-right">
                            <?= Html::submitButton($model->isNewRecord ? 'Save' : 'Save', ['class' => $model->isNewRecord ? 'btn btn-create createBtn btn-success' : 'btn btn-primary','required'=>true]) ?>
                            <?= Html::a('Cancel',['index'], ['class' =>'btn btn-default']) ?>
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

    $('input#commiteemanagement-asondate').daterangepicker({
        'singleDatePicker': true,
        'showDropdowns': true,
        'timePicker': false,
        'timePicker24Hour': 'false',
        'autoApply':'true',
        // 'minDate': '<?php echo date('d-m-Y h:i A'); ?>',
        // "startDate": '<?php echo date('d-m-Y h:i A'); ?>',        
        'format': 'DD-MM-YYYY'
        
    });

  $('body').on('change','#commiteemanagement-employee_type',function(){
        $('#salary_data').hide();
        var ty = $('#commiteemanagement-employee_type').val();
        if(ty=='STAFF'){
            $('#salary_data').show();
        }else /*if(ty=='CASH'||ty=='OTHERS')*/if(ty!="" && ty!='undefined'){
            $('#salary_data').hide();
        }
            
    });
</script>


