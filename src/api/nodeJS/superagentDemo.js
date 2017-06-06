//1. npm install superagent
//2.引入模块
var request = require("superagent");
//3.使用对象调用post方法，传入url地址，通过end方法接受反过来的数据
request.post('http://www.kuaikanmanhua.com/?tag=19#type')
       .end(function(error,rtnData){
          console.log(rtnData.text);
       });
// node superagent  运行
