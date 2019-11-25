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
defined('OK_CODE') or define('OK_CODE', 100000);
defined('LOGIN_FAIL_CODE') OR define('LOGIN_FAIL_CODE', 400001); //token已过期
defined('NO_LOGIN_CODE') OR define('NO_LOGIN_CODE', 400002); //未登录
defined('AUTH_FAIL_CODE') OR define('AUTH_FAIL_CODE', 400011); //无权限操作

defined('CODE_100000') or define('SUCCESS', [100000, 'success']);
defined('CODE_400000') or define('FAIL', [400000, 'error']);
defined('CODE_500000') or define('CODE_500000', [500000, '服务器忙，请刷新后重新尝试']);
defined('CODE_500001') or define('CODE_500001', [500001, '系统异常']);
defined('CODE_500002') or define('CODE_500002', [500002, '系统异常[http]']);
defined('CODE_500003') or define('CODE_500003', [500003, '系统异常[pdo]']);
defined('CODE_500004') or define('CODE_500004', [500004, '系统异常[throwable]']);
defined('CODE_500005') or define('CODE_500005', [500005, '系统异常[error]']);

defined('CODE_0') or define('CODE_0', 0);
defined('CODE_1') or define('CODE_1', 1);


//默认分页参数设置
defined('PAGER_DEFAULT_NUM') or define('PAGER_DEFAULT_NUM', 1);
defined('PAGER_DEFAULT_LIMIT') or define('PAGER_DEFAULT_LIMIT', 10);
defined('PAGER_MAX_LIMIT') or define('PAGER_MAX_LIMIT', 50); //每页最大显示数量

//数据库数据删除字段标识
defined('DB_ISDELETE_NO') or define('DB_ISDELETE_NO', 0); //未删除
defined('DB_ISDELETE_IS') or define('DB_ISDELETE_IS', 1); //已删除

//启用禁用 enable disabled
defined('ENABLE') or define('ENABLE', 1); //启用
defined('DISABLED') or define('DISABLED', 2); //禁用

//烟草用户管辖级别
defined('DISTRICT_LEVEL_1') or define('DISTRICT_LEVEL_1', 1); //省
defined('DISTRICT_LEVEL_2') or define('DISTRICT_LEVEL_2', 2); //市
defined('DISTRICT_LEVEL_3') or define('DISTRICT_LEVEL_3', 3); //区
defined('DISTRICT_LEVEL_4') or define('DISTRICT_LEVEL_4', 4); //街道

//banner数据级别
defined('BANNER_LEVEL_1') or define('BANNER_LEVEL_1', 1); //超管
defined('BANNER_LEVEL_2') or define('BANNER_LEVEL_2', 1); //子管理员
defined('BANNER_LEVEL_3') or define('BANNER_LEVEL_3', 3); //市级
defined('BANNER_LEVEL_4') or define('BANNER_LEVEL_4', 4); //区级
defined('BANNER_LEVEL_5') or define('BANNER_LEVEL_5', 5); //街道

//超级管理、子管理
defined('SUPER_ADMIN') or define('SUPER_ADMIN', 1);
defined('SUB_ADMIN') or define('SUB_ADMIN', 2);
defined('YC_BUSINESS') or define('YC_BUSINESS', 6);

//客户经理角色
defined('MANAGER_ROLE') or define('MANAGER_ROLE', 6);

defined('GOODS_TYPE') or define('GOODS_TYPE', 1); //烟草类型
defined('NON_GOODS_TYPE') or define('NON_GOODS_TYPE', 2); //非烟类型

defined('IS_SYSTEM_YES') or define('IS_SYSTEM_YES', 1); //是系统字段
defined('IS_SYSTEM_NO') or define('IS_SYSTEM_NO', 0); //不是系统字段

defined('IS_REQUIRED_YES') or define('IS_REQUIRED_YES', 1); //必填
defined('IS_REQUIRED_NO') or define('IS_REQUIRED_NO', 2); //选填

defined('ATTR_INFO_TYPE_1') or define('ATTR_INFO_TYPE_1', 1); //attr_info_type = 1
defined('ATTR_INFO_TYPE_2') or define('ATTR_INFO_TYPE_2', 2); //attr_info_type = 2
defined('ATTR_INFO_TYPE_3') or define('ATTR_INFO_TYPE_3', 3); //attr_info_type = 3

