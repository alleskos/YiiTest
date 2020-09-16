<?php

namespace app\services;

use app\models\Video;
use yii\data\Pagination;
use yii\data\Sort;

class SlowVideoService implements VideoService
{

    public function getCount()
    {
        return Video::find()->count();
    }

    public function getList(Pagination $pagination, Sort $sort)
    {
        return Video::find()->limit($pagination->limit)->offset($pagination->offset)->orderBy($sort->orders)->all();
    }

}
