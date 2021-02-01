<script>
	export default {
		onLaunch() {//当uni-app启动，第一次显示
			console.log('当uni-app启动，第一次显示')
		},
		onShow() {//当uni-app启动，或从后台进入前台显示
			console.log('当uni-app启动，或从后台进入前台显示')
		},
		onHide() {//当uni-app从前台进入后台
			console.log('当uni-app从前台进入后台')
		},
		onError(error) {//当uni-app报错时触发
			console.log('当uni-app报错时触发',error)
		},
		onUniNViewMessage() {//对nvue页面发送的数据进行监听
			console.log('对nvue页面发送的数据进行监听')
		},
		globalData:{//这里放不变的常量，变量统统放到vuex内
			
		}
	}
</script>

<style lang="scss">
	@import "@/components/uview-ui/index.scss";//引入uview的css库
	.chenyu_page{//统一的box设置
		display: flex;
		flex-direction: column;
		color: #000000;
		height: auto;
		min-height: 100vh;
		background-color: #F8F8F8;
		
	}
</style>
