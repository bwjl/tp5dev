<?php
/**
 * 登录认证
 */
namespace app\http\middleware;

use think\Request;
use app\common\service\JWT as tokenServ;

class Token
{
    public function handle(Request $request, \Closure $next)
    {
        $code = LOGIN_FAIL_CODE;
        $token = $request->header('Authorization');
        if (empty($token)) {
            return json(['code' => NO_LOGIN_CODE, 'message' => 'token未设置']);
        }

        $servTokenObj = new tokenServ();
        try {
            $result = $servTokenObj->verifyToken($token, config('jwt.jwt_sign_value'));
            if ($result['code'] == 0) {
                return json(['code' => (int) $code, 'message' => $result['msg']]);
            }
            $request->userInfo = $result['data'];
        } catch (\Exception $e) {
            return json(['code' => (int) $code, 'message' => $e->getMessage()]);
        }

        return $next($request);
    }
}





