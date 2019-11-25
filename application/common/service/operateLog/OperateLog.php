<?php

/**
 * @Author: bear
 * @Date:   2019-11-25 13:55:39
 * @Last Modified by:   bear
 * @Last Modified time: 2019-11-25 16:00:07
 */

namespace app\common\service\operateLog;


class OperateLog extends AbstractOperateLog
{
	//用户登录
	public function userLogin($userInfo)
	{
		$content = '用户登录' . $userInfo['username'];
        $apiUrl = request()->routeInfo()['rule'];
        $insert = [
        	'source' => self::IS_PC,
        	'name' => config('operateLog.route.' . $apiUrl . '.name'),
        	'action' => config('operateLog.route.' . $apiUrl . '.action'),
        	'content' => $content,
        	//'role_id' => 
        	//'role_name' => 
        	'username' => $userInfo['username'],
        	'param' => json_encode(['username' => $userInfo['username']], JSON_UNESCAPED_UNICODE),
        	'create_id' => $userInfo['id'],
        ];

        model('common/OperateLog')->add($insert);
	}


}
