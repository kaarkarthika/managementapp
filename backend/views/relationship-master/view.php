<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\RelationshipMaster */

// $this->title = $model->id;
// $this->params['breadcrumbs'][] = ['label' => 'Relationship Masters', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="relationship-master-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            'relation_type',
            // 'description:ntext',
            // 'active_status',
            // 'created_at',
            // 'updated_at',
        ],
    ]) ?>

</div>
