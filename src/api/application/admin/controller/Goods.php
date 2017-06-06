<?php
namespace app\admin\controller;

class Goods extends \think\Controller
{
	function index(){
		$searchArr=[];
		if(input('keyword')){
			$searchArr['m.goodsName']=['like','%'.input('keyword').'%'];
		}
		if(input('cateID')){
			$searchArr['s.cateID']=['=',input('cateID')];
		}
		$goodsList=db('goods')
		->alias('m')
		->field('goodsID,goodsName,introduce,cateName')
		->join('cate s','m.cateID=s.cateID')
		->where($searchArr)
		->paginate(10);
		//print_r($goodsList);exit();
		//歌手的数据
        $cateList = db('cate')->select();
        $this->assign('cateList',$cateList);
		$this->assign('goodsList',$goodsList);
		return $this->fetch();
	}
	function add(){
		//歌手的数据
        $cateList = db('cate')->select();
        $this->assign('cateList',$cateList);
        return $this->fetch();
	}
	function save(){
		//1.第一步：把表单传过来的数据放到一个数组里
		//echo $_GET['goodsName'];exit();
		$saveData=array(
          'goodsName'=>input('goodsName'),//用框架自带的方法获取表单传过来的数据
          'typeID'=>'',
          'cateID'=>input('cateID'),
          'goodsImg'=>'',
          'word'=>input('word'),
          'mp3Src'=>''
        );
        //使用验证规则
        $goods=validate("goods");
        if($goods->check($saveData)){//调用check方法，不合规则返回false

        	//上传文件
        	$file=request()->file('mp3Src');//获取表单传过来的文件
        	$mp3Src='';
        	if(!empty($file)){//上传文件不为空
        		$mp3Src=$file->move(ROOT_PATH .'public'.DS.'uploads');//保存到根目录的public下
	        	if($mp3Src){//判断文件是否上传成功
					//文件入口
	                $saveData['mp3Src'] = DS.'public'.DS.'uploads'.DS.$mp3Src->getSaveName();
	            }else{
	            	$this->error($mp3Src -> getError());
	            }
        	}
        	//2.插入数据库表中
					db('goods')->insert($saveData);
					//跳转页面
					//如果没有传第二个参数（url地址），默认跳回保存之前的界面
					//$this->success('添加成功！',url('goods/index'));
			        $this->success('添加成功！','index');
        	
        }else{
            $this->error($goods->getError());//验证显示错误信息
        }
		
	}//save end
	function delete($id){
		db('goods')->where("goodsID='$id'")->delete();
		$this->success('删除成功！','index');
		// echo  $id;
	}
	function edit($id){
		$goodsList=db('goods')->where("goodsID='$id'")->select();
		$this->assign('goodsList',$goodsList);
		//print_r($goodsList);
		//歌手的数据
        $cateList = db('cate')->select();
        $this->assign('cateList',$cateList);
		return $this->fetch();
		// return view();
	}
	function update(){
		//1.第一步：把表单传过来的数据放到一个数组里
		//echo $_GET['goodsName'];exit();
		$saveData=array(
          'goodsName'=>input('goodsName'),//用框架自带的方法获取表单传过来的数据
          'typeID'=>'',
          'cateID'=>input('cateID'),
          'goodsImg'=>'',
          'word'=>input('word')
        );
        //使用验证规则
        $goods=validate("goods");
        if($goods->scene('edit')->check($saveData)){//调用check方法，不合规则返回false

        	//上传文件
        	$file=request()->file('mp3Src');//获取表单传过来的文件
        	if($file){
        		$mp3Src=$file->move(ROOT_PATH .'public'.DS.'uploads');//保存到根目录的public下
	        	if($mp3Src){//判断文件是否上传成功
					//文件入口
	                $saveData['mp3Src'] = DS.'public'.DS.'uploads'.$mp3Src->getSaveName();
	                
	            }else{
	            	$this->error($mp3Src -> getError());
	            }
        	
        	}else{
        		$saveData['mp3Src']=input('mp3Hide');
        	}

        	//2.更新
					db('goods')->where("goodsID",input('id'))->update($saveData);
					//跳转页面
					//如果没有传第二个参数（url地址），默认跳回保存之前的界面
					//$this->success('添加成功！',url('goods/index'));
			        $this->success('修改成功！','index');
        }else{
            $this->error($goods->getError());//验证显示错误信息
        }
		
	}//update end
	function mobilegoods(){
		$goodsList=db('goods')->select();
		return jsonp($goodsList);
	}
	function categoods($id){
		//echo $id;
		$goodsList=db('goods')->where("cateID=$id")->select();
		//print_r($goodsList);exit();
		return jsonp($goodsList);
	}
}