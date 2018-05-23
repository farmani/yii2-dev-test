<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use dosamigos\datepicker\DatePicker;
use yii\helpers\ArrayHelper;
use \app\models\Client;
use yii\db\Expression;

/* @var $this yii\web\View */
/* @var $model app\models\Contract */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="contract-form">

    <?php $form = ActiveForm::begin(['class' => 'form-horizontal','layout' => 'horizontal']); ?>

    <?= $form->field($model, 'number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'date')->widget(
        DatePicker::class, [
        'inline' => false,
        'clientOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-m-dd'
        ]
    ]) ?>

    <?= $form->field($model, 'amount')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'buyer_id')
        ->dropDownList(ArrayHelper::map(
            Client::find()->select(
                ['id', new Expression('CONCAT(name, " ", surname) AS fullName')])
                ->asArray()->all(), 'id', 'fullName')
        )->label(Yii::t('app','Buyer')) ?>

    <?= $form->field($model, 'seller_id')
        ->dropDownList(ArrayHelper::map(
            Client::find()->select(
                ['id', new Expression('CONCAT(name, " ", surname) AS fullName')])
                ->asArray()->all(), 'id', 'fullName')
        )->label(Yii::t('app','Seller')) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <div class="form-group pull-right">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
