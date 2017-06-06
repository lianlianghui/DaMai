<?php
namespace app\admin\controller;

class Index extends \think\Controller
{
    public function index()
    {
    	//return view();
    	// 必须要继承 底层Controller类 class Index extends \think\Controller
    	$this->assign('sayhi','hello world');
    	return $this->fetch();
    }
}
