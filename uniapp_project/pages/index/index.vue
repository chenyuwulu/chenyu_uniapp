<template>
<view class="content">
	<image class="logo" :src="list.w.current_module.logo"></image>
	<view class="text-area">
		<text class="title">{{list.w.current_module.description}}</text>
	</view>
	<!-- #ifdef MP-ALIPAY -->
	<view>
		<navigator open-type="navigate" url="../canvas/index" hover-class="navigator-hover">跳转到canvas</navigator>
	</view>
	<!-- #endif -->
</view>
</template>

<script>
	import request from "@/common/pocky-request/index.js"
	const app = getApp()
	const instance = new request()
	export default {
		data() {
			return {
				list: {}
			}
		},
		onLoad() {
			/*
			* 直接共用request，充分利用ifdef,样例中特意把h5版本和其他版本做了方法不同的区分。
			* 在实际使用中，全平台的方法名大多都是统一的，所以在写逻辑代码的时候，甚至都不需要区分平台方法
			* 
			* ！！！注意在config,siteinfo配置中详细配置区分！！！
			* 
			*/
			instance.request({
				data: {
					// #ifdef MP-WEIXIN || MP-ALIPAY || MP-TOUTIAO || APP-PLUS
						do:'test',
					// #endif
					// #ifdef H5
						do:'index',
					// #endif
				},
				method:'post',
			}).then(res => {
				console.log('这是instance的',res)
				this.list = res.data.data
			})
		},
		onShow(){
			
		},
		methods: {
		}
	}
</script>

<style>
.content {
	display: flex;
	flex-direction: column;
	align-items: center;
	justify-content: center;
}

.logo {
	height: 200upx;
	width: 200upx;
	margin-top: 200upx;
	margin-left: auto;
	margin-right: auto;
	margin-bottom: 50upx;
}

.text-area {
	display: flex;
	justify-content: center;
}

.title {
	font-size: 36upx;
	color: #8f8f94;
}
</style>
