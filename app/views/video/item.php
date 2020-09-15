<?php

use yii\helpers\Html;

$formatter = \Yii::$app->formatter;
?>
<div class="item">
    <div class="img-wrap">
        <?= Html::img($video->thumbnail, ['alt' => $video->title]); ?>
        <div class="duration"><?= $formatter->asVideoDuration($video->duration); ?></div>
    </div>
    <div class="title" title="<?= $video->title; ?>"><?= $video->title; ?></div>
    <div class="views">Views: <?= $formatter->asInteger($video->views); ?></div>
    <div class="added">Added: <?= $formatter->asDatetime($video->added, 'dd.MM.yyyy HH:mm:ss'); ?></div>
</div>