///////////////  获取分类的数据 ////////////////
//1. npm install superagent &&  npm install cheerio
//2.引入模块
var request = require("superagent");
var cheerio = require("cheerio");
var fs = require("fs");//fileSystem 文件或目录有关操作
var saveArr=[];//保存的数组
var params=process.argv.splice(2);//保存传过来的参数
var collectAddr=params[0];
if(params.length==0){//没有传参数
  console.log("请传参！");
}else{
  //3.使用request对象调用post方法，传入url地址，通过end方法接受反过来的数据
  // request.post('http://www.kuaikanmanhua.com/?tag=19#type')
  request.post(collectAddr)//命令行传入一个采集地址 如何获取？process.argv获取参数 分割.splice();
         .end(function(error,rtnData){
            //console.log(rtnData.text);//得到html

            //4.通过cheerio模块解析
            var $=cheerio.load(rtnData.text);//加载html源代码，放在一个变量，为了适应JQ，把变量名直接命名为$
            //$是整个html 找盒子 遍历
            //某个分类的所有html 获取类别名称，图片url，标题等
            $('#artists .artist').each(function(index,element){//索引，当前标签
                var imgSrc=$(element).find('.image img').attr('src');//获取图片路径
                var aTag=$(element).find('.info p strong a');//获取a标签
                var singerName=aTag.text();//歌手名字包括nicknane
                var href="http://www.xiami.com"+aTag.attr('href');//获取点击图片的链接

                //5.保存json文件  没获取一条数据，存到数组中
                saveArr.push({
                  imgSrc,
                  singerName,
                  href
                });//saveArr.push end
            });//each end
            collectintroduce(0);
            function collectintroduce(num){
              request.get(saveArr[num]['href']).end(function(error,rtnData){//获取简介
                  var $=cheerio.load(rtnData.text);
                  var introduce=$('.record').text();//获取简介
                  saveArr[num]['introduce']=introduce;
                  if (num+1==saveArr.length) {
                    //写入文件 异步的 参数：文件名（没有目录，当前文件根目录）；写入文件的数据（string或buffer流）
                    fs.writeFile('singer.json',JSON.stringify(saveArr));//将数组变成字符串，给php用，要用json文件
                  }else{
                     num++;
                     collectintroduce(num);
                  }
                    //console.log(saveArr);
              });
            }//collectintroduce end

       });//.end end
}
