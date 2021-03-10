<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\CommiteeManagement */

// $this->title = $model->name;
// $this->params['breadcrumbs'][] = ['label' => 'Commitee Managements', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="commitee-management-view">

    

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
          //  'id',
            'name',
          //  'age',
            'designation',
            // 'education',
            // 'present_address:ntext',
            // 'permanent_address:ntext',
            // 'salary',
            // 'benefits1:ntext',
            // 'benefits2:ntext',
            // 'benefits3:ntext',
            // 'active_status',
            // 'created_at',
            // 'updated_at',
        ],
    ]) ?>

</div>
