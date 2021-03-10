<?php
   use yii\helpers\Html;
   use yii\widgets\ActiveForm;
   use yii\widgets\Breadcrumbs;
   use yii\helpers\Url;
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
$idd = "";
if(array_key_exists('id', $_GET)){
    $idd = $_GET['id'];
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
</style>
<div id="page-content">
   <div class="">
      <div class="eq-height">
         <div class="panel">
            <div class="panel-body ">
               <?php $form = ActiveForm::begin(['options' => ['enctype'=>'multipart/form-data']]); ?>
                <input type="hidden" id="getId" value="<?php echo $idd; ?>">
               <div class="row">
                  <div class='col-sm-4 form-group mb_0' >
                        <?= $form->field($model, 'demised_name')->textInput(['maxlength' => true]) ?>
                  </div>
                  <div class='col-sm-4 form-group mb_0' >
                        <?= $form->field($model, 'fatherName')->textInput(['maxlength' => true]) ?>
                  </div>
                 <!--  <div class='col-sm-4 form-group mb_0' >
                        <?//= $form->field($model, 'childernName')->textInput(['maxlength' => true]) ?>
                  </div> -->
                  <div class='col-sm-4 form-group mb_0' >
                        <?= $form->field($model, 'placeOfDeath')->textInput(['maxlength' => true]) ?>
                  </div>
                </div>
                <div class="row">
                  <div class='col-sm-4 form-group mb_0' >
                        <?= $form->field($model, 'placeOfJanazaPrayer')->textInput(['maxlength' => true]) ?>
                  </div>
                  <div class='col-sm-4 form-group mb_0' >
                        <?= $form->field($model, 'placeOfBurialFields')->textInput(['maxlength' => true]) ?>
                  </div>
                  <div class='col-sm-4 form-group mb_0' >
                    <?php 
                      if($model->death_date!="" && $model->death_date!=NULL){
                        $model->death_date = date('d-m-Y',strtotime($model->death_date));
                      }
                    ?>
                        <?= $form->field($model, 'death_date')->textInput() ?>
                  </div>
                </div>
                 <?= $form->field($model, 'hidden_Input')->hiddenInput(['id'=>'hidden_Input','class'=>'form-control','value'=>$token_name])->label(false)?>
                <div class="row">
                  <div class='col-sm-4 form-group mb_0' >
                    <?= $form->field($model, 'contact_person')->textInput(['maxlength' => true]) ?>
                   </div>
                  <div class='col-sm-4 form-group mb_0' >
                         <?= $form->field($model, 'address')->textarea(['rows' => 3]) ?>
                  </div>
              </div>
               <div class="row">   
                                <div class="col-sm-2 form-group mb_0">
                                    <?= $form->field($model, 'childernName')->textInput(['maxlength' => true,'onkeypress'=>'return isNumberKey(event)']) ?>
                                </div>
                                <div class="col-sm-2 form-group mb_0" style='margin: 27px 13px 5px 2px;' >
                                    <span class="">
                                        <?= Html::button('<i class="fa fa-plus"></i>', ['class' => 'btn btn-success btn-xs add-field', 'title' =>'dependents','id'=>'add-field']) ?>
                                    </span>
                                    <span style="color: red;" id='addError'></span>
                                </div>
                            </div>
                            <div class="row">
                                <div id="childrensDiv">
                                    <?php 
                                        if($childContent!=""){
                                            echo $childContent;
                                        }
                                    ?>
                                </div>
                            </div>

              <div class="row">
                </div>
            <div class="form-group mb_0 pull-right">
               <?= Html::submitButton($model->isNewRecord ? 'Save' : 'Save', ['class' => $model->isNewRecord ? 'btn btn-create createBtn btn-success clssdyna' : 'btn btn-primary','required'=>true]) ?>
               <?= Html::a( 'Cancel',['index'], ['class' =>'btn btn-default']) ?>
            </div>
            <?php ActiveForm::end(); ?>
         </div>
      </div>
   </div>
</div>
</div>
<script>
     $(function () {
  $("#deathcertificates-death_date").datepicker({ 
        autoclose: true, 
       // todayHighlight: true,
        format:'dd-mm-yyyy'
  });
});

    $('body').on('click','#add-field',function(){
        var chil = $('#deathcertificates-childernname').val();  
        var get = $('#getId').val();
        if(chil!="" && chil!='undefined'){
            $.ajax({
                url: '<?php echo Yii::$app->homeUrl . '?r=death-certificates/add-childrens&id='; ?>'+get,
                type:'post',
                data:'id='+chil,
                success:function(response){
                    $('#childrensDiv').html(response);
                }
            });
        }else{
            $("#addError").html("No of Childrens Required");     
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

