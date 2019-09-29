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
			<button type="primary" open-type="getUserInfo" @getuserinfo="mp_wx_getuserinfo">用户授权</button>
			<!-- #endif -->
		<!-- #endif -->
		<!-- #ifdef MP-ALIPAY -->
			<view>
				<image style="width: 200upx;height: 200upx;" :src="(userinfo.avatar?userinfo.avatar:'../../static/logo.png')" />
				<view style="text-align: center;">{{userinfo.nickName}}</view>
<!-- 				<button type="primary" @onGetAuthorize="onGetAuthorize" @onError="onAuthError" open-type="getAuthorize" scope='userInfo'>
				    会员基础信息授权
				</button> -->
			</view>
		<!-- #endif -->
		<!-- #ifdef APP-PLUS -->
		<view style="width: 100%;text-align: center;">
			<image style="width: 200upx;height: 200upx;" :src="userinfo.figureurl_qq"></image>
			<button class="" @tap="get_userinfo_qq">QQ登录</button>
		</view>
		<!-- #endif -->
	</view>
</template>

<script>
	const app = getApp()
	export default {
		data() {
			return {
				userinfo:{}
			}
		},
		onLoad() {
			
		},
		onShow() {
			// #ifdef H5
			let app_h5_weixin = app.$options
			console.log(app_h5_weixin)
			uni.request({
			    url: app_h5_weixin.siteInfo.siteroot, //仅为示例，并非真实接口地址。
			    data: {
						i:app_h5_weixin.siteInfo.uniacid,
						// t:0,
						// v:app_h5_weixin.siteInfo.version,
						// from:'aliapp',
						c:'entry',
						a:'site',
						m:'chenyu_uniapp',
						do:'index'
			    },
					method:"POST",
			    header: {
						'content-type': 'application/x-www-form-urlencoded' //自定义请求头信息
			    },
			    success: (res) => {
						console.log(res)
							this.userinfo = res.data.w.fans
			    }
			})
			// #endif
			// #ifdef MP-WEIXIN
				this.userinfo = uni.getStorageSync('userInfo').wxInfo
			// #endif
			// #ifdef MP-ALIPAY
				let app_mp_alipay = app.$vm.$options
				my.getAuthCode({
				  scopes: 'auth_user',
				  success: (res) => {
						console.log('这里获取的是code',res)
						my.getAuthUserInfo({
						  success: (x) => {
							console.log(x)
								this.userinfo = x
						  }
						})
						uni.request({
							url: app_mp_alipay.siteInfo.siteroot, //仅为示例，并非真实接口地址。
							data: {
									i:app_mp_alipay.siteInfo.uniacid,
									v:app_mp_alipay.siteInfo.version,
									c:'entry',
									a:'aliapp',
									m:'chenyu_uniapp',
									do:'getuserinfo',
									authCode:res.authCode
							},
								method:"POST",
							header: {
									'content-type': 'application/x-www-form-urlencoded' //自定义请求头信息
							},
							success: (z) => {
									console.log('这是后端getuserinfo返回的数据',z)
							}
						});
			  },
			});
			// #endif
			// #ifdef MP-TOUTIAO
				let app_mp_byte = app.$vm.$options
				const that = this
				uni.login({
				  success: function (z) {
				    console.log(z)
				    // 获取用户信息
				    uni.getUserInfo({
					  withCredentials:true,
				      success: function (y) {
				        console.log(y)
						uni.request({
							url: app_mp_byte.siteInfo.siteroot, //仅为示例，并非真实接口地址。
							data: {
									i:app_mp_byte.siteInfo.uniacid,
									v:app_mp_byte.siteInfo.version,
									c:'entry',
									a:'toutiaoapp',
									m:'chenyu_uniapp',
									do:'getuserinfo',
									code:z.code,
									anonymous_code:z.anonymousCode,
									encryptedData:y.encryptedData,
									iv:y.iv
							},
								method:"POST",
							header: {
									'content-type': 'application/x-www-form-urlencoded' //自定义请求头信息
							},
							success: (x) => {
								that.userinfo = x.data.data.userInfo
								console.log(x)
							}
						})
				      }
				    })
				  }
				})
			// #endif
		},
		methods: {
			// #ifdef MP-WEIXIN
				mp_wx_getuserinfo(e){
					const that = this
					let app_mp_weixin = app.$vm.$options
					// console.log(e)
					app_mp_weixin.util.getUserInfo(function(userInfo) {
						//这回userInfo为用户信息
						 console.log(userInfo)
						 that.userinfo = userInfo.wxInfo
					}, e.detail)
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
							if (res.provider.indexOf('qq')) {
								uni.login({
									provider: 'qq',
									success: function (loginRes) {
										console.log(JSON.stringify(loginRes))
										// uni.setStorageSync('userinfo_login', JSON.stringify(loginRes))
										uni.getUserInfo({
											provider: 'qq',
											success: function (z) {
												console.log(z)
												that.userinfo = infoRes.z
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
