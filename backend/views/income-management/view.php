<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\IncomeManagement */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Income Managements', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="income-management-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'income_type',
            'income_date',
            'incomeAmount',
            'card_number',
            'bankName',
            'cardHolderName',
            'reference_number',
            'others:ntext',
            'payer_name',
            'contact_number',
            'payer_address:ntext',
            'payer_description:ntext',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
