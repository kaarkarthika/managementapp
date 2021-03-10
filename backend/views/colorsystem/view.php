<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Colorsystem */

$this->title = $model->color_id;
$this->params['breadcrumbs'][] = ['label' => 'Colorsystems', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="colorsystem-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->color_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->color_id], [
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
            'color_id',
            'color_code',
            'color_name',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
