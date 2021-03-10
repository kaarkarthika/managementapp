<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers', 
   // 'defaultRoute' => 'site/index',
    'components' => [
        'user' => [
            'identityClass' => 'common\models\Frontend',
            'enableAutoLogin' => true,
            'identityCookie' => [
                'name' => '_frontendUser', // unique for frontend
            ]
        ],
        'session' => [
            'name' => 'Swim987963frontend',
            'savePath' => sys_get_temp_dir(),
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'sdfafsdsd',
            'csrfParam' => '_frontendCSRF',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [

                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
     
      'urlManager' => [
            'class' => 'yii\web\UrlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => false,
            'rules' => [
                'userlogin'=>'customer-api/login',
                'verifyotp'=>'customer-api/verifyotp',
                'userprofile'=>'customer-api/updateprofile',
                'updatename'=>'customer-api/updatename',
                'servicetypelist'=>'customer-api/servicetypelist',
                'processdetails'=>'customer-api/processdetails',
                'servicedetails'=>'customer-api/servicedetails',
                'bookservice'=>'customer-api/bookservice',
                'bookservicelist'=>'customer-api/bookservicelist',
                'bookservicelistdetails'=>'customer-api/bookservicelistdetails',
                'updateservicenew'=>'customer-api/updateservice',
                'servicehistory'=>'customer-api/bookservicelisthistory',
                'servicehistoryview'=>'customer-api/bookservicelisthistoryview',
                'technicianlogin'=>'customer-api/technicianlogin',
                'technicianloginlist'=>'customer-api/technicianloginlist',
                'customerdetails'=>'customer-api/customerdetails',
                'quickservice'=>'customer-api/quickservice',
                'addressadd'=>'customer-api/addressadd',
                'addressdetails'=>'customer-api/addressdetails',
                'addressedit'=>'customer-api/addressedit',
                'techhistory'=>'customer-api/techhistory',
                'techhistoryview'=>'customer-api/techhistoryview',
                'technicianpickup'=>'customer-api/technicianpickup',
                'techlogout'=>'customer-api/techlogout',
                'servicecheck'=>'customer-api/servicecheck',
                'appversion'=>'category-management/appversion',
                'completestatus'=>'category-management/completestatus',
                'servicerating'=>'customer-api/servicerating',
                
                //'news/<id:\w+>' => 'newslisting/index', 
				
            ],  
        ],
        
    ],
    'params' => $params,
];
