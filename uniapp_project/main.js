import Vue from 'vue'
import App from './App'
import util from './common/we7_js/util.js'
import siteInfo from './common/we7_js/siteinfo.js'
import store from '@/store'
Vue.prototype.$store = store

import uView from "./components/uview-ui"
Vue.use(uView)

Vue.config.productionTip = false

App.mpType = 'app'
App.util = util
App.siteInfo = siteInfo

const app = new Vue({
	store,
	...App
})
// http拦截器，将此部分放在new Vue()和app.$mount()之间，才能App.vue中正常使用
import httpInterceptor from '@/common/http.interceptor.js'
Vue.use(httpInterceptor, app)
app.$mount()
