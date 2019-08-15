<?php

namespace app\common\service;

use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Config;

class JWT
{
    /**
     * 创建token
     * @param   array $userInfo
     * @return  string $token
     */
    public static function createToken($userInfo)
    {
        $time = time();
        $signer = new Sha256();

        $token = (new Builder())
            ->setIssuer(Config::get('jwt.api_url'))
            ->setId(uniqid(), true)
            ->setIssuedAt($time)
            ->setExpiration($time + Config::get('jwt.expiration_secs'))
            ->set('userInfo', $userInfo)
            ->sign($signer, Config::get('jwt.jwt_sign_value'))
            ->getToken();

        return (string)$token;
    }

    /**
     * token认证
     * @param    string $token
     * @return   array
     */
    public static function verifyToken($token)
    {
        if (empty($token)) {
            return ['msg' => 'token未设置', 'code' => 0];
        }

        $signer = new Sha256();
        try {
            $token = (new Parser())->parse($token);
            $valid = $token->verify($signer, Config::get('jwt.jwt_sign_value'));

        } catch (\Exception $e) {
            return ['msg' => 'token认证失败', 'code' => 0];
        }

        if (!$valid) {
            return ['msg' => 'token认证失败', 'code' => 0];
        }

        $time = time();
        $exp = $token->getClaim('exp');
        if ($time > $exp) {
            return ['msg' => 'token已过期', 'code' => 0];
        }

        return ['data' => $token->getClaim('userInfo'), 'code' => 1];
    }
}

