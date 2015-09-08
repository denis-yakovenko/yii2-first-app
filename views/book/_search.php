<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap\Alert;
use app\models\Author;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\BookSearch */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="book-search">

    <?php $form = ActiveForm::begin(['action' => ['index'], 'method' => 'get']); ?>

    <div class="row">

        <div class="col-sm-2">

            <?= $form->field($model, 'author_id')->dropDownList(Author::getFullNamesList(), ['prompt'=>'Выберите автора...']) ?>

        </div>

        <div class="col-sm-2">

            <?= $form->field($model, 'name') ?>

        </div>

        <div class="col-sm-2">

            <?= $form->field($model, 'date_from')->widget(\yii\jui\DatePicker::classname(), ['language' => 'ru', 'options'=>['class' => 'form-control']]) ?>

        </div>

        <div class="col-sm-2">

            <?= $form->field($model, 'date_to')->widget(\yii\jui\DatePicker::classname(), ['language' => 'ru', 'options'=>['class' => 'form-control']]) ?>

        </div>

        <div class="col-sm-2">

            <?= Html::submitButton('Искать', ['class' => 'btn btn-primary']) ?>

        </div>

    </div>

    <?php ActiveForm::end(); ?>

</div>
