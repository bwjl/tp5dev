<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件

//全局请求成功状态码
defined('OK_CODE') or define('OK_CODE', '100000');
defined('LOGIN_FAIL_CODE')  OR define('LOGIN_FAIL_CODE', '400001'); //token已过期
defined('NO_LOGIN_CODE')  OR define('NO_LOGIN_CODE', '400011'); //未登录

//默认分页参数设置
defined('PAGER_DEFAULT_NUM') or define('PAGER_DEFAULT_NUM', 1);
defined('PAGER_DEFAULT_LIMIT') or define('PAGER_DEFAULT_LIMIT', 10);

if( !function_exists('object_to_array')){
    /**
     * 对象转数组
     * @param $object
     * @return array
     */
    function object_to_array ($object) {
        if(!is_object($object) && !is_array($object)) {
            return $object;
        }
        return array_map('object_to_array', (array) $object);
    }
}

if(! function_exists('curlRequest')){
    /**
     * 远程访问函数
     * @param    string     $url    请求地址
     * @param    array      $data   请求体，提交数据包 post数据(不填则为GET)
     * @param    string     $cookie 提交的$cookies
     * @param    string     $returnCookie 是否返回$cookies
     * @return   mixed
     */
    function curlRequest($url, $post = [], $cookie = '', $returnCookie = 0)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.1; Trident/6.0)');
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($curl, CURLOPT_AUTOREFERER, 1);
        if ($post) {
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($post));
        }
        if ($cookie) {
            curl_setopt($curl, CURLOPT_COOKIE, $cookie);
        }
        curl_setopt($curl, CURLOPT_HEADER, $returnCookie);
        curl_setopt($curl, CURLOPT_TIMEOUT, 10);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false); // 从证书中检查SSL加密算法是否存在
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // 对认证证书来源的检查
        $data = curl_exec($curl);
        if (curl_errno($curl)) {
            return curl_error($curl);
        }
        curl_close($curl);
        if ($returnCookie) {
            list($header, $body) = explode("\r\n\r\n", $data, 2);
            preg_match_all("/Set\-Cookie:([^;]*);/", $header, $matches);
            $info['cookie'] = substr($matches[1][0], 1);
            $info['content'] = $body;
            return $info;
        } else {
            return $data;
        }
    }
}

/**
 *  二维数组根据指定键去重
 */
if (!function_exists('assoc_unique')) {
    function assoc_unique($arr, $key)
    {
        $tmp_arr = array();
        foreach ($arr as $k => $v) {
            if (in_array($v[$key], $tmp_arr)) {//搜索$v[$key]是否在$tmp_arr数组中存在，若存在返回true
                unset($arr[$k]);
            } else {
                $tmp_arr[] = $v[$key];
            }
        }
        sort($arr); //sort函数对数组进行排序
        return $arr;
    }
}


/*
    多级目录树结构 根据节点
	$items      	待处理数组
	$id_name   		对应id字段名
	$pid_name  		父id字段名
    $root           根节点
*/
if (!function_exists('treeList')) {
    function treeList($list, $pk = 'id', $pid = 'pid', $child = '_child', $root = 0)
    {
        $tree = array();
        $packData = array();
        foreach ($list as $data) {
            $packData[$data[$pk]] = $data;
        }

        foreach ($packData as $key => $val) {
            if ($val[$pid] == $root) {//代表根节点
                $tree[] =& $packData[$key];
            } else {
                //找到其父类
                $packData[$val[$pid]][$child][] = &$packData[$key];
            }
        }

        return $tree;
    }
}


/**
 * 对用户的密码进行加密
 * @param  string $password 密码
 * @param $salt     加密salt
 * @return string password
 */
if (!function_exists('password')) {
    function password($password, $salt)
    {
        $encrypt = md5(md5(trim($password) . $salt));
        return $encrypt;
    }
}

/**
 * 对用户的密码与原密码进行比较
 * @param $password 密码
 * @param $salt     加密salt
 * @param $new_pass 新密码
 * @return boolean
 */
if (!function_exists('password_compare')) {
    function password_compare($password, $salt, $new_pass)
    {
        $encrypt = md5(md5(trim($new_pass) . $salt));
        return $encrypt === $password ? true : false;
    }
}
