<?php
namespace app\admin\validate;
use think\Validate;
/**
 * Class Singer
 * @package app\admin\validate
 * 验证音乐数据模型的类
 * 第一步：继承验证的父类
 */
class Singer extends Validate{
	protected $rule=[ //验证规则
		'singerName'=>'require|unique:singer',
		//|length:2,10|unique:singer
		//验证表单name传入的歌手名不能为空，长度为2到10，不重复
	];
	protected $message=[//错误信息 规则名字.要求 =>'value'
		'singerName.require'=>'歌手名不能为空',
		// 'singerName.length' => '歌手名称必须在2到10个字之间！',
         'singerName.unique' => '歌手名称不能重复！',
	];
	protected $scene=[
		'edit'=>['singerName'=>'require|length:2,10']
	];
}
?>