defined('PC_PLATFORM') or define('PC_PLATFORM', 1);
defined('APP_PLATFORM') or define('APP_PLATFORM', 2);

defined('MAX_IMPORT_EXCEL_ROWS') or define('MAX_IMPORT_EXCEL_ROWS', 1000); //最大excel导入条数
defined('MAX_EXPORT_EXCEL_ROWS') or define('MAX_EXPORT_EXCEL_ROWS', 1000); //最大excel导出条数

/**
 * 实例化service对象
 * @param string $fileName 类名或标识
 * @param string $module //应用模块名
 * @param array $args 构造参数
 * @param bool $newInstance 是否每次创建新的实例
 * @return mixed
 */
if (!function_exists('instantial_service')) {
    function instantial_service($fileName, $module = '', $args = [], $newInstance = false)
    {
        $module = (empty($module)) ? \think\facade\Request::module() : $module;//应用模块名
        $class = 'app\\' . $module . '\service\\' . str_replace('/', '\\', $fileName);
        return \think\Container::get($class, $args, $newInstance);
    }
}


if (!function_exists('model')) {
    /**
     * 实例化Model
     * @param string $name Model名称
     * @param string $layer 业务层名称
     * @param bool $appendSuffix 是否添加类名后缀
     * @return \think\Model
     */
    function model($name = '', $layer = 'model', $appendSuffix = false)
    {
        $module = \think\facade\Config::get('app.default_module');
        return app()->model($name, $layer, $appendSuffix, $module);
    }
}


if (!function_exists('get_web_url')) {

    /**
     * 获取当前服务主域名网址，后缀不带
     * 支持http https eg: http://www.yancao.com:8888
     *
     */
    function get_web_url()
    {
        $proto = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) ? 'https://' : 'http://';

        return $proto . $_SERVER['HTTP_HOST'];
    }

}


if (!function_exists('time_to_date')) {
    /**
     * 时间戳转日期
     * @param string $time 时间戳
     * @return string
     */
    function time_to_date($time)
    {
        return date('Y-m-d H:i:s', $time);
    }
}


if (!function_exists('service')) {
    /**
     * 实例化service
     * @param string $name service名称
     * @param string $layer 业务层名称
     * @param bool $appendSuffix 是否添加类名后缀
     * @return \think\Model
     */
    function service($name = '', $layer = 'service', $appendSuffix = false)
    {

        $module = \think\facade\Config::get('app.default_module');
        return app()->model($name, $layer, $appendSuffix, $module);
    }
}

/**
 * 获取用户信息
 * @param string $key 键名
 * @return mixed
 */
if (!function_exists('get_userinfo')) {
    function get_userinfo($key = '')
    {
        $userInfo = json_decode(json_encode(\think\facade\Request::param()['userInfo']), true);
        if (!$key) {
            return $userInfo;
        }
        if (!isset($userInfo[$key])) {
            return [];
        }
        return $userInfo[$key];
    }
}


/**
 * 实例化validate对象
 * @param string $fileName 类名或标识
 * @param string $module //应用模块名
 * @param array $args 构造参数
 * @param bool $newInstance 是否每次创建新的实例
 * @return mixed
 */
if (!function_exists('instantial_validate')) {
    function instantial_validate($fileName, $module = '', $args = [], $newInstance = false)
    {
        $module = (empty($module)) ? \think\facade\Request::module() : $module;//应用模块名
        $class = 'app\\' . $module . '\validate\\' . str_replace('/', '\\', $fileName);//应用独立存在相关类
        return \think\Container::get($class, $args, $newInstance);
    }
}


/**
 * 判断是否为json格式
 * @param string $data
 * @param bool $assoc
 * @return bool
 */
if (!function_exists('is_json')) {
    //
    function is_json($data = '', $assoc = false)
    {
        $data = json_decode($data, $assoc);
        if (($data && (is_object($data))) || (is_array($data) && !empty($data))) {
            return true;
        }
        return false;
    }

}


