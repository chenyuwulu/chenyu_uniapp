<template>
	<view class="content">
		<!-- #ifdef MP-WEIXIN -->
			<view>
				<image style="width: 200upx;height: 200upx;" :src="(userinfo.avatarUrl?userinfo.avatarUrl:'../../static/logo.png')" />
			</view>
			<view>{{userinfo.nickName}}</view>
			<button type="primary" open-type="getUserInfo" @getuserinfo="getuserinfo">用户授权</button>
		<!-- #endif -->
	</view>
</template>

<script>
	const app = getApp()
	export default {
		data() {
			return {
				userinfo:{
					nickName:"暂无",
					avatarUrl:""
				}
			}
		},
		onLoad() {
			this.userinfo = uni.getStorageSync('userInfo').wxInfo
		},
		methods: {
			getuserinfo(e){
				const that = this
				let app_mp_weixin = app.$vm.$options
				// console.log(e)
				app_mp_weixin.util.getUserInfo(function(userInfo) {
					//这回userInfo为用户信息
					 console.log(userInfo)
					 that.userinfo = userInfo.wxInfo
				}, e.detail)
			}
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
