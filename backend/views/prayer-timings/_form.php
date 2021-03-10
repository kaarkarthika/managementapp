<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Breadcrumbs;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use backend\models\PrayerTimings;
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
<script type="text/javascript" src="<?php echo Url::base(); ?>/js/jquery-ui.js"></script>
<script type="text/javascript" src="<?php echo Url::base(); ?>/bootstrap-timepicker/bootstrap-datetimepicker.js"></script>
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
                                <table class="table">
                            <?php 
                            $prayer_timings = PrayerTimings::find()->asArray()->all();
                           if(!empty($prayer_timings)){
                            foreach ($prayer_timings as $key => $value) {
                            $prayer_name = $value['prayer_name'];
                            $prayer_key = $value['prayer_key'];
                            $auto_id = $value['auto_id'];
                            $time1 = $value['time1'];
                            $time2 = $value['time2'];
                            $time3 = $value['time3'];
                            $time4 = $value['time4'];
                            if($prayer_key=="Fajar" || $prayer_key=="Zohar" || $prayer_key =="Asar" || $prayer_key == "Maghrib" || $prayer_key =="Isha"){ ?>
                                  <tr>
                                    <th style="padding: 36px; text-align: center;"><?php echo $prayer_name; ?></th>
                                    <td style="padding: 36px;">:</td>
                                    <td><?= $form->field($model, 'time1')->textInput(['maxlength' => true,'id'=>'prayertimings-time1'.$auto_id.'','class'=>'form-control time1','value'=>$time1,'disabled'=>'disabled'])->label('Azaan Time') ?></td>
                                    <td><?= $form->field($model, 'time2')->textInput(['maxlength' => true,'id'=>'prayertimings-time2'.$auto_id.'','class'=>'form-control time1','value'=>$time2,'disabled'=>'disabled'])->label('Igmat Time')?></td>
                                    <td style="padding: 36px;">
                                     <span data-toggle="tooltip" data-placement="top" title="Update" id="update_<?php  echo $value['auto_id']; ?>" class="btn btn-xs  btn-primary pd-cus-btn update-po req_update" data-id="<?php echo $value['auto_id'];?>"><i class="fa fa-edit"></i></span>  
                                            <span data-toggle="tooltip" data-placement="top" title="Save Changes" id="update_save_<?php  echo $value['auto_id']; ?>" class="btn btn-xs  btn-success pd-cus-btn hide update-po req_update_save" data-id="<?php echo $value['auto_id'];?>" data-itemid="<?php echo $value['auto_id'];?>"><i class="fa fa-check"></i></span>
                                            <span id="feed_back"></span> 
                                        </td>
                                  </tr> 
                                <?php   
                                 }else if ($prayer_key =="Jumma"){ ?>
                                  <tr>
                                    <th  style="padding: 36px; text-align: center;"><?php echo $prayer_name; ?></th>
                                    <td style="padding: 36px;">:</td>
                                    <td>
                                        <?= $form->field($model, 'time1')->textInput(['maxlength' => true,'id'=>'prayertimings-time1'.$auto_id.'','class'=>'form-control time1','value'=>$time1,'disabled'=>'disableddisabled'])->label('Azaan Time') ?></td>
                                    <td><?= $form->field($model, 'time2')->textInput(['maxlength' => true,'id'=>'prayertimings-time2'.$auto_id.'','class'=>'form-control time1','value'=>$time2,'disabled'=>'disabled'])->label('Qutba Time')?></td>
                                     <td style="padding: 36px;">
                                     <span data-toggle="tooltip" data-placement="top" title="Update" id="update_<?php  echo $value['auto_id']; ?>" class="btn btn-xs  btn-primary pd-cus-btn update-po req_update" data-id="<?php echo $value['auto_id'];?>"><i class="fa fa-edit"></i></span>  
                                            <span data-toggle="tooltip" data-placement="top" title="Save Changes" id="update_save_<?php  echo $value['auto_id']; ?>" class="btn btn-xs btn-success pd-cus-btn hide update-po req_update_save" data-id="<?php echo $value['auto_id'];?>" data-itemid="<?php echo $value['auto_id'];?>"><i class="fa fa-check"></i></span> 
                                            <span id="feed_back"></span> 
                                        </td>
                                  </tr> 
                            <?php   
                             }else if ($prayer_key =="Nafil"){ ?>
                                  <tr>
                                    <th style="padding: 36px;text-align: center;"><?php echo $prayer_name; ?></th>
                                    <td style="padding: 36px;">:</td>
                                    <td><?= $form->field($model, 'time1')->textInput(['maxlength' => true,'id'=>'prayertimings-time1'.$auto_id.'','class'=>'form-control time1','value'=>$time1,'disabled'=>'disabled'])->label('Tahajjud Time') ?></td>
                                    <td><?= $form->field($model, 'time2')->textInput(['maxlength' => true,'id'=>'prayertimings-time2'.$auto_id.'','class'=>'form-control time1','value'=>$time2,'disabled'=>'disabled'])->label('Ishraq Time')?></td>
                                    <td><?= $form->field($model, 'time2')->textInput(['maxlength' => true,'id'=>'prayertimings-time3'.$auto_id.'','class'=>'form-control time1','value'=>$time3,'disabled'=>'disabled'])->label('Chaast Time')?></td>
                                    <td><?= $form->field($model, 'time2')->textInput(['maxlength' => true,'id'=>'prayertimings-time4'.$auto_id.'','class'=>'form-control time1','value'=>$time4,'disabled'=>'disabled'])->label('Awwabeen Time')?></td>
                                     <td style="padding: 36px;">
                                     <span data-toggle="tooltip" data-placement="top" title="Update" id="update_<?php  echo $value['auto_id']; ?>" class="btn btn-xs btn-primary pd-cus-btn update-po req_update" data-id="<?php echo $value['auto_id'];?>"><i class="fa fa-edit"></i></span>  
                                            <span data-toggle="tooltip" data-placement="top" title="Save Changes" id="update_save_<?php  echo $value['auto_id']; ?>" class="btn btn-xs btn-success pd-cus-btn hide update-po req_update_save" data-id="<?php echo $value['auto_id'];?>" data-itemid="<?php echo $value['auto_id'];?>"><i class="fa fa-check"></i></span> 
                                            <span id="feed_back"></span> 
                                        </td>
                                  </tr> 
                            <?php   
                             }else if ($prayer_key =="Eid-ul-fita" || $prayer_key =="Eid-ul-adha"){ ?>
                                  <tr>
                                    <th style="padding: 36px;text-align: center;"><?php echo $prayer_name; ?></th>
                                    <td style="padding: 36px;">:</td>
                                    <td><?= $form->field($model, 'time1')->textInput(['maxlength' => true,'id'=>'prayertimings-time1'.$auto_id.'','class'=>'form-control time1','value'=>$time1,'disabled'=>'disabled'])->label('Eid Namaz Time') ?></td>
                                     <td style="padding: 36px;">
                                     <span data-toggle="tooltip" data-placement="top" title="Update" id="update_<?php  echo $value['auto_id']; ?>" class="btn btn-xs btn-primary pd-cus-btn update-po req_update" data-id="<?php echo $value['auto_id'];?>"><i class="fa fa-edit"></i></span>  
                                            <span data-toggle="tooltip" data-placement="top" title="Save Changes" id="update_save_<?php  echo $value['auto_id']; ?>" class="btn btn-xs btn-success pd-cus-btn hide update-po req_update_save" data-id="<?php echo $value['auto_id'];?>" data-itemid="<?php echo $value['auto_id'];?>"><i class="fa fa-check"></i></span>
                                            <span id="feed_back"></span>  
                                        </td>
                                  </tr> 
                            <?php   
                             }else if ($prayer_key =="Dawn"){ ?>
                                  <tr>
                                    <th style="padding: 36px;text-align: center;"><?php echo $prayer_name; ?></th>
                                    <td>:</td>
                                    <td><?= $form->field($model, 'time1')->textInput(['maxlength' => true,'id'=>'prayertimings-time1'.$auto_id.'','class'=>'form-control time1','value'=>$time1,'disabled'=>'disabled'])->label('Dawn time') ?></td>
                                     <td style="padding: 36px;">
                                     <span data-toggle="tooltip" data-placement="top" title="Update" id="update_<?php  echo $value['auto_id']; ?>" class="btn btn-xs btn-primary pd-cus-btn update-po req_update" data-id="<?php echo $value['auto_id'];?>"><i class="fa fa-edit"></i></span>  
                                            <span data-toggle="tooltip" data-placement="top" title="Save Changes" id="update_save_<?php  echo $value['auto_id']; ?>" class="btn btn-xs btn-success pd-cus-btn hide update-po req_update_save" data-id="<?php echo $value['auto_id'];?>" data-itemid="<?php echo $value['auto_id'];?>"><i class="fa fa-check"></i></span>
                                            <span id="feed_back"></span>  
                                            <td>
                                  </tr> 
                            <?php   
                             }else if ($prayer_key =="Surise"){ ?>
                                  <tr>
                                    <th style="padding: 36px;text-align: center;"><?php echo $prayer_name; ?></th>
                                    <td style="padding: 36px;">:</td>
                                    <td><?= $form->field($model, 'time1')->textInput(['maxlength' => true,'id'=>'prayertimings-time1'.$auto_id.'','class'=>'form-control time1','value'=>$time1,'disabled'=>'disabled'])->label('Surise Time') ?></td>
                                     <td style="padding: 36px;">
                                     <span data-toggle="tooltip" data-placement="top" title="Update" id="update_<?php  echo $value['auto_id']; ?>" class="btn btn-xs btn-primary pd-cus-btn update-po req_update" data-id="<?php echo $value['auto_id'];?>"><i class="fa fa-edit"></i></span>  
                                            <span data-toggle="tooltip" data-placement="top" title="Save Changes" id="update_save_<?php  echo $value['auto_id']; ?>" class="btn btn-xs btn-success pd-cus-btn hide update-po req_update_save" data-id="<?php echo $value['auto_id'];?>" data-itemid="<?php echo $value['auto_id'];?>"><i class="fa fa-check"></i></span> 
                                            <span id="feed_back"></span> 
                                            <td>
                                  </tr> 
                            <?php   
                             }else if ($prayer_key =="Zawal"){ ?>
                                  <tr>
                                    <th style="padding: 36px;text-align: center;"><?php echo $prayer_name; ?></th>
                                    <td style="padding: 36px;">:</td>
                                    <td><?= $form->field($model, 'time1')->textInput(['maxlength' => true,'id'=>'prayertimings-time1'.$auto_id.'','class'=>'form-control time1','value'=>$time1,'disabled'=>'disabled'])->label('Zawal time') ?></td>
                                     <td style="padding: 36px;">
                                     <span data-toggle="tooltip" data-placement="top" title="Update" id="update_<?php  echo $value['auto_id']; ?>" class="btn btn-xs btn-primary pd-cus-btn update-po req_update" data-id="<?php echo $value['auto_id'];?>"><i class="fa fa-edit"></i></span>  
                                            <span data-toggle="tooltip" data-placement="top" title="Save Changes" id="update_save_<?php  echo $value['auto_id']; ?>" class="btn btn-xs btn-success pd-cus-btn hide update-po req_update_save" data-id="<?php echo $value['auto_id'];?>" data-itemid="<?php echo $value['auto_id'];?>"><i class="fa fa-check"></i></span> 
                                            <span id="feed_back"></span> 
                                            <td>
                                  </tr> 
                            <?php   
                             }else if ($prayer_key =="Sunset"){ ?>
                                  <tr>
                                    <th style="padding: 36px;text-align: center;"><?php echo $prayer_name; ?></th>
                                    <td style="padding: 36px;">:</td>
                                    <td><?= $form->field($model, 'time1')->textInput(['maxlength' => true,'id'=>'prayertimings-time1'.$auto_id.'','class'=>'form-control time1','value'=>$time1,'disabled'=>'disabled'])->label('Sunset Time') ?></td>
                                     <td style="padding: 36px;">
                                     <span data-toggle="tooltip" data-placement="top" title="Update" id="update_<?php  echo $value['auto_id']; ?>" class="btn btn-xs btn-primary pd-cus-btn update-po req_update" data-id="<?php echo $value['auto_id'];?>"><i class="fa fa-edit"></i></span>  
                                            <span data-toggle="tooltip" data-placement="top" title="Save Changes" id="update_save_<?php  echo $value['auto_id']; ?>" class="btn btn-xs btn-success pd-cus-btn hide update-po req_update_save" data-id="<?php echo $value['auto_id'];?>" data-itemid="<?php echo $value['auto_id'];?>"><i class="fa fa-check"></i></span> 
                                            <span id="feed_back"></span> 
                                            <td>
                                  </tr> 
                            <?php   
                             }else if ($prayer_key =="Fasting"){ ?>
                                  <tr>
                                    <th style="padding: 36px;text-align: center;"><?php echo $prayer_name; ?></th>
                                    <td style="padding: 36px;">:</td>
                                    <td><?= $form->field($model, 'time1')->textInput(['maxlength' => true,'id'=>'prayertimings-time1'.$auto_id.'','class'=>'form-control time1','value'=>$time1,'disabled'=>'disabled'])->label('Sahr Start Time') ?></td>
                                    <td><?= $form->field($model, 'time2')->textInput(['maxlength' => true,'id'=>'prayertimings-time2'.$auto_id.'','class'=>'form-control time1','value'=>$time2,'disabled'=>'disabled'])->label('Sahr End Time') ?></td>
                                    <td><?= $form->field($model, 'time3')->textInput(['maxlength' => true,'id'=>'prayertimings-time3'.$auto_id.'','class'=>'form-control time1','value'=>$time3,'disabled'=>'disabled'])->label('Iftar Time') ?></td>
                                     <td style="padding: 36px;">
                                     <span data-toggle="tooltip" data-placement="top" title="Update" id="update_<?php  echo $value['auto_id']; ?>" class="btn btn-xs btn-primary pd-cus-btn update-po req_update" data-id="<?php echo $value['auto_id'];?>"><i class="fa fa-edit"></i></span>  
                                            <span data-toggle="tooltip" data-placement="top" title="Save Changes" id="update_save_<?php  echo $value['auto_id']; ?>" class="btn btn-success pd-cus-btn hide update-po req_update_save" data-id="<?php echo $value['auto_id'];?>" data-itemid="<?php echo $value['auto_id'];?>"><i class="fa fa-check"></i></span> 
                                            <span id="feed_back"></span> 
                                            <td>
                                  </tr> 
                            <?php   
                             }
                           }
                       } ?> 
                        </table>
                          </div>
                      </div>
                            <!-- <div class="row">
                                <div class="form-group mb_0 pull-right">
                                    <?//= Html::submitButton($model->isNewRecord ? 'Save' : 'Save', ['class' => $model->isNewRecord ? 'btn btn-create createBtn btn-success' : 'btn btn-primary','required'=>true]) ?>
                                    <?//= Html::a('Cancel', ['index'], ['class' => 'btn btn-default']) ?>
                                </div>
                            </div> -->
                            
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
   

    $(function () {
        $("#eventDate").datepicker({ 
            autoclose: true, 
           // todayHighlight: true,
            format:'dd-mm-yyyy'
        });
    });




 $('body').on('click','.req_update_save',function(){
        var val =$(this).attr('data-id');
        var item =$(this).attr('data-itemid');
        var time1= $('#prayertimings-time1'+val).val();
        var time2= $('#prayertimings-time2'+val).val();
        var time3= $('#prayertimings-time3'+val).val();
        var time4= $('#prayertimings-time4'+val).val();
        $("#prayertimings-time1"+val).attr("disabled", true);
        $("#prayertimings-time2"+val).attr("disabled", true);
        $("#prayertimings-time3"+val).attr("disabled", true);
        $("#prayertimings-time4"+val).attr("disabled", true);
        setTimeout(function(){ 
            $("#feed_back").html("<span style='color:green';>Saving...</span>"); 
        }, 100);
        $.ajax({
            url:'<?php echo Yii::$app->homeUrl . "?r=prayer-timings/single-update&id=";?>'+val,
            method:'POST',
            data:{'time1':time1,'time2':time2,'time3':time3,'time4':time4,},
            success:function(response)
            {
             $("#feed_back").html("");
            }
            
        });
         $("#update_save_"+val).addClass('hide');
         $("#update_"+val).show();
         //$(this).hide();
    });
