<?php
// 模块编号: 22 APP_v1.0
// code路由层设置，前两位代表模块编号，后两位代表接口编号
/**
 * 【APP_v1.0】
 */

$mod_code = 22;

Route::group('app/v1', function () use ($mod_code) {

})->middleware(['Validate'])->allowCrossDomain();

Route::group('app/v1', function () use ($mod_code) {



})->middleware(['Token', 'Validate'])->allowCrossDomain();