<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\MarriageCertificate */

// $this->title = $model->id;
// $this->params['breadcrumbs'][] = ['label' => 'Marriage Certificates', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="marriage-certificate-view">

    <h1><?= Html::encode($this->title) ?></h1>


    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
           // 'id',
            'bride_name',
            'bride_age',
            'contact_number',
            'fathers_name',
            'mothers_name',
            // 'bride_address:ntext',
            'witness_name',
            'groom_name',
            'groom_age',
            'groom_contact_number',
            'groom_fathers_name',
            'groom_mothers_name',
            'wedding_date',
            [
                'attribute'=>'wedding_date',
                    'value' => function($models,$keys){
                    $data = date('d-m-Y',strtotime($models->wedding_date));
                    if(strpos($data, '1970') || strpos($data, '0000')){
                        $data = "-";
                    }
                    return $data;
                }
            ],
            'wedding_venue',
            // 'groom_address:ntext',
            // 'groom_witness_name:ntext',
            // 'created_at',
            // 'updated_at',
        ],
    ]) ?>

</div>
