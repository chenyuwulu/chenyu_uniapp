import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

const store = new Vuex.Store({
	state: {//vuex的变量池
		vuex_tabbar: [{
				iconPath: "/static/tabbar/home.png",
				selectedIconPath: "/static/tabbar/home-fill.png",
				text: '首页',
				pagePath: '/pages/index/index'
			},{
				iconPath: "/static/tabbar/user.png",
				selectedIconPath: "/static/tabbar/switch-user.png",
				text: '我的',
				pagePath: '/pages/user/index',
			}
		],
	},
})

export default store