/**
 * 接口返回数据
 * @param string|numeric|constant $codeData code码
 * @param string $msg 描述语
 * @param array $data 返回数据
 * @return mixed
 */
if (!function_exists('api_result')) {
    function api_result($codeData = CODE_100000, $msg = '', $data = [])
    {
        //如果是设置的code 常量数组
        if (!is_array($codeData)) throw new Exception('code 状态不存在');
        $code = $codeData[0];
        if (is_array($msg)) {
            $msg = explode('\r\n', $msg);
        } else {
            $msg = empty($msg) ? $codeData[1] : $msg;
        }
        return json(['code' => $code, 'message' => $msg, 'data' => $data]);
    }
}

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


/**
 * 随机字符
 * @param number $length 长度
 * @param string $type 类型
 * @param number $convert 转换大小写
 * @return string
 */
if (!function_exists('random')) {
    function random($length = 6, $type = 'string', $convert = 0)
    {
        $config = array(
            'number' => '1234567890',
            'letter' => 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',
            'string' => 'abcdefghjkmnpqrstuvwxyz23456789',
            'all' => 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890'
        );

        if (!isset($config[$type])) $type = 'string';
        $string = $config[$type];

        $code = '';
        $strlen = strlen($string) - 1;
        for ($i = 0; $i < $length; $i++) {
            $code .= $string{mt_rand(0, $strlen)};
        }
        if (!empty($convert)) {
            $code = ($convert > 0) ? strtoupper($code) : strtolower($code);
        }
        return $code;
    }
}

/**
 *
 */
if (!function_exists('returnData')) {
    function returnData($code = 0, $msg = '', $data = [], $isJson = false)
    {
        $dataArr['code'] = $code;
        $dataArr['message'] = $msg;
        if (!empty($data)) $dataArr['data'] = $data;

        if ($isJson === true) {
            return json_encode($dataArr);
        }
        return $dataArr;
    }
}

/**
 * 获取汉字首字母函数
 */
if (!function_exists('getFirstCharter')) {
    function getFirstCharter($str)
    {
        if (empty($str)) {
            return '';
        }

        $fchar = ord($str{0});

        if ($fchar >= ord('A') && $fchar <= ord('z'))
            return strtoupper($str{0});

        $s1 = iconv('UTF-8', 'gb2312', $str);

        $s2 = iconv('gb2312', 'UTF-8', $s1);

        $s = $s2 == $str ? $s1 : $str;

        $asc = ord($s{0}) * 256 + ord($s{1}) - 65536;

        if ($asc >= -20319 && $asc <= -20284)
            return 'A';

        if ($asc >= -20283 && $asc <= -19776)
            return 'B';

        if ($asc >= -19775 && $asc <= -19219)
            return 'C';

        if ($asc >= -19218 && $asc <= -18711)
            return 'D';

        if ($asc >= -18710 && $asc <= -18527)
            return 'E';

        if ($asc >= -18526 && $asc <= -18240)
            return 'F';

        if ($asc >= -18239 && $asc <= -17923)
            return 'G';

        if ($asc >= -17922 && $asc <= -17418)
            return 'H';

        if ($asc >= -17417 && $asc <= -16475)
            return 'J';

        if ($asc >= -16474 && $asc <= -16213)
            return 'K';

        if ($asc >= -16212 && $asc <= -15641)
            return 'L';

        if ($asc >= -15640 && $asc <= -15166)
            return 'M';

        if ($asc >= -15165 && $asc <= -14923)
            return 'N';

        if ($asc >= -14922 && $asc <= -14915)
            return 'O';

        if ($asc >= -14914 && $asc <= -14631)
            return 'P';

        if ($asc >= -14630 && $asc <= -14150)
            return 'Q';

        if ($asc >= -14149 && $asc <= -14091)
            return 'R';

        if ($asc >= -14090 && $asc <= -13319)
            return 'S';

        if ($asc >= -13318 && $asc <= -12839)
            return 'T';

        if ($asc >= -12838 && $asc <= -12557)
            return 'W';

        if ($asc >= -12556 && $asc <= -11848)
            return 'X';

        if ($asc >= -11847 && $asc <= -11056)
            return 'Y';

        if ($asc >= -11055 && $asc <= -10247)
            return 'Z';

        return null;

    }
}
if (!function_exists('send_sms')) {
    /**
     * 发送短信
     * @param $phone 手机号
     * @param $template_id 模板id
     * @param $params 参数数组
     * @return bool 返回值
     */
    function send_sms($phone, $template_id, $params)
    {
        try {
            $sender = new \Qcloud\Sms\SmsSingleSender(config('sms.sdk_app_id'), config('sms.app_key'));


            $code = regCountryCode($phone);
            if ($code == '86') {
                $template_id = config('sms.domestic_template_id');
                $sign = config('sms.domestic_sign');
            } else {
                $template_id = config('sms.international_template_id');
                $sign = config('sms.international_sign');
            }

            $result = $sender->sendWithParam($code, $phone, $template_id, $params, $sign, '', '');
            $rsp = json_decode($result, true);
            if ($rsp['errmsg'] === 'OK') {
                return true;
            } else {
                log('code_' . $result);
                return false;
            }
        } catch (\Exception $e) {
            return false;
        }
    }
}

