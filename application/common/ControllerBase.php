<?php

namespace app\common;

use think\Controller;

abstract class ControllerBase extends Controller
{
    // protected $page = PAGER_DEFAULT_NUM;
    // protected $limit = PAGER_DEFAULT_LIMIT;
    // protected $code = 0;

    // public function __construct()
    // {
    //     parent::__construct();
    //     $this->page = input('page', PAGER_DEFAULT_NUM, 'intval');
    //     $this->limit = input('limit', PAGER_DEFAULT_LIMIT, 'intval');
    //     $this->code = input('code', 0, 'intval');
    // }

    // //错误返回
    // public function setError($message = null, $num = '', $others = [])
    // {
    //     $num = strlen($num) == 1 ? '0' . $num : $num;
    //     $code = $this->code . $num;
    //     $data = ['code' => (int)$code, 'message' => $message];
    //     $data['data'] = $others;

    //     return json($data);
    // }

    // //正确返回
    // public function ok($message = '操作成功', $others = [])
    // {
    //     $data = ['code' => OK_CODE, 'message' => $message];
    //     if ($others) {
    //         $data['data'] = $others;
    //     }

    //     return json($data);
    // }


    /**
     * 格式化分页数据
     * @param array $data
     * @return array
     */
    function formatPageData(array $data)
    {

        $data['limit'] = $data['per_page'];
        $data['page'] = $data['current_page'];
        $data['list'] = $data['data'];

        unset($data['per_page'], $data['current_page'], $data['data']);

        return $data;
    }


    
}


