<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use common\models\UserFile;

$this->title = 'Кабинет пользователя';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="site-contact">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php 
        echo UserFile::hasCurrentUserNameInSession() 
        ? 
        "Добрый день," . UserFile::getCurrentUserNameFromSession() . "!"
        :
        "Добрый день!"
        ?>
    </p>

    </div>

</div>
