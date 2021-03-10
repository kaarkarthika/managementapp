<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\SwimServicecenterlogin */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Swim Servicecenterlogins', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="swim-servicecenterlogin-view">

    <!-- <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p> -->

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
           // 'id',
            'servicecentername',
            'username',
           // 'password_hash',
            //'created_at',
           // 'first_name',
            // 'last_name',
            // 'dob',
            // 'user_type',
            // 'city',
            // 'auth_key',
            
            // 'password_reset_token',
            // 'status',
            
            // 'updated_at',
            // 'rights:ntext',
            // 'status_flag',
            // 'user_level',
            // 'mobile_number',
            // 'designation',
        ],
    ]) ?>

</div>
