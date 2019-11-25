<?php

/**
 * @Author: bear
 * @Date:   2019-11-25 11:00:12
 * @Last Modified by:   bear
 * @Last Modified time: 2019-11-25 15:56:00
 */

namespace app\common\model;

use app\common\ModelBase;

class OperateLog extends ModelBase
{   

    //@Override
    public function add(array $param)
    {
        
        $param['api_url'] = request()->routeInfo()['rule'];
        $param['client_ip'] = ip2long(request()->ip());
        $param['browser'] = $_SERVER['HTTP_USER_AGENT'];

        $param['create_time'] = time();

        return $this->insertGetId($param);
    }


	// //操作日志
 //    //$source：1-PC端；2-APP端
 //    public function createOperateLog($action, $name, $content = '', $source = 0, $param = '')
 //    {   

 //        $newData['action'] = !empty($action) ? trim($action) : '';
 //        $newData['name'] = !empty($name) ? trim($name) : '';
 //        $newData['content'] = !empty($content) ? trim($content) : '';
 //        $newData['source'] = $source;

 //        if (empty($action) || empty($name) || empty($source))
 //            return false;

 //        //
 //        // $newData['api_url'] = request()->routeInfo()['rule'];
 //        // $newData['client_ip'] = request()->ip();
 //        // $newData['browser'] = $_SERVER['HTTP_USER_AGENT'];

 //        //用户信息
 //        $userInfo = request()->param('userInfo');
 //        //var_dump($userInfo);die;
 //        //TODO 角色相关
 //        // $newData['role_id'] = $userInfo->role_id;
 //        // $newData['role_name'] = $userInfo->role_name;
 //        $newData['create_id'] = $userInfo->id;
 //        $newData['username'] = $userInfo->username;
 //        //$newData['create_time'] = time();
 //        $newData['param'] = $param; //入参原始数据

 //        $result  = $this->insertGetId($newData);

 //        //var_dump($result);die;

 //        return $result;


 //    }
}