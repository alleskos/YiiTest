<?php

namespace app\services;

use app\models\Video;
use yii\data\Pagination;
use yii\data\Sort;
use app\data\VideoPaginationDecorator;
use yii\db\Query;
use yii\db\Expression;

class FastVideoService implements VideoService
{

    public function getCount()
    {
        $query = new Query();
        return $query->select(new Expression('reltuples::BIGINT'))
                        ->from('pg_class')
                        ->where(['relname' => 'videos'])
                        ->createCommand()
                        ->queryScalar();
    }

    public function getList(Pagination $pagination, Sort $sort)
    {
        $videoPagination = new VideoPaginationDecorator($pagination);
        $currentPage = $pagination->getPage();
        $reverseOrder = false;
        $offset = 0;
        $query = Video::find();
        if ($currentPage <= 0) {
            $currentPage = 0;
        } elseif ($currentPage < $pagination->getPageCount() - 1) {
            $pageOffset = $currentPage - $videoPagination->getLastPage();
            if (!$this->allowSearch($pageOffset, $videoPagination)) {
                $currentPage = 0;
            } else {
                $offset = $this->findQueryOffset($pageOffset, $pagination->limit, $reverseOrder);
                $this->buildWhereConditions($sort->getOrders(), $query, $videoPagination, $reverseOrder);
            }
        } else {
            $currentPage = $pagination->getPageCount() - 1;
            $reverseOrder = true;
        }
        $pagination->setPage($currentPage);
        $list = $query
                ->limit($pagination->limit)
                ->offset($offset)
                ->orderBy($this->buildSortOrder($sort, $reverseOrder))
                ->all();
        if (!empty($list)) {
            if ($reverseOrder) {
                $list = array_reverse($list);
            }
            $this->saveLastItemData(end($list), $videoPagination);
            $videoPagination->setLastPage($currentPage);
        }
        return $list;
    }

    private function buildWhereConditions($orders, $query, VideoPaginationDecorator $videoPagination, $reverseOrder)
    {
        foreach ($orders as $key => $order) {
            if ($key == 'added') {
                $value = $videoPagination->getLastDate();
            } elseif ($key == 'views') {
                $value = $videoPagination->getLastViews();
            } else {
                break;
            }
            $query->where([$this->getSignByOrder($order, $reverseOrder), $key, $value]);
            $query->orWhere([
                'AND',
                [$key => $value],
                [$this->getSignByOrder($order, $reverseOrder) . '=', 'id', $videoPagination->getLastId()]
            ]);
            return;
        }
        $query->where([$this->getSignByOrder(SORT_ASC, $reverseOrder) . '=', 'id', $videoPagination->getLastId()]);
    }

    private function findQueryOffset($pageOffset, $limit, &$reverseOrder)
    {
        if ($pageOffset == 0) {
            $reverseOrder = true;
            return 0;
        } elseif ($pageOffset > 0) {
            return ($pageOffset - 1) * $limit + 1;
        } else {
            $reverseOrder = true;
            return -$pageOffset * $limit;
        }
    }

    private function saveLastItemData($lastItem, VideoPaginationDecorator $videoPagination)
    {
        $videoPagination->setLastId($lastItem->id);
        $videoPagination->setLastDate($lastItem->added);
        $videoPagination->setLastViews($lastItem->views);
    }

    private function getSignByOrder($order, $reverseOrder)
    {
        $checkedSort = $reverseOrder ? SORT_DESC : SORT_ASC;
        return ($order == $checkedSort) ? '>' : '<';
    }

    private function allowSearch($pageOffset, VideoPaginationDecorator $videoPagination)
    {
        return abs($pageOffset) < 10 
                && !is_null($videoPagination->getLastId()) 
                && !is_null($videoPagination->getLastDate()) 
                && !is_null($videoPagination->getLastViews());
    }

    private function buildSortOrder(Sort $sort, $reverse = false)
    {
        $orders = $sort->getOrders();
        if ($reverse) {
            foreach ($orders as $key => $order) {
                $orders[$key] = ($order == SORT_ASC) ? SORT_DESC : SORT_ASC;
            }
        }
        foreach ($orders as $key => $order) {
            if ($key == 'added' || $key == 'views') {
                $orders['id'] = $order;
                return $orders;
            }
        }
        $orders['id'] = $reverse ? SORT_DESC : SORT_ASC;
        return $orders;
    }

}
