<?php

namespace app\http\middleware;

/**
 * 全局控制器参数验证中间件
 * Class Validate
 * @package app\http\middleware
 */
class Validate
{
    public function handle($request, \Closure $next)
    {
        //客户端分页显示数量最大限制
        if (input('limit') > PAGER_MAX_LIMIT) {
            return api_result(CODE_400000, '分页最大显示数量不能超过' . PAGER_MAX_LIMIT);
        }

        //验证场景
        $module = $request->module();
        $controller = $request->controller();
        $action = $request->action();

        //兼容二级控制器
        $controller_dir = $this->compatSecondController($controller);

        if (class_exists('app\\' . $module . '\\validate\\' . $controller_dir)) {

            $validate = validate($controller);
            $isset = method_exists($validate, 'scene' . ucfirst($action));

            //兼容文件上传参数
            if (!empty($request->file()) && is_array($request->file()))
                $params = array_merge(input(strtolower($_SERVER['REQUEST_METHOD'] . '.')), $request->file());
            else
                $params = input(strtolower($_SERVER['REQUEST_METHOD'] . '.'));

            if ($isset && !$validate->scene($action)->check($params)) {
                $code = $request->param('code') . '00';
                return json(['code' => (int)$code, 'message' => $validate->getError()]);
            }
        }

        return $next($request);
    }

    //兼容二级控制器
    public function compatSecondController($controller)
    {
        $controller_dir = $controller;
        if (strpos($controller, '.') !== false) {
            $controller_dir = str_replace('.', '\\', lcfirst($controller));
        }
        return $controller_dir;
    }
}
