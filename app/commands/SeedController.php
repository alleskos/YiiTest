<?php

namespace app\commands;

use yii\console\Controller;
use yii\console\ExitCode;
use app\models\Video;
use Faker\Factory as FakerFaktory;

class SeedController extends Controller
{
    public function actionVideos()
    {
        $faker = FakerFaktory::create();
        $video = new Video();
        for ($i = 0; $i < 1000; $i++) {
            $video->setIsNewRecord(true);
            unset($video->id);
            $video->title = $faker->sentence(3);
            $video->thumbnail = $faker->imageUrl(250, 140, 'cats');
            $video->duration = mt_rand(10, 86400);
            $video->views = mt_rand(0, 1000000);
            $video->added = $faker->dateTimeBetween('-5 years')->format('Y-m-d H:i:s');
            $video->save();
        }
        return ExitCode::OK;
    }

}