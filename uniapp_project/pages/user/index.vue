<template>
	<view class="content">
		<!-- #ifdef H5 -->
			<view>
				<image style="width: 200upx;height: 200upx;" :src="(userinfo.avatar?userinfo.avatar:'../../static/logo.png')" />
			</view>
			<view>{{userinfo.nickname}}</view>
		<!-- #endif -->
		<!-- #ifdef MP-WEIXIN || MP-TOUTIAO -->
			<view>
				<image style="width: 200upx;height: 200upx;" :src="(userinfo.avatarUrl?userinfo.avatarUrl:'../../static/logo.png')" />
			</view>
			<view>{{userinfo.nickName}}</view>
			<!-- #ifdef MP-WEIXIN -->
			<view style="margin-top: 50rpx;">
				此按钮是原版的微擎方式,只使用微信小程序平台建议用此方法，
				<text class="text-red">但是拒绝授权还是会执行request</text>
			</view>
			<button class="cu-btn bg-blue lg shadow" open-type="getUserInfo" @getuserinfo="mp_wx_weiqing_getuserinfo">用户授权</button>
			<view style="margin-top: 50rpx;">此按钮脱离微擎封装方法，自己传加密数据自己解密，用于方便后期多平台使用(会记录在user_mp_wx表)</view>
			<button class="cu-btn lines-blue lg shadow" open-type="getUserInfo" @getuserinfo="mp_wx_getuserinfo">用户授权</button>
			<!-- #endif -->
		<!-- #endif -->
		<!-- #ifdef MP-ALIPAY -->
			<view>
				<image style="width: 200upx;height: 200upx;" :src="(userinfo.avatar?userinfo.avatar:'../../static/logo.png')" />
				<view style="text-align: center;">{{userinfo.nickName}}</view>
			<!-- 	<button type="primary" onGetAuthorize="onGetAuthorize" onError="onAuthError" open-type="getAuthorize" scope='userInfo'>
				    会员基础信息授权
				</button> -->
			</view>
		<!-- #endif -->
		<!-- #ifdef APP-PLUS -->
			<view style="width: 100%;display: flex;flex-direction:column">
				<image style="width: 300upx;height: 300upx;align-self:center;" :src="userinfo_qq.figureurl_qq"></image>
				<view style="align-self:center;">{{userinfo_qq.nickName}}</view>
				<button class="cu-btn bg-blue lg shadow" @tap="get_userinfo_qq">QQ登录</button>
				<image style="width: 300upx;height: 300upx;align-self:center;" :src="userinfo_wx.avatarUrl"></image>
				<view style="align-self:center;">{{userinfo_wx.nickName}}</view>
				<button class="cu-btn bg-green lg shadow" @tap="get_userinfo_wx">微信登录</button>
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
				userinfo:{},
				// #ifdef APP-PLUS
				userinfo_qq:{},
				userinfo_wx:{}
				// #endif
			}
		},
		onLoad() {
			
		},
		onShow() {
			const that = this
			// #ifdef H5
				instance.request({
					data: {
						do:'index',
					},
					method:'post',
				}).then(res => {
					console.log('这是instance的',res)
					that.userinfo = res.data.w.fans
				})
			// #endif
			
			// #ifdef MP-WEIXIN
				this.userinfo = uni.getStorageSync('userInfo').wxInfo
			// #endif
			
			// #ifdef MP-ALIPAY
				//这是阿里的老毛病的，只要能跑，就知足吧,主要是后端这边的SDK贼大，拖慢效率
				my.getAuthCode({
				  scopes: 'auth_user',
				  success: (z) => {
						console.log('这里获取的是code',z)
						my.getAuthUserInfo({
						  success: (x) => {
								console.log(x)
								that.userinfo = x
								instance.request({
									data: {
										do:'getuserinfo',
										authCode:z.authCode,
										nickName:x.nickName,
										avatar:x.avatar,
									},
									method:'post',
								}).then(res => {
									uni.showToast({
									    title: '返回成功',
									    duration: 2000
									})
									console.log('这是instance的',res)
								})
						  }
						})
					}
				})
			// #endif
			
			// #ifdef MP-TOUTIAO
				uni.login({
				  success:  (z) => {
				    console.log(z)
				    // 获取用户信息
				    uni.getUserInfo({
							withCredentials:true,
				      success: (y) => {
				        console.log(y)
								instance.request({
									data: {
										do:'getuserinfo',
										code:z.code,
										anonymous_code:z.anonymousCode,
										encryptedData:y.encryptedData,
										iv:y.iv
									},
									method:'post',
								}).then(res => {
									console.log('这是instance的',res)
									uni.showToast({
									    title: '返回成功',
									    duration: 2000
									})
									that.userinfo = res.data.data
								})
				      }
				    })
				  }
				})
			// #endif
		},
		methods: {
			
			// #ifdef MP-ALIPAY
				// onGetAuthorize(res){
				// 	console.log(res)
				// 	my.getOpenUserInfo({
				// 		fail: (res) => {
				// 			console.log(res)
				// 		},
				// 		success: (res) => {
				// 			console.log(res)
				// 		}
				// 	})
				// },
				// onAuthError(e){
				// 	console.log(e)
				// },
			// #endif
			
			
			// #ifdef MP-WEIXIN
				mp_wx_weiqing_getuserinfo(e){
					const that = this
					let app_mp_weixin = app.$vm.$options
					app_mp_weixin.util.getUserInfo(function(userInfo) {
						//这回userInfo为用户信息
						 console.log(userInfo)
						 that.userinfo = userInfo.wxInfo
					}, e.detail)
				},
				mp_wx_getuserinfo(e){
					const that = this
					uni.login({
						success: (x) => {
							instance.request({
								data: {
									do:"me_getuserinfo",
									code:x.code,
									rawData:e.detail.rawData,
									signature:e.detail.signature,
									iv:e.detail.iv,
									encryptedData:e.detail.encryptedData
								},
								method:'post',
							}).then(res => {
								console.log('这是instance的',res)
								uni.showToast({
								    title: '返回成功',
								    duration: 2000
								})
								that.userinfo = res.data.data
							})
						}
					})
				},
			// #endif
			
			// #ifdef APP-PLUS
				get_userinfo_qq(e){
					const that = this
					console.log(e)
					uni.getProvider({
						service: 'oauth',
						success: function (res) {
							console.log(res)
							if (~res.provider.indexOf('qq')) {
								uni.login({
									provider: 'qq',
									success: loginRes=> {
										console.log(JSON.stringify(loginRes))
										uni.getUserInfo({
											provider: 'qq',
											success: function (z) {
												console.log(z)
												that.userinfo_qq = z.userInfo
												instance.request({
													data: {
														do:'me_userinfo_qq',
														openId:z.userInfo.openId,
														nickName:z.userInfo.nickName,
														gender:z.userInfo.gender,
														city:z.userInfo.city,
														province:z.userInfo.province,
														year:z.userInfo.year,
														figureurl_qq:z.userInfo.figureurl_qq,
													},
													method:'post',
												}).then(res => {
													console.log('这是instance的',res)
												})
											}
										})
									}
								})
							}
						}
					})
				},
				get_userinfo_wx(e){
					const that = this
					uni.getProvider({
						service: 'oauth',
						success: function (x) {
							console.log(x)
							if (~x.provider.indexOf('weixin')) {
								uni.login({
									provider: "weixin",
									success: function (loginRes) {
										console.log(JSON.stringify(loginRes))
										uni.getUserInfo({
											provider: 'weixin',
											success: function (z) {
												console.log(z)
												that.userinfo_wx = z.userInfo
												instance.request({
													data: {
														do:'me_userinfo_wx',
														openId:z.userInfo.openId,
														nickName:z.userInfo.nickName,
														gender:z.userInfo.gender,
														city:z.userInfo.city,
														province:z.userInfo.province,
														country:z.userInfo.country,
														avatarUrl:z.userInfo.avatarUrl,
													},
													method:'post',
												}).then(res => {
													console.log('这是instance的',res)
												})
											}
										})
									}
								})
							}
						}
					})
				},
			// #endif
		}
	}
</script>

<style>
	
.content {
	display: flex;
	flex-direction: column;
	align-items: center;
	justify-content: center;
	width: 90%;
	margin-left: 5%;
	margin-right: 5%;
	
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
