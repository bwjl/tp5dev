<?php
// 模块编号: 21 管理后台
// code路由层设置，前两位代表模块编号，后两位代表接口编号
/**
 * 【管理后台】
 */

$mod_code = 21;

Route::group('manage', function () use ($mod_code) {
    //登录
    Route::post('/login', 'manage/Login/login')->append(['code' => $mod_code . '1']);

})->middleware(['Validate'])->allowCrossDomain();


Route::group('manage', function () use ($mod_code) {

    Route::get('/menu', 'manage/user.AuthMenu/lists')->append(['code' => $mod_code . '20']);
    Route::get('/role/lists', 'manage/user.Role/lists')->append(['code' => $mod_code . '20']);

    //商户
    Route::get('/business/lists', 'manage/business.Business/lists')->append(['code' => $mod_code . '20']);

})->middleware(['Token', 'Validate'])->allowCrossDomain();
