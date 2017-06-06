///////////////  获取剧集的数据 ////////////////
//1. npm install superagent &&  npm install cheerio
//2.引入模块
var request = require("superagent");
var cheerio = require("cheerio");
var fs = require("fs");//fileSystem 文件或目录有关操作
var saveArr=[];//保存的数组
var params=process.argv.splice(2);//保存传过来的参数
//var params="http://www.kuaikanmanhua.com/web/topic/777/";
var collectAddr=params[0];
if(params.length==0){//没有传参数
  console.log("请传参！");
}else{
  //console.log(collectAddr);
  //3.使用request对象调用post方法，传入url地址，通过end方法接受反过来的数据
  // request.post('http://www.kuaikanmanhua.com/?tag=19#type')
  request.get(collectAddr)//命令行传入一个采集地址 如何获取？process.argv获取参数 分割.splice();
         .end(function(error,rtnData){
            //console.log(rtnData.text);//得到html

            //4.通过cheerio模块解析
            var $=cheerio.load(rtnData.text);//加载html源代码，放在一个变量，为了适应JQ，把变量名直接命名为$

            //$是整个html 找盒子 遍历
            //某个分类的所有html 获取类别名称，图片url，标题等
            $('.table tr').each(function(index,element){//索引，当前标签
                var imgSrc=$(element).find('.kk-sub-img').attr('src');//获取剧集的图片
                //console.log(imgSrc);
                var aTag=$(element).find('.article-img');//获取a标签
                var name=aTag.attr('title');//标题
                var href="http://www.kuaikanmanhua.com"+aTag.attr('href');//获取点击图片的链接

                //5.保存json文件  没获取一条数据，存到数组中
                saveArr.push({
                  imgSrc,
                  name,
                  href
                });//saveArr.push end
            });//each end

            collectContent(0);
            function collectContent(num){
              var contentArr=[];
              request.get(saveArr[num]['href']).end(function(error,rtnData){//获取简介
                  var $=cheerio.load(rtnData.text);
                  var contentList=$('.comic-imgs .kklazy');//获取剧集内容图片（全是图片）
                  contentList.each(function(index,element){
                    var content=$(element).attr('data-kksrc');
                    contentArr.push(content);
                  });
                  saveArr[num]['content']=contentArr;
                  if (num+1==saveArr.length) {
                    //写入文件 异步的 参数：文件名（没有目录，当前文件根目录）；写入文件的数据（string或buffer流）
                    fs.writeFile('episode.json',JSON.stringify(saveArr));//将数组变成字符串，给php用，要用json文件
								  }else{
								  	 num++;
								  	 collectContent(num);
								  }
                    //console.log(saveArr);
              });
            }//collectSummary end
            //写入文件 异步的 参数：文件名（没有目录，当前文件根目录）；写入文件的数据（string或buffer流）
            // fs.writeFile('episode.json',JSON.stringify(saveArr));//将数组变成字符串，给php用，要用json文件
            //console.log(saveArr);
         });//.end end

}
