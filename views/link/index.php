<?php

use app\models\Link;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Проверка и сокращение URL';
/* @var Link $model */
?>

    <div class="link-form">
        <?php $form = ActiveForm::begin(['id' => 'url-form']); ?>
        <?= $form->field($model, 'url')->textInput(['placeholder' => 'Введите URL'])->label(false) ?>
        <?= Html::submitButton('ОК', ['class' => 'btn btn-primary']) ?>
        <?php ActiveForm::end(); ?>

        <div id="result" style="margin-top:20px;"></div>
    </div>

<?php
$checkUrl = Url::to(['link/check-url']);
$js = <<<JS
$('#url-form').on('beforeSubmit', function(e) {
    e.preventDefault();
    var form = $(this);
    var result = $('#result');
    result.html('Проверяем...');

    $.ajax({
        url: '$checkUrl',
        type: 'POST',
        data: form.serialize(),
        success: function(data) {
            console.log(data);
            if (data.success) {
                result.html('<p>Короткая ссылка: <a href="' + data.shortUrl + '" target="_blank">' + data.shortUrl + '</a></p>' +
                    '<img src="' + data.qrCodeUrl + '" alt="QR код" style="max-width:200px;">');
            } else {
                result.html('<p style="color:red;">Ошибка: ' + data.message + '</p>');
            }
        },
        error: function() {
            result.html('<p style="color:red;">Ошибка сервера</p>');
        }
    });
    return false;
});
JS;
$this->registerJs($js);
?>