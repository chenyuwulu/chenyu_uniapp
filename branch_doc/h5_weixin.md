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

## 基本概念
uniapp下开发的h5端，总体上来说和vue的h5端是一样的，基本可以通用，并且在可以使用所有h5端的特性（dom节点和window）内又可以用uni的api。但是在实际情况下，如果你只是开发网页端，显然没必要用uniapp，既然你用了uniapp，我就当你是要活用uniapp的跨小程序和app端的能力了。所以尽可能避免dom。

**<font color=#840228 size=4>
本示例的微擎服务器是正常的线上服务器，能用https正常访问的线上服务器，如果是采用本地模拟环境的话，请自行替换后面说的服务器概念。
</font>**

## 如何开发调试
1. **<font color=#2585a6 size=4>uniapp端的操作</font>**

我采用尽可能简单的概念来进行开发，或许有些步骤显得繁琐，但其实真正繁琐的步骤并不长。并且有些感觉繁琐的步骤根本不会占开发周期多少时间。以下就是我调试开发h5的配置，关于index.html模板和路由模式，请直接搜索vue相关的说明。至 运行的基础路径 下的配置是我发布的时候微擎要放编译后文件的目录。

![](static/h5/1.png)

2. **<font color=#2585a6 size=4>微擎端的操作</font>**

将自己要用来开发测试的微擎后端的一个php文件注释掉一部分代码，主要是为了避免微擎自身封装的授权公众号信息的方法，因为会干扰前后端分离的模式。

![](static/h5/2.png)

在site.php文件头部加入允许所有跨域，不然你的开发调试阶段，会警告跨域问题

![](static/h5/3.png)

至于为什么我不把方法写在site.php里而是放在inc/mobile/weixin_jssdk.inc.php文件里，请自行参考微擎相关的文档。这只是为了方便管理。其次方法编写的最大不同就是，原本微擎的是直接include打开html文件的结尾，变成了我写的传值的回调，这部分方法可自行封装定义，我这边的例子只是最简单的展示。

![](static/h5/4.png)