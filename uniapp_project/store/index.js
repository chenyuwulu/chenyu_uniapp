import Vue from 'vue'
import Vuex from 'vuex'
// #ifdef H5
import wx_jssdk from "@/common/wx_jssdk.js"
// #endif

Vue.use(Vuex)
const store = new Vuex.Store({
	state: {
		// #ifdef H5
		jssdk:wx_jssdk,//将jssdk放入state中
		// #endif
		vuex_tabbar: [//uview的tabbar
			{	text: '首页',
				iconPath: "/static/tabbar/home.png",
				selectedIconPath: "/static/tabbar/home-fill.png",
				pagePath: '/pages/index/index'
			},
			{	text: '我的',
				iconPath: "/static/tabbar/user.png",
				selectedIconPath: "/static/tabbar/switch-user.png",
				pagePath: '/pages/user/index',
			}
		],
	},
	mutations:{
		// #ifdef H5
		open_jssdk(state,provider){
			Vue.prototype.$u.post('app/index.php',{
				do:'weixin_jssdk',
				url:window.location.href,
			}).then(res=>{
				state.jssdk.config({
					debug: false, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。  
					appId: res.jssdk.appId, // 必填，公众号的唯一标识  
					timestamp: res.jssdk.timestamp, // 必填，生成签名的时间戳  
					nonceStr: res.jssdk.nonceStr, // 必填，生成签名的随机串  
					signature: res.jssdk.signature, // 必填，签名，见附录1  
					jsApiList: ["scanQRCode"]
				})
			})
		},
		// #endif
		
	},
	actions:{
		
	},
	getters:{
		
	}
})

export default store
