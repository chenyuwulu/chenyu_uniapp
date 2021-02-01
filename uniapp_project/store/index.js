import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

const store = new Vuex.Store({
	state: {
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
		
	},
	actions:{
		
	},
	getters:{
		
	}
})

export default store
