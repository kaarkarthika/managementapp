<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Breadcrumbs;
use yii\helpers\ArrayHelper;
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
                                <div class='col-sm-6 form-group mb_0' >
                                    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                                </div>
                                <div class='col-sm-6 form-group mb_0' >
                                    <?= $form->field($model, 'popularName')->textInput(['maxlength' => true]) ?>
                                </div>
                                <div class="col-sm-6 form-group mb_0">
                                    <?= $form->field($model, 'phoneNumber')->textInput(['maxlength' => true,'onkeypress'=>'return isNumberKey(event)']) ?>
                                </div>
                                <div class="col-sm-6 form-group mb_0">
                                    <?= $form->field($model, 'alternatePhoneNumber')->textInput(['maxlength' => true,'onkeypress'=>'return isNumberKey(event)']) ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6 form-group mb_0">
                                    <?= $form->field($model, 'emailId')->textInput(['maxlength' => true]) ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6 form-group mb_0">
                                    <?= $form->field($model, 'address')->textArea() ?>
                                </div>
                                <div class="col-sm-6 form-group mb_0">
                                    <?= $form->field($model, 'landmark')->textArea(['maxlength' => true]) ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 form-group mb_0">
                                    <?= $form->field($model, 'googleMapLink')->textInput(['maxlength' => true]) ?>
                                    <?php
                                        if($model->googleMapLink!=""){ ?>
                                            <span style="margin-left: 50px;"><a href="<?php echo $model->googleMapLink; ?>" target="_blank">Check Google Map Here</a></span>

                                    <?php
                                        }
                                     ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class='col-sm-12 form-group mb_0' >
                                    <div class="field" align="left">
                                        <?php
                                        $paths=array();
                                        $data=json_decode($model->image);
                                        if(!empty($data)){
                                            foreach($data as $k){
                                                $imgs=$k;
                                                $paths[]= Url::base()."/uploads/mosque/".$imgs;
                                            }
                                        } ?>
                                        <div style="display: none;">
                                            <?php echo $form->field($model, 'updatedAt')->fileInput()->label(false); ?>
                                        </div>
                                    </div>
                                    <label>Images</label>
                                    <input type="hidden" name="isImage" class="" />
                                    <input type="file" id="files" class="isJanImageMultiple" name="MosqueDetails[images][]"  value="" multiple/>
                                    <?php 
                                    if(!empty($paths)){  
                                        foreach ($paths as $key => $one) { ?>                                             
                                            <span class="pip">
                                            <img class="imageThumb" src="<?php echo $one; ?>" /><br/>
                                        </span>
                                            <?php 
                                        }
                                    } ?>
                                </div>
                            </div>
                             
                            <div class="row">
                                <div class="col-s m-12 form-group mb_0" style='margin: 27px 13px 5px 2px;' >
                                    <label></label>
                                    <span style="font-weight: bold;font-size: 14px;"> Additional Informations</span>
                                    <span class="">
                                        <?= Html::button('<i class="fa fa-plus"></i>', ['class' => 'btn btn-success btn-xs add-field', 'title' =>'dependents','id'=>'add-field']) ?>
                                    </span>
                                    <span style="color: red;" id='addError'></span>
                                    <div class="card-body ">
                            <!-- <div class="col-md-12"> -->
                                <div class="table-responsive-xl">
                                    <table class="table table-bordered table-striped manage" >
                                        <thead class="thead-dark">
                                            <tr>
                                                <th scope="col" width="6%">S.No</th>
                                                <th scope="col" width="25%">Information</th>
                                                <th scope="col" width="40%">Value</th>
                                                <th scope="col" width="8%">Remove</th>
                                            </tr>
                                        </thead>
                                        <tbody class="fields process" id="DymentionTableBody">
                                            <?php   
                                            $Dimensions = ArrayHelper::toArray(json_decode($model->otherInformations)) ;
                                            $content = "";
                                            $k = 0;
                                            // echo "<prE>";print_r($dymentions);die;
                                            if(!empty($Dimensions)){ 
                                                $k = 1;
                                                foreach ($Dimensions as $key => $value){    
                                                    $content .= '
                                                    <tr class="multi-field drag-handler">
                                                        <td scope="row" class="serial_no">'.$k.'</td>
                                                        <td><input type="text" name="dymenLabel[]" class="form-control" value="'.$value["label"].'" /></td>
                                                        <td><input type="text" name="dymenValue[]"  class="form-control" value="'.$value["value"].'" /></td>
                                                        <td><button type="button" class="btn btn-danger btn-xs remove-field" id="remove'.$k.'" "title" ="Remove"><i class="fa fa-remove"></i></button></td>
                                                        </td>
                                                    </tr>';
                                                    $k++;
                                                }
                                            } 
                                            echo $content;
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            <!-- </div> -->
                        </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group mb_0 pull-right">
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
    $('body').on('click','#add-field',function(){ 

        var sno = 0;
        $('.serial_no').each(function(){
            sno++;
        });            
        $.ajax({
            url: '<?php echo Yii::$app->homeUrl . '?r=mosque-details/add-info&id='; ?>'+sno,
            type:'post',
            data:'id='+sno,
            success:function(response){
                $('#DymentionTableBody').append(response);
            }
        });   
            
    });

    function isNumberKey(evt)
    {
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
        return true;
    }
    $('body').on('click','.remove-field',function(){
        // $(this).parent().parent().remove();
        $(this).closest("tr").remove();
        sno = 1;
        $('.serial_no').each(function(){
            $(this).html(sno);
            sno++;
        });
    });

</script>
<style type="text/css">
    
    input[type="file"] {
  display: block;
}
</style>
