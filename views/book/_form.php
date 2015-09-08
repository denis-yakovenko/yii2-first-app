<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;
use yii\widgets\DetailView;
use app\models\Author;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Book */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="book-form">

    <div class="row">
        <div class="col-sm-2">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= Html::img('uploads/'. $model->preview,['style'=>'width:100px']) ?>
	
    <?= $form->field($model, 'preview_file')->fileInput(['accept' => 'image/*']) ?>

    <?= $form->field($model, 'date')->widget(DatePicker::classname(), ['options' => ['class' => 'form-control']]) ?>

    <?= $form->field($model, 'author_id')->dropDownList(Author::getFullNamesList(), ['prompt'=>'Выберите автора...']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    </div>
    </div>

</div>
