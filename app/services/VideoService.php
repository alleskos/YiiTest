<?php

namespace app\services;

interface VideoService
{

    public function getCount();

    public function getList($limit, $offset, $order);
    
}
