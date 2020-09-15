<?php

namespace app\services;

use app\models\Video;

class SlowVideoService implements VideoService
{
    
    public function getCount()
    {
       return Video::find()->count();
    }

    public function getList($limit, $offset, $order)
    {
        return Video::find()->limit($limit)->offset($offset)->orderBy($order)->all();
    }

}
