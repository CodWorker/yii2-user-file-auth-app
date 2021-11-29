<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;

// var_dump($model->getErrors());

// var_dump(Yii::$app->session->get('currentUser'));exit;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php if( Yii::$app->session->hasFlash('expTimeMessage') ): ?>
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <?php echo Yii::$app->session->getFlash('expTimeMessage'); ?>
        </div>
<?php else: ?>

    <?php
    // Yii::$app->session->destroy();
        // var_dump('counterErrorLogin: ' ,Yii::$app->session->get('counterErrorLogin'));
        // var_dump('expTime: ' ,Yii::$app->session->get('expTime'));
        // var_dump('counterErrorLogin: ' ,Yii::$app->session->get('counterErrorLogin'));
    ?>



    <p>Заполните поля для входа в личный кабинет:</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

                <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'password')->passwordInput() ?>

                <?php //echo $form->field($model, 'rememberMe')->checkbox() ?>

                <!-- <div style="color:#999;margin:1em 0">
                    If you forgot your password you can <?= Html::a('reset it', ['site/request-password-reset']) ?>.
                    <br>
                    Need new verification email? <?= Html::a('Resend', ['site/resend-verification-email']) ?>
                </div> -->

                <div class="form-group">
                    <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>

    <?php endif;?>

</div>
