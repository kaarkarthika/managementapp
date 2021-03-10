<?php

$session = Yii::$app->session;
$session['user_logintype'];
//echo "<pre>";print_r($_SESSION);die;
$menu_data_array = array();
use backend\models\Shortcut;
use backend\models\ApiVersion;
use yii\helpers\Url;

 if($session['user_logintype']=='T1')
 {
  $menu_data_array[0] = array('one', 'Dashboard', Yii::$app -> homeUrl, '<i class="fa fa-dashboard"></i>', 'site/index');
 
 
 $menu_data_array[9] = array('one', 'Mosque Details', Yii::$app->homeUrl.'?r=mosque-details', '<i class="fa fa-user" aria-hidden="true"></i>', 'mosque-details');

 $menu_data_array[1] = array('one', 'Family Mgmt', Yii::$app->homeUrl.'?r=family-master', '<i class="fa fa-user" aria-hidden="true"></i>', 'family-master');

  $menu_data_array[2] = array('one', 'Donation Mgmt', Yii::$app->homeUrl.'?r=donation-management', '<i class="fa fa-user" aria-hidden="true"></i>', 'donation-management');

  $menu_data_array[11] = array('one', 'Income Mgmt', Yii::$app->homeUrl.'?r=income-management', '<i class="fa fa-user" aria-hidden="true"></i>', 'income-management');

  $menu_data_array[3] = array('one', 'Prayer Timings ', Yii::$app->homeUrl.'?r=prayer-timings/create', '<i class="fa fa-gavel"></i>', 'prayer-timings/create'); 

  $menu_data_array[4] = array('one', 'Marriage Registration', Yii::$app->homeUrl.'?r=marriage-certificate', '<i class="fa fa-gavel"></i>', 'marriage-certificate'); 

  $menu_data_array[10] = array('one', 'Death Registration', Yii::$app->homeUrl.'?r=death-certificates', '<i class="fa fa-gavel"></i>', 'death-certificates'); 

 /* $menu_data_array[4]=array('more','Marriage & Death Index','#','<i class="fa fa-fw fa-building"></i>','marriage-certificate','death-certificates');

  $menu_data_array[4]['sub'][0]=array('Marriage Registration',Yii::$app->homeUrl.'?r=marriage-certificate','<i class="fa fa-list"></i>','marriage-certificate','marriage-certificate');
  
  $menu_data_array[4]['sub'][1]=array('Death Registration',Yii::$app->homeUrl.'?r=death-certificates','<i class="fa fa-history"></i>','death-certificates','death-certificates');*/

  $menu_data_array[5]=array('more','Master Data','#','<i class="fa fa-fw fa-building"></i>','relationship-master','donation-type-master');

  $menu_data_array[5]['sub'][0]=array('Relationship Master',Yii::$app->homeUrl.'?r=relationship-master','<i class="fa fa-list"></i>','relationship-master','relationship-master');
  
  $menu_data_array[5]['sub'][1]=array('Donation Modes ',Yii::$app->homeUrl.'?r=donation-type-master','<i class="fa fa-history"></i>','donation-type-master','donation-type-master');
  
  $menu_data_array[5]['sub'][2]=array('Income Modes',Yii::$app->homeUrl.'?r=income-type-master','<i class="fa fa-history"></i>','income-type-master','income-type-master');

  $menu_data_array[5]['sub'][3]=array('Designation Master',Yii::$app->homeUrl.'?r=designation-master','<i class="fa fa-history"></i>','designation-master','designation-master');

  $menu_data_array[5]['sub'][4]=array('Expenses Master',Yii::$app->homeUrl.'?r=expenses-master','<i class="fa fa-history"></i>','expenses-master','expenses-master');

  $menu_data_array[6] = array('one', 'Committee & Staff Mgmt', Yii::$app->homeUrl.'?r=commitee-management', '<i class="fa fa-gavel"></i>', 'commitee-management');
  $menu_data_array[7] = array('one', 'Expenses Mgmt', Yii::$app->homeUrl.'?r=expenses-management', '<i class="fa fa-gavel"></i>', 'expenses-management');

 
  // $menu_data_array[8] = array('one', 'Color System', Yii::$app->homeUrl.'?r=colorsystem/index', '<i class="fa fa-th-large"></i>', 'colorsystem/index');
}
$html_menu_out = '';
$controler_url_id = Yii::$app ->controller->id;
$active_url_id = Yii::$app ->controller->action->id;
$html_menu_out_tmp = $controler_url_id . "/" . $active_url_id;
//$html_menu_out .= $html_menu_out_tmp;
foreach ($menu_data_array as $one_ig => $one_menus) {//echo "<pre>";print_r($one_menus);
	if (count($one_menus) > 0) {
		if ($one_menus[0] == 'more') {
			$isselct = '';
			if ($controler_url_id == $one_menus[4]) {$isselct = 'active';
			}//echo $isselct;
			$html_menu_out2 = '<ul class="treeview-menu">';
			foreach ($one_menus['sub'] as $one_submenus) {
				$isactive = '';
				if ($active_url_id == "index") {
					if ($active_url_id == $one_submenus[4] || $controler_url_id == $one_submenus[4]) {
						$isactive = 'class="active"';
						if ($isselct == '') {
							$isselct = 'active';
						}
					}
				} else {
					if ($active_url_id == $one_submenus[4]) {$isactive = 'class="active"';
					}
				}
				$html_menu_out2 .= '<li ' . $isactive . '><a href="' . $one_submenus[1] . '">' . $one_submenus[2] . '' . $one_submenus[0] . '</a></li>';
			}
			$html_menu_out1 = '<li class="treeview ' . $isselct . '"><a href="#">' . $one_menus[3] . ' <span>' . $one_menus[1] . '</span><i class="fa fa-angle-left pull-right"></i></a>';
			$html_menu_out2 .= '</ul></li>';
			$isselct = '';
			$html_menu_out .= $html_menu_out1 . $html_menu_out2;
		} elseif ($one_menus[0] == 'one') {
			$isselct = '';
			
			if ($active_url_id == "index") {
				if ($controler_url_id.'/'.$active_url_id == $one_menus[4] ) {$isselct = 'active';
				//die;
				}
			} else {
				if ($html_menu_out_tmp == $one_menus[4]) {

					$isselct = 'active';
				}
			}
			$html_menu_out .= '<li class="treeview ' . $isselct . '"> 
		              <a href="' . $one_menus[2] . '">' . $one_menus[3] . ' <span>' . $one_menus[1] . '</span></a></li>';
		}
	}
}
?>
<aside class="main-sidebar">
<!-- sidebar: style can be found in sidebar.less -->
<section class="sidebar">
<!-- Sidebar user panel
<div class="user-panel">
<div class="pull-left image">
<img src="../dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
</div>
<div class="pull-left info">
<p>Alexander Pierce</p>
<a href="#"><i class="fa fa-circle text-success"></i> Online</a>
</div>
</div>-->
<!-- search form
<form action="#" method="get" class="sidebar-form">
<div class="input-group">
<input type="text" name="q" class="form-control" placeholder="Search...">
<span class="input-group-btn">
<button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
</span>
</div>
</form>
<!-- /.search form -->
<!-- sidebar menu: : style can be found in sidebar.less -->
<ul class="sidebar-menu">
<?php echo $html_menu_out; ?>

</ul>
</section>

<!-- /.sidebar -->
</aside>