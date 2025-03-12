<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Authors;


$params = [
    'prompt' => 'Укажите автора'
];

/** @var yii\web\View $this */
/** @var app\models\Books $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="books-form">

<?php $form = ActiveForm::begin([
        'id' => 'test-form',
        'options' => ['enctype' => 'multipart/form-data'],
    ]); ?>

    <?= $form->field($model, 'author_id')->dropDownList(ArrayHelper::map(Authors::find()->asArray()->all(),'id','FIO'), $params) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'year_release')->input('date') ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'isbn')->textInput(['maxlength' => true]) ?>


    <?php if (!empty($model->photo)) : ?>
        <img src="/images/<?= $model->photo ?>" width="200">
    <?php endif; ?>
    
    <label class="control-label" for="upload_image">Обложка</label>
    <input type="hidden" name="MAX_FILE_SIZE" value="5000000" />
    <input style="margin-top: 15px; margin-bottom: 20px" type="file" name="upload_image" />

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
