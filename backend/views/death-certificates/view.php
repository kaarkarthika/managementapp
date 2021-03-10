<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\DeathCertificates */

// $this->title = $model->id;
// $this->params['breadcrumbs'][] = ['label' => 'Death Certificates', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="death-certificates-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
           // 'id',
            'demised_name',
           // 'death_date',
            [
                'attribute' => 'death_date',
                'value' => function($models,$keys){
                    $data = date('d-m-Y',strtotime($models->death_date));
                    if(strpos($data, '1970') || strpos($data, '0000')){
                        $data = "-";
                    }
                    return $data;
                }
            ],
            'contact_person',
            'relation_ship',
            'address:ntext',
            // 'created_at',
            // 'updated_at',
        ],
    ]) ?>

</div>