if (!function_exists('regCountryCode')) {
    function regCountryCode($phone)
    {
        $code = '86';
        if (preg_match('/^([6|9])\d{7}$/', $phone)) {
            return '852'; //香港
        }

        if (preg_match('/^[6]([8|6])\d{5}$/', $phone)) {
            return '853'; //澳门
        }

        if (preg_match('/^09\d{8}$/', $phone)) {
            return '886'; //台湾
        }

        if (preg_match('/^([9|8])\d{7}$/', $phone)) {
            return '65'; //新加坡
        }

        return $code;
    }
}

/**
 * 校验短信验证码
 * @param  string $tel 手机号
 * @return string $code  短信验证码
 */
if (!function_exists('check_sms_code')) {
    function check_sms_code($phone, $code)
    {
        $c = cache('yc_code_'. $phone);
        if (empty($c) || $c != $code) {
            return false;
        }
        return true;
    }
}

/**
 * 判断二维数组中是否含有某个值
 */
if (!function_exists('deep_in_array')) {
    function deep_in_array($value, $array)
    {
        foreach ($array as $item) {
            if (!is_array($item)) {
                if ($item == $value) {
                    return true;
                } else {
                    continue;
                }
            }
            if (in_array($value, $item)) {
                return true;
            } else if (deep_in_array($value, $item)) {
                return true;
            }
        }
        return false;
    }
}

/**
 *  获取用户所属地区（用于展示列表-所属区域字段）
 */
if (!function_exists('getDistrictStr')) {
    function getDistrictStr($district_type, $district_name, $group_id)
    {
        $str = '';
        if ($group_id == SUPER_ADMIN) {
            $str = '全国';
        } else {
            $typeArr = explode(',', $district_type);

            $type_1 = $type_2 = $type_3 = $type_4 = 0;
            foreach ($typeArr as $val) {
                if ($val == 1) $type_1++;
                if ($val == 2) $type_2++;
                if ($val == 3) $type_3++;
                if ($val == 4) $type_4++;
            }
            if (max([$type_1, $type_2, $type_3, $type_4]) > 1) {
                if ($type_1) $str .= $type_1 . '省';
                if ($type_2) $str .= '/' . $type_2 . '市';
                if ($type_3) $str .= '/' . $type_3 . '区';
                if ($type_4) $str .= '/' . $type_4 . '街道';
            } else {
                $str = str_replace(',', '-', $district_name);
            }
        }
        return $str;
    }
}

/**
 *  获取用户所属地区（用于数据权限，查看下级数据）
 */
if (!function_exists('getUserDistrictIdArray')) {
    function getUserDistrictIdArray()
    {
        $groupId = get_userinfo('group_id');
        if ($groupId == SUPER_ADMIN) return [];

        $district = get_userinfo('district');

        $array = [];
        foreach ($district as $key => $item) {
            $item = array_unique(array_filter($item));
            $array[] = join(',', $item);
        }

        return $array;
    }
}

/**
 *  获取*号（用于隐藏字段值）
 */
if (!function_exists('get_asterisk')) {
    function get_asterisk()
    {
        return '******';
    }
}

