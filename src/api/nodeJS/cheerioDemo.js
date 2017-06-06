//1.npm install cheerio
//2.引入模块
var cheerio = require("cheerio");
// var fs = require("fs");//fileSystem
// var saveArr[];
//3.
let $=cheerio.load('<h2 class="title">Hello world</h2>');//加载html源代码，放在一个变量，为了适应JQ，把变量名直接命名为$
var retStr=$('h2.title').text();//查找h2.title的文本
console.log(retStr);
// $('h2.title').text('Hello there!')
// $('h2').addClass('welcome');
// $.html();
