<?php

namespace app\manage\controller\business;

use app\manage\controller\Base;
use app\manage\model\Business as businessModel;

/**
 * 商户控制器
 */
class Business extends Base
{

    /**
     * 列表
     */
    public function lists()
    {

        return $this->setError('获取失败', 1);

        $data = [];
        return $this->ok('获取成功', $data);
    }

}