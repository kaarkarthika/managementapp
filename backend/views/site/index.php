<?php
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use backend\models\MosqueDetails;

/* @var $this yii\web\View */

$this->title = 'MOSQUE MANAGEMENT - Dashboard';

//Set Default Timezone
date_default_timezone_set('Asia/Kolkata');
$chartData = '[';
?>
<style type="text/css">
	.table-bordered>thead>tr>th, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>tbody>tr>td, .table-bordered>tfoot>tr>td {
    border: 1px solid #adacac!important;
}
</style>
<?php //echo "<pre>";print_r($mosque_details['image']);die; 

$paths=array();
$data=json_decode($mosque_details['image']);
if(!empty($data)){
    foreach($data as $k){
        $imgs=$k;
        $paths[]= Url::base()."/uploads/mosque/".$imgs;
    }
} 

?> 
<div class="row">
        <div class="col-xs-12">
    <div class="box box-info">
<!-- 	 <div class="box-hea der with-border">
              <h3 class="box-title">Addition Information</h3>
            </div> -->
<!-- <div class="card-body">
    <div class="card-title">
        
        <div class="col-md-12">
           <table class="table table-borderless"> 
            <tr>
             <th scope="col" width="25%">Information</th>
            <th scope="col" width="40%">Value</th>
        </tr>
         <tbody>
              <?php   
           /* $Dimensions = ArrayHelper::toArray(json_decode($mosque_details['otherInformations'])) ;
            $content = "";
            $k = 0;
            if(!empty($Dimensions)){ 
                $k = 1;
                foreach ($Dimensions as $key => $value){ ?> 
                    <tr>
                        <td><?php echo $value['label'] ?></td>
                        <td><?php echo $value['value'] ?></td>
                    </tr>
              <?php  
             }
            }*/?>
     </tbody>
           </table>
</div>
</div>
</div> -->
<!-- <div class="card-body ">
    	<div class="table-responsive-xl">
        	<table class="table table-bordered table-dark" >
            	<thead class="thead-dark">
                	<tr>
                    	<th scope="col" width="6%">S.No</th>
                        <th scope="col" width="25%">Donation Type</th>
                        <th scope="col" width="25%">Donation Date</th>
                        <th scope="col" width="10%">Donation Amount</th>
                    </tr>
            	</thead>
            	<tbody class="fields process" id="DymentionTableBody">
            		<?php
            			/*if(!empty($donationData)){
            				$sn0 =1;
            				$cont = "";
            				$ovTot = 0;
            				foreach ($donationData as $month => $donationDataAll) {
            					
            					$dateObj   = DateTime::createFromFormat('!m', $month);
            					$monthName = $dateObj->format('F');
            					if($sn0>2){
            						// echo $monthName;die;

            					}
            					$mnTot = 0;
            					$cont .= "<tr ><td colspan='4' align='center'><b>".$monthName." Month's Donation List</b></td></tr>";
            					foreach ($donationDataAll as $key => $donationDataOne) {
            						// echo "<pre>";print_r($donationData);die;
            						$donation_date = date('d-m-Y',strtotime($donationDataOne['created_at']));
            						if(strpos($donation_date, '1970')||strpos($donation_date, '0000')){
            							$donation_date = "-";
            						}
            						$cont .= '
            							<tr>
            								<td>'.$sn0.'</td>
            								<td>'.strtoupper($donationDataOne['donation_type']).'</td>
            								<td>'.$donation_date.'</td>
            								<td align="right">'.$donationDataOne["donationAmount"].'</td>
            							</tr>
            						';
            						$sn0++;
            						if($donationDataOne["donationAmount"]!=""&&$donationDataOne["donationAmount"]!=NULL){
            							if(is_numeric($donationDataOne["donationAmount"])){
	            							$mnTot += floatval($donationDataOne["donationAmount"]) ;
	            							$ovTot += floatval($donationDataOne["donationAmount"]);
            							}
            							// echo $donationDataOne["donationAmount"];die;
            						}
            					}
            					$chartData .= '{
            						"month": "'.$monthName.'",
            						"donationAmount": '.$mnTot.'
            					},';
            					$cont .= "
            						<tr >
            							<td colspan='3' align='right'><b>Month's Total</b></td>
            							<td align='right'>".$mnTot."</td>
        							</tr>";
            				}
            				$cont .= '
            						<tr >
            							<td colspan="3" align="right"><b>Overall Donation Amount</b></td>
            							<td align="right">'.$ovTot.'</td>
        							</tr>';

            				echo $cont;
            			}
            			$chartData .= ']';*/
            		?>                     
                </tbody>
            </table>
        </div>
