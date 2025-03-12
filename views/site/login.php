<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */

/** @var app\models\LoginForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use yii\helpers\Url;
use yii\bootstrap5\Modal;


$this->title = 'Вход в личный кабинет';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="site-login container">

    <h3><?= Html::encode($this->title) ?></h3>

    <p>Пожалуйста, заполните следующие поля для входа в систему:</p>

    <div class="row">
        <div class="col-lg-5">

            <?php $form = ActiveForm::begin([
                'id' => 'login-form',
                'layout' => 'horizontal',
                'fieldConfig' => [
                    'template' => "{label}\n{input}\n{error}",
                    'labelOptions' => ['class' => 'col-lg-1 col-form-label mr-lg-3'],
                    'inputOptions' => ['class' => 'col-lg-3 form-control'],
                    'errorOptions' => ['class' => 'col-lg-7 invalid-feedback'],
                ],
            ]); ?>

            <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

            <?= $form->field($model, 'password')->passwordInput() ?>

            <?= $form->field($model, 'rememberMe')->checkbox([
                'template' => "<div class=\"custom-control custom-checkbox\">{input} {label}</div>\n<div class=\"col-lg-8\">{error}</div>",
            ]) ?>

            <div id="block-entry-and-registration">
                
                <div><?= Html::submitButton('Вход', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?></div>
                <div> Новый пользователь? <a href="<?=Url::to(['/user/create'])?>">   Зарегистрируйтесь.</a> </div>

            </div>

            <div style="margin-top: 15px;"><a href="#" data-bs-toggle="modal" data-bs-target="#myModal">Забыли пароль ?</a></div>

            <?php ActiveForm::end(); ?>

            
        </div>
    </div>
</div>


<?php

Modal::begin([
    'title' => '<h4> Востановление пароля </h4>',
    'id' => 'myModal',
    'size' =>'modal-md',
    'footer' => '',
]);
?>

<form action="/user/new-pass" method="post">
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Email</label>
    <input type="email" name="email" class="form-control form-control-sm" id="exampleInputEmail1" aria-describedby="emailHelp">
    <!--<div id="emailHelp" class="form-text">Поле не может быть пустым!</div>-->
  </div>
 	
  <input type="hidden" name="<?= Yii::$app->request->csrfParam; ?>" value="<?= Yii::$app->request->csrfToken; ?>" />

  <button type="submit" class="btn btn-primary btn-sm">Востановить пароль</button>
</form>

<?php Modal::end();

?>

