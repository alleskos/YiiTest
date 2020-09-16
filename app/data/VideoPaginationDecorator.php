<?php

namespace app\data;

use Yii;
use yii\data\Pagination;
use yii\web\Request;

class VideoPaginationDecorator
{
    private $pagination;

    public function __construct(Pagination $pagination)
    {
        $this->pagination = $pagination;
        $request = Yii::$app->getRequest();
        $this->pagination->params = $request instanceof Request ? $request->getQueryParams() : [];
    }

    public function setLastId($id)
    {
        $this->pagination->params['last-id'] = $id;
    }

    public function getLastId()
    {
        return isset($this->pagination->params['last-id']) ? ((int) $this->pagination->params['last-id']) : null;
    }

    public function setLastPage($page)
    {
        $this->pagination->params['last-page'] = $page;
    }

    public function getLastPage()
    {
        return isset($this->pagination->params['last-page']) ? ((int) $this->pagination->params['last-page']) : null;
    }

    public function setLastDate($sqlDate)
    {
        $this->pagination->params['last-date'] = strtotime($sqlDate);
    }

    public function getLastDate()
    {
        if (isset($this->pagination->params['last-date'])) {
            $timestamp = (int) $this->pagination->params['last-date'];
            return date('Y-m-d H:i:s', $timestamp);
        }
        return null;
    }

    public function setLastViews($count)
    {
        $this->pagination->params['last-views'] = $count;
    }

    public function getLastViews()
    {
        return isset($this->pagination->params['last-views']) ? ((int) $this->pagination->params['last-views']) : null;
    }

}
