<?php
$this->title = 'Videos';
?>
<div class="site-index">
    <h1 class="text-center">Video list</h1>
    <div class="body-content">
        <?php
        echo $this->render('pagination', [
            'pages' => $pages,
            'sort' => $sort
        ]);
        ?>
        <div class="video-list">
            <?php
            foreach ($videos as $video) {
                echo $this->render('item', [
                    'video' => $video
                ]);
            }
            ?>
        </div>
        <?php
        echo $this->render('pagination', [
            'pages' => $pages,
            'sort' => $sort
        ]);
        ?>
    </div>
</div>
