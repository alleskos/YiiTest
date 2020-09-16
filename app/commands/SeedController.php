<?php

namespace app\commands;

use yii\console\Controller;
use yii\console\ExitCode;
use app\models\Video;
use Faker\Factory as FakerFaktory;
use yii\db\Query;

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

    public function actionVideosDublicatesFill()
    {
        $query = new Query();
        $query->createCommand()->setRawSql(
                "INSERT INTO
                    videos (title, thumbnail, duration, views, added)
                    (SELECT
                      t1.title as title,
                      t1.thumbnail as thumbnail,
                      FLOOR(RANDOM() * 86400) + 10 as duration,      
                      FLOOR(RANDOM() * 1000000) as views,  
                      ('now'::timestamp - (RANDOM() * 5 * 365) * '1 day'::interval) as added
                    FROM
                      videos AS t1,
                      videos AS t2)"
        )->query();
        $query->createCommand()->setRawSql('VACUUM ANALYZE')->query();
    }

}