$('body').on('click','.req_update',function(){
        var val =$(this).attr('data-id');
        $("#prayertimings-time1"+val).attr("disabled", false);
        $("#prayertimings-time2"+val).attr("disabled", false);
        $("#prayertimings-time3"+val).attr("disabled", false);
        $("#prayertimings-time4"+val).attr("disabled", false);
        $("#update_save_"+val).removeClass('hide');
       
        $(this).hide();
    });

$(document).on("click","#prayertimings-time11,#prayertimings-time21,#prayertimings-time12,#prayertimings-time22,#prayertimings-time13,#prayertimings-time23,#prayertimings-time14,#prayertimings-time24,#prayertimings-time15,#prayertimings-time25,#prayertimings-time16,#prayertimings-time26,#prayertimings-time17,#prayertimings-time27,#prayertimings-time37,#prayertimings-time47,#prayertimings-time18,#prayertimings-time19,#prayertimings-time110,#prayertimings-time111,#prayertimings-time112,#prayertimings-time113,#prayertimings-time114,#prayertimings-time214,#prayertimings-time314"
    ,function(){
    var d = new Date();
    var current_time = moment(d).format('hh:mm A'); // time format with moment.js
    $(this).timepicker('setTime', current_time); // setting timepicker to current time
    $(this).val(current_time);
});

</script>
<style type="text/css">
    
    input[type="file"] {
  display: block;
}
</style>
