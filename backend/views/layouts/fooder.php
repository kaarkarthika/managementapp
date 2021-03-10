<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Modal;
?>
      <footer class="main-footer">
        <div class="pull-right hidden-xs">
          <b></b>
        </div>
        <strong>&copy; <?= date('Y') ?>  Mosque Management </strong> All rights reserved.
      </footer>

<!--Common Modal Starts For Delete -->
<?php 
    Modal::begin([
                    'header' => '<h3 id="customheader"> </h3>',
                    'id' => 'modal', 
                    'size' => 'modal-md',
                ]);
      echo "<div id='modalContent'>
            <div id='textContent'></div>
            <div class='modal-footer'>
                <input type='hidden' class='data1'>
                ".Html::a('<i class="fa fa-fw fa-check-square-o"></i> Yes', '#', ['class' => 'btn btn-primary deletatag', 'data-method' => 'post'])."
                <button class='btn' data-dismiss='modal' aria-hidden='true'><i class='fa fa-fw fa-ban'></i> No</button>

            </div> 
        </div>";
    Modal::end();

?>
<!--Common Modal End -->

<!--Common Modal Starts For Custom Operation -->
<?php 
    Modal::begin([
                    'header' => '<h3 id="operationalheader"> </h3>',
                    'id' => 'operationalmodal', 
                    'size' => 'modal-md',

                ]);
      echo "<div id='modalContenttwo'>
            <div id='customtwo'><input type='hidden' class='data2'></div>
        </div>";
    Modal::end();

?>
<!--Common Modal End -->

<!--Common Modal Starts For Custom Operation -->
<?php 
    Modal::begin([
                    'header' => '<h3 id="operationalheader_large"> </h3>',
                    'id' => 'operationalmodal_large', 
                    'size' => 'modal-lg',

                ]);
      echo "<div id='modalContenttwo_large'>
            <div id='customtwo_large'><input type='hidden' class='data2'></div>
        </div>";
    Modal::end();

