<template>
	<view class="content">
		<!-- #ifdef MP-WEIXIN -->
			<view>
				<image style="width: 200upx;height: 200upx;" :src="(userinfo.avatarUrl?userinfo.avatarUrl:'../../static/logo.png')" />
			</view>
			<view>{{userinfo.nickName}}</view>
			<button type="primary" open-type="getUserInfo" @getuserinfo="mp_wx_getuserinfo">用户授权</button>
		<!-- #endif -->
		<!-- #ifdef MP-ALIPAY -->
			<view>
				<image style="width: 200upx;height: 200upx;" :src="(userinfo.avatar?userinfo.avatar:'../../static/logo.png')" />
				<view style="text-align: center;">{{userinfo.nickName}}</view>
			<!-- 	<button type="primary" @onGetAuthorize="onGetAuthorize" @onError="onAuthError" open-type="getAuthorize" scope='userInfo'>
				    会员基础信息授权
				</button> -->
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
		},
		methods: {
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
			onGetAuthorize(e) {
				console.log(e)
				my.getOpenUserInfo({
				fail: (res) => {
					console.log(res)
				},
				success: (res) => {
					console.log(JSON.parse(res.response).response)
				// let userInfo = JSON.parse(res.response).response // 以下方的报文格式解析两层 response
				}
				});
			},
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
