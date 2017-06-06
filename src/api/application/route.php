<?php
use think\Route;  //使用think底层的路由类

Route::get('/',function(){
    return 'Hello,world!';
});

// 如果是list，返回 list
Route::get('/list',function(){
    return 'list!';
});

//Route::resource('cartnoon','index/Cartnoon');   //资源路由


// 所有的api接口都需要在此文件,route.php定义指定的资源路由

// api的特点之一：  我们真正的逻辑文件名称可以不暴漏出去，     路由进行简单的名称，就像一个人的笔名
Route::resource('manhua','index/Cartview');
Route::resource('xltm','index/Cartview');
Route::resource('index','vuePC/Index');
// Route::resource('singerpc','vuePC/Singerpc');


// 接口：是给到你合作的项目公司去提供数据
