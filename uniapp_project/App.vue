<script>
	export default {
		onLaunch() {
			const res = uni.getSystemInfoSync()
			console.log(res)
			if(res.pixelRatio>1){
				//不推荐直接根据反馈的来，为了性能考虑，最好固定2
				this.$options.globalData.pixelRatio =2
			}
			this.$options.globalData.pWidth = res.windowWidth
			this.$options.globalData.pHeight = res.windowHeight
		},
		onShow() {
			console.log('App Show')
		},
		onHide() {
			console.log('App Hide')
		},
		globalData:{
			pWidth:400,
			pHeight:0,
			pixelRatio:1
		}
	}
</script>

<style>
	/*每个页面公共css */
	@import "components/colorui/main.css";
	@import "components/colorui/icon.css";
	@import "components/colorui/animation.css";
</style>
