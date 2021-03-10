<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\ApiVersion */

$this->title = $model->auto_id;
$this->params['breadcrumbs'][] = ['label' => 'Api Versions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="api-version-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->auto_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->auto_id], [
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
            'auto_id',
            'apps_name',
            'app_version',
            'force_update',
            'version_key',
            'create_at',
            'update_at',
        ],
    ]) ?>

</div>
