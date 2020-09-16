<?php

namespace app\services;

use yii\data\Pagination;
use yii\data\Sort;

interface VideoService
{

    public function getCount();

    public function getList(Pagination $pagination, Sort $sort);
}
