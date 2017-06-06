<?php
namespace app\admin\validate;
use think\Validate;
/**
 * Class Music
 * @package app\admin\validate
 * 验证音乐数据模型的类
 * 第一步：继承验证的父类
 */
class Music extends Validate{
	protected $rule=[ //验证规则
		'musicName'=>'require|length:2,10|unique:music',
		//验证表单name传入的歌曲名不能为空，长度为2到10，不重复
		'word'=>'require'
	];
	protected $message=[//错误信息 规则名字.要求 =>'value'
		'musicName.require'=>'歌曲名不能为空',
		'musicName.length' => '歌曲名称必须在2到10个字之间！',
        'musicName.unique' => '歌曲名称不能重复！',
        'word.require' => '歌词不能为空！',
	];
	protected $scene=[
		'edit'=>['musicName'=>'require|length:2,10']
	];
}
?>