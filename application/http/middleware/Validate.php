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
                $params = array_merge($request->param(), $request->file());
            else
                $params = $request->param();

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
