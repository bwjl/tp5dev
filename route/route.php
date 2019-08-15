<?php

$host = [

];

Route::domain($host, function () {
    //首页
    Route::get('/', 'index/index');
});
