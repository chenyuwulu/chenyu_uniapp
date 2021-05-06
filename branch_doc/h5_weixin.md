# 微信公众号(移动端web)

## 如何查看
1. 通过`HBuilderX`工具打开`uniapp_project`文件夹
2. 将`/common/we7_js/siteinfo.js`中的微信公众号的部分改为自己微擎后端对应的数据
```js
// #ifdef H5
const siteInfo = {
	'name': 'chenyu_uniapp', //你的模块名称
	'title': '',//标题名
	'uniacid': '1',//微擎区分公众号，小程序，app等平台的id
	'acid': '1',//微擎区分公众号，小程序，app等平台的id
	'multiid': '0',
	'version': '1.0.0',//版本号，和你后台创建的版本号要对应
	'siteroot': 'https://weiqing.chenyuwulu.top/app/index.php'//你的微擎域名地址
}
// #endif
```
3. 根据`HBuilderX`工具所提供的运行功能，运行对应的微信开发工具查看。

##如何开发调试
1.首先建议不要在