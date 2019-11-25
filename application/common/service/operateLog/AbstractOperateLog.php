<?php

/**
 * @Author: bear
 * @Date:   2019-11-25 13:52:47
 * @Last Modified by:   bear
 * @Last Modified time: 2019-11-25 15:52:42
 */

namespace app\common\service\operateLog;

abstract class AbstractOperateLog
{
	const IS_PC = 1; //PC端操作
    const IS_APP = 2; //APP端操作

    public function createOperateLog($content = '', $param = '')
    {
        $apiUrl = request()->routeInfo()['rule'];
        $name = config('operateLog.route.' . $apiUrl . '.name'); //name识别
        $action = config('operateLog.route.' . $apiUrl . '.action'); //action识别

        //PC、APP识别
        if (explode('/', $apiUrl)[0] == 'manage') {
            $source = self::IS_PC;
        } else {
            $source = self::IS_APP;
        }

        $this->addOperateLog($action, $name, $content, $source, $param);
    }

    //操作日志
    public function addOperateLog($action, $name, $content = '', $source = 0, $param = '')
    {   

        $newData['action'] = !empty($action) ? trim($action) : '';
        $newData['name'] = !empty($name) ? trim($name) : '';
        $newData['content'] = !empty($content) ? trim($content) : '';
        $newData['source'] = $source;

        if (empty($action) || empty($name) || empty($source)) return false;

        //用户信息
        $userInfo = request()->param('userInfo');

        //TODO 角色相关
        // $newData['role_id'] = $userInfo->role_id;
        // $newData['role_name'] = $userInfo->role_name;

        $newData['create_id'] = $userInfo->id;
        $newData['username'] = $userInfo->username;
        $newData['param'] = $param; //入参原始数据

        return model('common/OperateLog')->add($newData);


    }

    
}