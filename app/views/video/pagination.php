<?php

use yii\widgets\LinkPager;
use yii\helpers\Html;

$allowPerPage = [10, 20, 50];
$perPageLinks = [];
$selected = null;
foreach ($allowPerPage as $perPage) {
    $url = $pages->createUrl(0, $perPage);
    if ($pages->getPageSize() == $perPage) {
        $selected = $url;
    }
    $perPageLinks[$url] = $perPage;
}
?>
<div class="video-pagination">
    <div>
        <?php
        echo LinkPager::widget([
            'firstPageLabel' => '«',
            'prevPageLabel' => '‹',
            'nextPageLabel' => '›',
            'lastPageLabel'  => '»',
            'pagination' => $pages,
        ]);
        ?>
    </div>
    <div>
        Order By:
        <?php
        echo $sort->link('views') . ' | ' . $sort->link('added');
        ?>  
    </div>
</div>
<div class="video-per-page">
    <div>
        Per page:
    </div>
    <div class="col-lg-1">
        <?php
            echo Html::dropDownList('', $selected, $perPageLinks, ['class' => 'form-control', 'onchange' => 'location = this.value;']);
        ?>
    </div>
</div>