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

    .thistableonly {
      border-collapse: collapse;
      width: 100%;
    }

    .thistableonly td, table th {
      /*border: 1px solid #ddd;*/
      padding: 8px;
    }
    .thistableonly tr:nth-child(even){background-color: #dedede;}

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
                                            <table class="table thistableonly">
                                                <tr>
                                                    <td>Name</td>
                                                    <td><?php echo $model->familyHeadName; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Age</td>
                                                    <td><?php echo $model->headAge; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Gender</td>
                                                    <td><?php echo $model->headGender; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Education</td>
                                                    <td><?php echo $model->headEducation; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Occupation</td>
                                                    <td><?php echo $model->headOccupation; ?></td>
                                                </tr>
                                            </table>                                            
                                        </div>                                        
                                    </fieldset>
                                </div>
                            </div>

                            <div class="row">
                                <div  class="col-sm-12 form-group mb_0" >
                                    <fieldset class="scheduler-border">
                                        <legend class="scheduler-border">Contact Information</legend>
                                        <table class="thistableonly">
                                                <tr>
                                                    <td>Contact Number</td>
                                                    <td><?php echo $model->contactNumber; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Alternate Phone Number</td>
                                                    <td><?php echo $model->alternatePhoneNumber; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Email Address</td>
                                                    <td><?php echo $model->emailId; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Address</td>
                                                    <td><?php echo $model->address; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Landmark</td>
                                                    <td><?php echo $model->landMark; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Comments</td>
                                                    <td><?php echo $model->description; ?></td>
                                                </tr>
                                            </table> 
                                    </fieldset>
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

                            <div class="form-group mb_0 pull-right">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">Close</button>
                            </div>
                            <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>