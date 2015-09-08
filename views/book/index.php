<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\DetailView;


/* @var $this yii\web\View */
/* @var $searchModel app\models\BookSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Книги';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="book-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name',
			[
                'class' => 'yii\grid\DataColumn',
                'attribute' => 'preview',
                'format'=>'raw',
                'value'=>function($data){
					return Html::a(Html::img('uploads/'. $data->preview,['style'=>'width:50px']),   '#preview-'.$data->id, ['class'=>'btn btn-icon','data-toggle'=>'modal','role'=>'button']).
                    '<div id="preview-'.$data->id.'" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h4 class="modal-title">'.$data->name.'</h4>
                                </div>
                                <div class="modal-body with-padding">
									'.Html::img('uploads/'. $data->preview,['style'=>'width:100%']).'
                                </div>
                            </div>
                        </div>
                    </div>';
                }
            ],
            'author.name',
            [
                'class' => 'yii\grid\DataColumn',
                'attribute' => 'date',
                'format' =>  ['date', 'php:d F Y']
            ],
            [
                'class' => 'yii\grid\DataColumn',
                'attribute' => 'date_create',
                'format' =>  ['date', 'php:d F Y']
            ],
            [
                'class' => 'yii\grid\DataColumn',
                'attribute' => 'date_update',
                'format' =>  ['date', 'php:d F Y']
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {view} {delete}',
                'buttons'  => [
                    'update' => function($url, $model) {
                        return Html::a('[ред]', $url, [/*'target' => '_blank'*/]);
                    },
                    'delete' => function($url, $model) {
                        return Html::a('[удл]', $url, [
                                                          'data-method' => 'post',
                                                          'data-confirm'=> 'Вы точно хотите удалить запись об этой книге?'
                                                      ]);
                    },
                    'view' => function($url,$model){
                        return Html::a('[просм]',   '#book-'.$model->id, ['class'=>'btn btn-icon','data-toggle'=>'modal','role'=>'button']).
                    '<div id="book-'.$model->id.'" class="modal fade" tabindex="-1" role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h4 class="modal-title">'.$model->name.'</h4>
                                </div>
                                <div class="modal-body with-padding">
                                    '.DetailView::widget([
                                                            'model' => $model,
                                                            'attributes' => [
                                                                                [
                                                                                    'class' => 'yii\grid\DataColumn',
                                                                                    'attribute' => 'date',
                                                                                    'format' =>  ['date', 'php:d F Y']
                                                                                ],
                                                                                [
                                                                                    'class' => 'yii\grid\DataColumn',
                                                                                    'attribute' => 'date_create',
                                                                                    'format' =>  ['date', 'php:d F Y']
                                                                                ],
                                                                                [
                                                                                    'class' => 'yii\grid\DataColumn',
                                                                                    'attribute' => 'date_update',
                                                                                    'format' =>  ['date', 'php:d F Y']
                                                                                ],
                                                                                'author.name',
                                                                            ],
                                                         ]).'
                                    '.Html::img('uploads/'. $model->preview,['style'=>'width:100%']).'
                                </div>
                            </div>
                        </div>
                    </div>';
                },
                ]
            ],
        ],
    ]); ?>

    <p>
        <?= Html::a('Новая книга', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

</div>
