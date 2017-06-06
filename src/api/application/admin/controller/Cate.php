<?php
namespace app\admin\controller;

class Cate extends \think\Controller
{
	function index(){
		$cateList=db('cate')->paginate(5);
		$this->assign('cateList',$cateList);
		return $this->fetch();
	}
	function add(){
		return view();
	}
	function save(){
		//1.第一步：把表单传过来的数据放到一个数组里
		//echo $_GET['cateName'];exit();
		$saveData=array(
          'cateName'=>input('cateName'),//用框架自带的方法获取表单传过来的数据
          'nickName'=>input('nickName'),
          'introduce'=>input('introduce'),
          'cateImg'=>input('cateImg')
        );
        //使用验证规则
        $cate=validate("cate");
        if($cate->check($saveData)){//调用check方法，不合规则返回false

        	//上传文件
        	$file=request()->file('cateImg');//获取表单传过来的文件
        	$cateImg='';
        	if(!empty($file)){//上传文件不为空
        		$cateImg=$file->move(ROOT_PATH .'public'.DS.'uploads');//保存到根目录的public下
	        	if($cateImg){//判断文件是否上传成功
					//文件入口
	                $saveData['cateImg'] = DS.'public'.DS.'uploads'.DS.$cateImg->getSaveName();
	            }else{
	            	$this->error($cateImg -> getError());
	            }
        	}
        	//2.插入数据库表中
					db('cate')->insert($saveData);
					//跳转页面
					//如果没有传第二个参数（url地址），默认跳回保存之前的界面
					//$this->success('添加成功！',url('cate/index'));
			        $this->success('添加成功！','cate/index');
        	
        }else{
            $this->error($cate->getError());//验证显示错误信息
        }
		
	}//save end
	function song($id){//歌曲
		// echo $id;exit();
		$musicList=db('music')->where("cateID=$id")->select();
		$cateList=db('cate')->where("cateID=$id")->find();
		$this->assign('musicList',$musicList);
		$this->assign('cateList',$cateList);
		return $this->fetch();
	}
	function delete($id){
		db('cate')->where("cateID='$id'")->delete();
		$this->success('删除成功！','index');
		// echo  $id;
	}
	function edit($id){
		$cateList=db('cate')->where("cateID='$id'")->find();
		$this->assign('cateList',$cateList);
		//print_r($cateList);
		//歌手类型的数据
        $cateList = db('catecate')->select();
        $this->assign('cateList',$cateList);
		return $this->fetch();
		// return view();
	}
	function update(){
		//1.第一步：把表单传过来的数据放到一个数组里
		//echo $_GET['cateName'];exit();
		$saveData=array(
          'cateName'=>input('cateName'),//用框架自带的方法获取表单传过来的数据
          'nickName'=>input('nickName'),
          'cateType'=>input('cateType'),
          'introduce'=>input('introduce'),
        );
        //使用验证规则
        $cate=validate("cate");
        if($cate->scene('edit')->check($saveData)){//调用check方法，不合规则返回false

        	//上传文件
        	$file=request()->file('cateImg');//获取表单传过来的文件
        	if($file){
        		$cateImg=$file->move(ROOT_PATH .'public'.DS.'uploads');//保存到根目录的public下
	        	if($cateImg){//判断文件是否上传成功
					//文件入口
	                $saveData['cateImg'] = DS.'public'.DS.'uploads'.$cateImg->getSaveName();
	                
	            }else{
	            	$this->error($cateImg -> getError());
	            }
        	
        	}else{
        		$saveData['cateImg']=input('cateImg');
        	}

        	//2.更新
					db('cate')->where("cateID",input('id'))->update($saveData);
					//跳转页面
					//如果没有传第二个参数（url地址），默认跳回保存之前的界面
					//$this->success('添加成功！',url('cate/index'));
			        $this->success('修改成功！','index');
        }else{
            $this->error($cate->getError());//验证显示错误信息
        }
		
	}//update end
	function collectcate(){
	//file_get_contents(ROOT_PATH."/nodeJS/fetchcate.js");
	//exit();
    system("node ../nodeJS/fetchcate.js ".'http://www.xiami.com/artist/index/c/1/type/1?spm=a1z1s.3057853.6850213.6.MiSrAX
');

    // 获取生成出来的json文件，把它转为数组
	   $cate_json=file_get_contents("cate.json");
	   $cate_list=json_decode($cate_json,true);//是把json转换成对象，必须要给第二个参数赋值true，才会是数组
	  //print_r($cate_list);exit();
     // 遍历数组入库

	   foreach ($cate_list as $key => $value) {
		   	$cateNameArr=explode('(', $value['cateName']);
		   	// print_r($cateNameArr);exit();
		   	if(isset($cateNameArr[1])){
		   		$nickName=str_replace(')', '', $cateNameArr[1]);
		   	}else{
		   		$nickName='';
		   	}
		   	$cateImg=str_replace('@1e_1c_100Q_100w_100h', '', $value['imgSrc']);

		        // 使用PDO添加
		   		db('cate')->insert(array(
		   				"cateName"=>$cateNameArr[0],
		   				"nickName"=>$nickName,
		   				"cateImg"=>$cateImg,
		   				"introduce"=>$value['introduce'],
		   				"href"=>$value['href']
		   				));
	   }
     $this->success('采集成功！','index');
	}
	function collectMusic($id){
		//echo $id;exit();
		$cate=db('cate')->where("cateID=$id")->find();
	// 	file_get_contents(ROOT_PATH."/nodeJS/fetchMusic.js");
	// 	echo $cate['href'];
	// exit();
	    system("node ../nodeJS/fetchMusic.js ".$cate['href']);

    // 获取生成出来的json文件，把它转为数组
	   $music_json=file_get_contents("music.json");
	   $music_list=json_decode($music_json,true);//是把json转换成对象，必须要给第二个参数赋值true，才会是数组
	  // print_r($music_list);exit();
     // 遍历数组入库

	   foreach ($music_list as $key => $value) {
		   	// $musicNameArr=explode('(', $value['musicName']);
		   	// // print_r($musicNameArr);exit();
		   	// if(isset($musicNameArr[1])){
		   	// 	$nickName=str_replace(')', '', $musicNameArr[1]);
		   	// }else{
		   	// 	$nickName='';
		   	// }
	   		preg_match_all('/id\/(\d*)/',  $value['songID'], $id_ar);
		   	$musicImg=str_replace('@1e_1c_100Q_185w_185h', '', $value['imgSrc']);

		        // 使用PDO添加
		   		db('music')->insert(array(
		   				"cateID"=>$id,
		   				"musicName"=>$value['musicName'],
		   				"musicImg"=>$value['imgSrc'],
		   				"word"=>$value['word'],
		   				'songID'=> $id_ar[1][0],
		   				"typeID"=>'',
		   				//采集加密的歌曲 ipcxiami在当前的common.php定义
		   				"mp3Src"=>ipcxiami('http://www.xiami.com/widget/xml-single/sid/'.$id_ar[1][0]),
		   				"hot"=>$value['hot']
		   				));
	   }
     $this->success('采集成功！','index');
	}
	function mobilecate(){
		$musicList=db('cate')->select();
		return jsonp($musicList);
	}
}