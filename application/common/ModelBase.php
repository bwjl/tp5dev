<?php

namespace app\common;

use think\Model;

class ModelBase extends Model
{

    //是否翻页处理
    protected function dataPaginateToArray($data_obj, $isno_page, $limit)
    {
        if ($isno_page === false) {
            if ($limit != 0) {
                $data = $data_obj->limit($limit)->select()->toArray();
            } else {
                $data = $data_obj->select()->toArray();
            }
        } else {
            $page_data = $data_obj->paginate($limit)->toArray();
            $data = [
                'total' => $page_data['total'],
                'limit' => $page_data['per_page'],
                'page' => $page_data['current_page'],
                'list' => $page_data['data'],
            ];
            unset($page_data);
        }

        return $data;
    }
}




