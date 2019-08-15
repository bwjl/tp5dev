<?php

namespace app\manage\validate\business;

use think\Validate;

// 验证规则
// 1.验证器的命名要跟控制器名一样
// 2.一个验证方法对应一个控制器里面的方法，且名字必须一致
// 3.无需验证的可以不用创建验证方法，默认会过滤掉
// 4.所有验证方法必须以 scene开头，然后拼接控制器的方法名

class Business extends Validate
{
    protected $rule = [
        'id' => 'require|integer',
        'name' => 'require',
    ];

    protected $message = [
        'id.require' => '版本ID不能为空',
        'id.integer' => '版本ID格式不正确',
    ];

    //列表
    public function sceneLists()
    {

    }

    //创建
    public function sceneCreate()
    {

    }

    //更新
    public function sceneUpdate()
    {

    }

    //删除
    public function sceneDelete()
    {
        return $this->only(['id']);
    }

    //详情
    public function sceneDetail()
    {
        return $this->only(['id']);
    }
}