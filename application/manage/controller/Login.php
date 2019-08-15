<?php

namespace app\manage\controller;

use app\common\service\JWT;
use app\manage\model\User as userModel;

class Login extends Base
{

    /**
     * 登录接口
     * @return \think\response\Json
     */
    public function doLogin()
    {
        $username = input('post.username', '', 'trim');
        $password = input('post.password', '', 'trim');

        //查询用户信息
        $userModel = new userModel();
        $userInfo = $userModel->getUserByUsername($username);

        //当前账号不存在
        if (empty($userInfo))
            return $this->setError('当前账号不存在', 1);

        //当前账号是否禁用 状态（1-启用;2-禁用）
        if ($userInfo['status'] != 1)
            return $this->setError('当前账号已禁用', 2);

        //密码错误
        if (password_compare($userInfo['password'], $userInfo['salt'], $password) !== TRUE)
            return $this->setError('密码错误', 3);

        //------------登录成功--------------

        //TODO::添加登录日志

        //创建Token
        unset($userInfo['password']);
        unset($userInfo['salt']);
        $returnData = $userInfo;

        $tokenService = new JWT();
        $token = $tokenService->createToken($returnData);
        $returnData['token'] = $token;

        return $this->ok('登录成功', $returnData);
    }

}