</div> -->
    <div class="box box-info">
            <div class="box-hea der with-border">
              <h3 class="box-title">Mosque Details</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <table class="table">
        <tr>
          <th>Name</th>
        <td>:</td>
        <td><?php echo $mosque_details['name']; ?></td>
        </tr>
         <tr>
          <th>Popular Name</th>
        <td>:</td>
        <td><?php echo $mosque_details['popularName']; ?></td>
        </tr>
         <tr>
          <th>Phone Number</th>
        <td>:</td>
        <td><?php echo $mosque_details['phoneNumber']; ?></td>
        </tr>
         <tr>
          <th>Alternate Phone Number</th>
        <td>:</td>
        <td><?php echo $mosque_details['alternatePhoneNumber']; ?></td>
        </tr> <tr>
          <th>Email Id</th>
        <td>:</td>
        <td><?php echo $mosque_details['emailId']; ?></td>
        </tr> 
              <tr>
          <th>Landmark</th>
        <td>:</td>
        <td><?php echo $mosque_details['landmark'];?></td>
        </tr> <tr>
                 <?php 
                if(!empty($paths)){ ?>
                <th>Image</th>
                <td>:</td>
                <?php foreach ($paths as $key => $one) { ?>    
                <td><img class="imageThumb" src="<?php echo $one; ?>"></td>
                <?php 
            }
        }
            ?>
              </tr>  
              <tr>  
              <th>GoogleMapLink</th>      
              <td>:</td>
                <td><a href="<?php echo $mosque_details['googleMapLink']; ?>" target="_blank">Check Google Map Here</a></td>
              </tr>          
              <tr>
                <th>LicenceCode</th>
                <td>:</td>
                <td><?php echo $mosque_details['licenceCode']; ?></td>
              </tr>  
              <tr> 
              <th>Description</th>       
              <td>:</td>
                <td><?php echo $mosque_details['description']; ?></td>
              </tr>
      </table>
          </div>
        <!-- /.col -->

         
       
       
      </div>
</div>
        </div>
        
		<!-- /.col -->
        

<!-- Styles -->
<style>
#chartdiv {
  width: 100%;
  height: 500px;
}

</style>

<!-- Resources -->
<script src="https://www.amcharts.com/lib/4/core.js"></script>
<script src="https://www.amcharts.com/lib/4/charts.js"></script>
<script src="https://www.amcharts.com/lib/4/themes/animated.js"></script>

<!-- Chart code -->
<!-- <h3>This Year's Month-on-Month Donations</h3> -->
<script>
am4core.ready(function() {

// Themes begin
am4core.useTheme(am4themes_animated);
// Themes end

// Create chart instance
var chart = am4core.create("chartdiv", am4charts.XYChart);

// Add data
chart.data = <?php echo $chartData; ?>;

// Create axes

var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
categoryAxis.dataFields.category = "month";
categoryAxis.renderer.grid.template.location = 0;
categoryAxis.renderer.minGridDistance = 30;

categoryAxis.renderer.labels.template.adapter.add("dy", function(dy, target) {
  if (target.dataItem && target.dataItem.index & 2 == 2) {
    return dy + 25;
  }
  return dy;
});

var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());

// Create series
var series = chart.series.push(new am4charts.ColumnSeries());
series.dataFields.valueY = "donationAmount";
series.dataFields.categoryX = "month";
series.name = "Donations";
series.columns.template.tooltipText = "{categoryX}: [bold]{valueY}[/]";
series.columns.template.fillOpacity = .8;

var columnTemplate = series.columns.template;
columnTemplate.strokeWidth = 2;
columnTemplate.strokeOpacity = 1;

}); // end am4core.ready()
</script>

<!-- HTML -->
<div id="chartdiv"></div>