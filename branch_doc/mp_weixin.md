# 微信小程序

## 如何使用
1. 通过`HBuilderX`工具打开`uniapp_project`文件夹
2. 将`/common/we7_js/siteinfo.js`中的微信小程序的部分改为自己微擎后端对应的数据
```js
// #ifdef MP-WEIXIN
const siteInfo = {
    'name': 'chenyu_uniapp', //你的模块名称
    'title': '',//标题名
    'uniacid': '5',//微擎区分公众号，小程序，app等平台的id
    'acid': '5',//微擎区分公众号，小程序，app等平台的id
    'multiid': '0',
    'version': '1.0.0',//版本号，和你后台创建的版本号要对应
    'siteroot': 'https://weiqing.chenyuwulu.top/app/index.php'//你的微擎域名地址
}
// #endif
```
3. 根据`HBuilderX`工具所提供的运行功能，运行对应的微信小程序开发工具查看。

## uniapp打包的小程序如何上架微擎商城流程
![](https://cdn.w7.cc/images/2019/12/12/p6iQbgFUS4cCb99AEJYwJjemwjFxRcdX46sQsnjY.png "说明图")
<br>
首先按照uniapp的方式打包出来会发现，siteinfo.js不存在，但是我们在开发阶段是确确实实把siteinfo.js给引入到项目内的，那去了哪了？整个项目又是正常和微擎后台进行通信的，所以配置信息一定是存在的，那就是被整合到里面去了。
<br>
我们通过vscode或其他编辑器，进行全局搜索，搜索我们配置的siteinfo内的信息，比如域名
<br>
![](https://cdn.w7.cc/images/2019/12/12/Qx4x7Zki4ip7yohrQBvo6Kv4x8n3LEB3q8aUsaFK.png)
<br>
于是发现了这个
<br>
![](https://cdn.w7.cc/images/2019/12/12/3CoBZRYowBgbPRsCrbkr6ns70A8fbM41ZfMfPL9o.png)
<br>
你会发现，我们的siteinfo.js的信息都被整合到了一个总的js文件内了，原本，是为了减少js文件的引用，从而提高性能。

但是微擎的规则是需要有siteinfo，才能根据不同用户的配置生成不同的siteinfo，来给不同用户使用。
那我们只要把这个整合进里面的siteinfo相关的信息，重新独立放在外面的js里，再重新引入即可
<br>
![](https://cdn.w7.cc/images/2019/12/12/QcX76wuypB53vXdpYSlJCZVTC4mRxHIxjM3qRoBC.png)
<br>
然后把原先的siteinfo数据删除，重新引入
<br>
![](https://cdn.w7.cc/images/2019/12/12/0HcoUeBWgQnwtR7OMr2wPtv9CrprMhu3FLgLdiH8.png)
<br>
那么这样就结束了吗？还不够，微擎这边还有道检查，是要检查你的app.js内是否有引入siteinfo。所以要在app.js内继续引入
<br>
![](https://cdn.w7.cc/images/2019/12/12/AU11dTG2jch1A4DOYreDN5bQZgANNB1ii5xCK0c5.png)
<br>
当然了，这个只是为了应付微擎的规则检查，我们实际的引入还是在那个整个的vendor.js里。这里引入的siteInfo没实际用处。