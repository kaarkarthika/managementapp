<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Breadcrumbs;
use yii\helpers\Url;
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
                                <div  class="col-sm-12 form-group mb_0" >
                                    <fieldset class="scheduler-border">
                                        <legend class="scheduler-border">Family Head's Information</legend>
                                        <div  class="col-sm-12 form-group mb_0" >
                                            <div class='col-sm-4 form-group mb_0' >
                                                <?= $form->field($model, 'familyHeadName')->textInput(['maxlength' => true])->label('Name') ?>
                                            </div>
                                            <div class='col-sm-4 form-group mb_0' >
                                                <?= $form->field($model, 'headAge')->textInput(['maxlength' => true])->label('Age') ?>
                                            </div>
                                            <div class='col-sm-4 form-group mb_0' >
                                                <?=  $form->field($model, 'headGender')->radioList( ['male'=>'Male', 'female' => 'Female'] )->label('Gender'); ?>
                                            </div>
                                        </div>
                                        <div  class="col-sm-12 form-group mb_0" >
                                            <div class='col-sm-4 form-group mb_0' >
                                                <?=  $form->field($model, 'headEducation')->textInput(['maxlength' => true])->label('Education') ?>
                                            </div>
                                            <div class='col-sm-4 form-group mb_0' >
                                                <?=  $form->field($model, 'headOccupation')->textInput(['maxlength' => true])->label('Occupation') ?>
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>
                            </div>

                            <div class="row">
                                <div  class="col-sm-12 form-group mb_0" >
                                    <fieldset class="scheduler-border">
                                        <legend class="scheduler-border">Contact Information</legend>
                                        <div  class="col-sm-12 form-group mb_0" >
                                            <div class='col-sm-4 form-group mb_0' >
                                                <?= $form->field($model, 'contactNumber')->textInput(['maxlength' => true,'onkeypress'=>'return isNumberKey(event)']) ?>
                                            </div>
                                            <div class="col-sm-4 form-group mb_0">
                                                <?= $form->field($model, 'alternatePhoneNumber')->textInput(['maxlength' => true,'onkeypress'=>'return isNumberKey(event)']) ?>
                                            </div>
                                            <div class='col-sm-4 form-group mb_0' >
                                                <?= $form->field($model, 'emailId')->textInput(['maxlength' => true]) ?>
                                            </div>
                                        </div>
                                        <div  class="col-sm-12 form-group mb_0" >                            
                                            <div class="col-sm-4 form-group mb_0">
                                                <?= $form->field($model, 'address')->textarea(['rows' => 2]) ?>
                                            </div>
                                            <div class="col-sm-4 form-group mb_0">
                                                <?= $form->field($model, 'landMark')->textInput(['maxlength' => true]) ?>
                                            </div>
                                            <div class="col-sm-4 form-group mb_0">
                                                <?= $form->field($model, 'description')->textarea(['rows' => 2]) ?>
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>
                            </div>

                            <div class="row">   
                                <div class="col-sm-2 form-group mb_0">
                                    <?= $form->field($model, 'noOfDependents')->textInput(['maxlength' => true,'onkeypress'=>'return isNumberKey(event)']) ?>
                                </div>
                                <div class="col-sm-2 form-group mb_0" style='margin: 27px 13px 5px 2px;' >
                                    <span class="">
                                        <?= Html::button('<i class="fa fa-plus"></i>', ['class' => 'btn btn-success btn-xs add-field', 'title' =>'dependents','id'=>'add-field']) ?>
                                    </span>
                                    <span style="color: red;" id='addError'></span>
                                </div>
                            </div>
                            <div class="row">
                                <div id="dependentDiv">
                                    <?php 
                                        if($depentContent!=""){
                                            echo $depentContent;
                                        }
                                    ?>
                                </div>
                            </div>

                            
                            <div class="row">
                                <?php
                                    $model->activeStatus = 1;
                                    if($model->activeStatus=='I'){
                                        $model->activeStatus = 0;
                                    }
                                ?>
                                <div class='col-sm-6 form-group mb_0 ' >
                                    <?= $form->field($model, 'activeStatus', ['template' => "<div class='checkbox checkbox-custom' style='margin-top:30px; margin-left:20px;'>{input}<label>Active</label></div>{error}",
                                    ])->checkbox([],false) ?>
                                </div>
                            </div>
                            <div class="form-group mb_0 pull-right">
                                <?= Html::submitButton($model->isNewRecord ? 'Save' : 'Save', ['class' => $model->isNewRecord ? 'btn btn-create createBtn btn-success' : 'btn btn-primary','required'=>true]) ?>
                                <?= Html::a('Cancel', ['index'], ['class' => 'btn btn-default']) ?>
                            </div>
                            <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $('body').on('click','#add-field',function(){
        var dep = $('#familymaster-noofdependents').val();  
        var get = $('#getId').val();
        if(dep!="" && dep!='undefined'){
            $.ajax({
                url: '<?php echo Yii::$app->homeUrl . '?r=family-master/add-dependents&id='; ?>'+get,
                type:'post',
                data:'id='+dep,
                success:function(response){
                    $('#dependentDiv').html(response);
                }
            });
        }else{
            $("#addError").html("No of Dependents Required");     
        }     
    });

    function isNumberKey(evt)
    {
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
        return true;
    }

</script>