?>
<!--Common Modal End -->
<script>
    //Delete Modal Call
    $(document).on('click', '.modalDelete', function(e){
        e.preventDefault();
         var url = $(this).val();
            $('.deletatag').attr("href", url);
            $('#customheader').html('<span style="color:red"> <i class="fa fa-trash"></i> Delete</span>');
            $('#textContent').html('<h4>Are you sure you want to <span style="color:red;">Delete</span> this item ?</h4>');
            $('#modal').modal('show').find('#modalContent').load();
    });
     
      $(document).on('click', '.modalDelete10', function(e){
        e.preventDefault();
         var url = $(this).val();
            $('.deletatag').attr("href", url);
            $('#customheader').html('<span style="color:red"> <i class="fa fa-ban"></i> Disable</span>');
            $('#textContent').html('<h4>Are you sure you want to <span style="color:red;">Disable</span> this customer ?</h4>');
            $('#modal').modal('show').find('#modalContent').load();
    });


     $(document).on('click', '.modalDelete1', function(e){
        e.preventDefault();
         var url = $(this).val();
            $('.deletatag').attr("href", url);
            $('#customheader').html('<span style="color:green"> <i class="fa fa-toggle-on"></i> Enable</span>');
            $('#textContent').html('<h4>Are you sure you want to <span style="color:green;">Enable</span> this customer ?</h4>');
            $('#modal').modal('show').find('#modalContent').load();
    });

    $(document).on('click', '.modalDelete2', function(e){
        e.preventDefault();
         var url = $(this).val();
            $('.deletatag').attr("href", url);
            $('#customheader').html('<span style="color:green"> <i class="fa fa-check" aria-hidden="true"></i> Approve</span>');
            $('#textContent').html('<h4>Are you sure <span style="color:green;">Approve</span> this Service ?</h4>');
            $('#modal').modal('show').find('#modalContent').load();
    });
 $(document).on('click', '.modalDelete3', function(e){
        e.preventDefault();
         var url = $(this).val();
            $('.deletatag').attr("href", url);
            $('#customheader').html('<span style="color:red"> <i class="fa fa-share" aria-hidden="true"></i> Cancel</span>');
            $('#textContent').html('<h4>Are you sure you want to <span style="color:red;">Cancel</span> this service type ?</h4>');
            $('#modal').modal('show').find('#modalContent').load();
    });

 $(document).on('click', '.modalDelete4', function(e){
        e.preventDefault();
         var url = $(this).val();
            $('.deletatag').attr("href", url);
            $('#customheader').html('<span style="color:red"> <i class="fa fa-check" aria-hidden="true"></i> Complete</span>');
            $('#textContent').html('<h4>Are you sure you want to <span style="color:red;">Complete</span> this service type ?</h4>');
            $('#modal').modal('show').find('#modalContent').load();
    });
   
    $(document).on('click', '.modalDelete5', function(e){
        e.preventDefault();
         var url = $(this).val();
            $('.deletatag').attr("href", url);
            $('#customheader').html('<span style="color:#034828"> <i class="fa fa-motorcycle" aria-hidden="true"></i> Picked</span>');
            $('#textContent').html('<h4>Are you sure you want to <span style="color:#2e3aca;">Pickup</span> this service type ?</h4>');
            $('#modal').modal('show').find('#modalContent').load();
    });

    $(document).on('click', '.modalDelete6', function(e){
        e.preventDefault();
         var url = $(this).val();
            $('.deletatag').attr("href", url);
            $('#customheader').html('<span style="color:#2eca33"> <i class="fa fa-paper-plane" aria-hidden="true"></i> Reached</span>');
            $('#textContent').html('<h4>Are you sure <span style="color:#2eca33;">Reached</span> this customer location?</h4>');
            $('#modal').modal('show').find('#modalContent').load();
    });

     $(document).on('click', '.modalDelete7', function(e){
        e.preventDefault();
         var url = $(this).val();
            $('.deletatag').attr("href", url);
            $('#customheader').html('<span style="color:#ff3b3b"> <i class="fa fa-hourglass-start" aria-hidden="true"></i> Start </span>');
            $('#textContent').html('<h4>Are you sure you want to <span style="color:#ff3b3b;">Start</span> this service ?</h4>');
            $('#modal').modal('show').find('#modalContent').load();
    });

    

    //Status Changes Model
    $(document).on('click', '.actionchange', function(e){
        e.preventDefault();
         var url = $(this).val();
            $('.deletatag').attr("href", url);
            $('#customheader').html('<span style="color:#195375"> <i class="fa fa-fw fa-info-circle"></i> Confirmation</span>');
            $('#textContent').html('<h4>Are you sure you want to <span style="color:#195375;">Change the Status</span> for this item ?</h4>');
            $('#modal').modal('show').find('#modalContent').load();
    });


    // Below Pagination class click for reload the page for ajax loading issue
    $(document).on('click', '.pagination', function(e){
        location.reload();
    });


    /* When Model is in Page the User Profile option will not come for avoid that bug the below code has been resolved it. */
     $(document).on('click', '.dropdown-toggle', function(e){
             $('.navbar-nav > .user ').toggleClass("open");
            $(".navbar-nav > .user > .dropdown-toggle").attr("aria-expanded","true");
        });

</script>


<script>
     /* isNumber Check could able enter only number onkeypress */
        // function isNumber(evt) {
        //     evt = (evt) ? evt : window.event;
        //     var charCode = (evt.which) ? evt.which : evt.keyCode;
        //     if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        //         return false;
        //     }
        //     return true;
        // }
        //KEY UP
         function isNumber(evt)
    {
        var this_value = evt.val();
        var num = this_value.replace(/\D/g, '');
        //        var num = this_value.replace(/\D[^+ -()]/g, '');
        evt.val(num);
    }
        /* isNumber End */


        /* To Check the uploading file image or not */
        $("#image").change(function () {
                var val = $(this).val();
                switch (val.substring(val.lastIndexOf('.') + 1).toLowerCase()) {
                case 'gif':
                case 'jpg':
                case 'png':
                    break;
                default:
                    $(this).val('');
                    // error message here
                    alert("File is Not an image! Please upload a image file.");
                    break;
            }
        });
        /* Image Validation End */

</script>