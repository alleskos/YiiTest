<?php

namespace app\config\bootstrap;

use yii\base\BootstrapInterface;

class VideoBootstrap implements BootstrapInterface
{

    public function bootstrap($app)
    {
        $container = \Yii::$container;
        $container->setSingleton('app\services\VideoService', [
            'class' => 'app\services\SlowVideoService'
        ]);
    }

}
