<?php 
//die;
namespace backend\components;
use Yii;
use yii\helpers\Html;
class MyGlobalClass extends \yii\base\Component{
    public function init() {
    		$session=Yii::$app->session;
			$request = Yii::$app->request;
			
		  	$s_G=$_SERVER['QUERY_STRING'];
			$s_G=trim($s_G);
			if(($s_G!=""  && $s_G!='r=site%2Flogin') && $session['user_logintype']==""){
				echo '<center><div style="border:#999999 solid 2px;;width:25%;">';
				
				echo "</br>";
				echo '<a>'
                      . Html::beginForm(['/site/login'], 'post')
                      . Html::submitButton(
                          '<span>Go To Login Page</span> <i class="fa fa-fw fa-sign-out"></i> ',
                          ['class' => 'button']
                      )
                      . Html::endForm()
                      . '</a>';
					  
					  echo "<span style='font-size:16px;font-weight:bold;'>You're being timed out due to inactivity.<br>Otherwise,You will logged off automatically.</span>";
                      echo "<br>";
					   echo "<br>";
					 // echo "<span style='font-size:12px;'>© ".date('Y')." Exeleride. All rights reserved.<br><br>";
					  echo '</div><center>';
echo '<style>
.button {
  border-radius: 4px;
  background-color: #f4511e;
  border: none;
  color: #FFFFFF;
  text-align: center;
  font-size: 18px;
  padding: 6px;
  width: 200px;
  transition: all 0.5s;
  cursor: pointer;
  margin: 5px;
}

.button span {
  cursor: pointer;
  display: inline-block;
  position: relative;
  transition: 0.5s;
}

.button span:after {
  content: "\00bb";
  position: absolute;
  opacity: 0;
  top: 0;
  right: -20px;
  transition: 0.5s;
}

.button:hover span {
  padding-right: 25px;
}

.button:hover span:after {
  opacity: 1;
  right: 0;
}
</style>';
                     $session->destroy();   
			die;
			}else{
				
			}

        parent::init();
    }
}
 ?>