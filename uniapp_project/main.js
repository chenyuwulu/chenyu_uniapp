import Vue from 'vue'
import App from './App'
import util from './common/we7_js/util.js'
import siteInfo from './common/we7_js/siteinfo.js'

Vue.config.productionTip = false

App.mpType = 'app'
App.util = util
App.siteInfo = siteInfo

const app = new Vue({
    ...App
})
app.$mount()
