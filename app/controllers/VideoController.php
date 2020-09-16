<?php

namespace app\controllers;

use yii\web\Controller;
use app\services\VideoService;
use yii\data\Pagination;
use yii\data\Sort;

class VideoController extends Controller
{
    private $service;

    public function __construct($id, $module, VideoService $service, $config = [])
    {
        $this->service = $service;
        parent::__construct($id, $module, $config);
    }

    public function actionIndex()
    {
        $sort = new Sort([
            'attributes' => [
                'views' => ['label' => 'Views'],
                'added' => ['label' => 'Date']
            ],
            'defaultOrder' => ['added' => SORT_DESC]
        ]);
        $pages = new Pagination(['totalCount' => $this->service->getCount()]);
        $videos = $this->service->getList($pages, $sort);
        return $this->render('index', [
                    'videos' => $videos,
                    'pages' => $pages,
                    'sort' => $sort,
        ]);
    }

}
