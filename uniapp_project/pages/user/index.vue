<template>
	<view class="page_box">
		<!-- #ifdef H5 -->
			<view>
				<image style="width: 200rpx;height: 200rpx;" :src="(userinfo.avatar?userinfo.avatar:'../../static/logo.png')" />
			</view>
			<view>{{userinfo.nickname}}</view>
		<!-- #endif -->
		<!-- #ifdef MP-WEIXIN || MP-TOUTIAO -->
			<u-gap height="100" />
				<image style="width: 200rpx;height: 200rpx;" :src="(userinfo.avatarUrl?userinfo.avatarUrl:'../../static/logo.png')" />
			<u-gap height="20" />
			<view>{{userinfo.nickName}}</view>
			<!-- #ifdef MP-WEIXIN -->
			<u-gap height="50" />
			<view>
				此按钮是原版的微擎方式,只使用微信小程序平台建议用此方法，
				<text class="text-red">但是拒绝授权还是会执行request</text>
			</view>
			<u-button shape="circle" type="success" :custom-style="{color:'#FFFFFF','background-color':'#418BC9'}" open-type="getUserInfo" @getuserinfo="mp_wx_weiqing_getuserinfo">用户授权</u-button>
			<view style="margin-top: 50rpx;">此按钮脱离微擎封装方法，自己传加密数据自己解密，用于方便后期多平台使用(会记录在user_mp_wx表)</view>
			<u-button shape="circle" type="success" :custom-style="{color:'#FFFFFF','background-color':'#418BC9'}" open-type="getUserInfo" @getuserinfo="mp_wx_getuserinfo">用户授权</u-button>
			<!-- #endif -->
		<!-- #endif -->
		<!-- #ifdef MP-ALIPAY -->
			<view>
				<image style="width: 200rpx;height: 200rpx;" :src="(userinfo.avatar?userinfo.avatar:'../../static/logo.png')" />
				<view style="text-align: center;">{{userinfo.nickName}}</view>
			<!-- 	<button type="primary" onGetAuthorize="onGetAuthorize" onError="onAuthError" open-type="getAuthorize" scope='userInfo'>
				    会员基础信息授权
				</button> -->
			</view>
		<!-- #endif -->
		<!-- #ifdef APP-PLUS -->
			<view style="width: 100%;display: flex;flex-direction:column">
				<image style="width: 300rpx;height: 300rpx;align-self:center;" :src="userinfo_qq.figureurl_qq"></image>
				<view style="align-self:center;">{{userinfo_qq.nickName}}</view>
				<button class="cu-btn bg-blue lg shadow" @tap="get_userinfo_qq">QQ登录</button>
				<image style="width: 300rpx;height: 300rpx;align-self:center;" :src="userinfo_wx.avatarUrl"></image>
				<view style="align-self:center;">{{userinfo_wx.nickName}}</view>
				<button class="cu-btn bg-green lg shadow" @tap="get_userinfo_wx">微信登录</button>
			</view>
		<!-- #endif -->
		<u-tabbar :height="100" activeColor="#418BC9" :list="vuex_tabbar" />
	</view>
</template>

<script>
	const app = getApp()
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
		computed:{//tabbar使用
			vuex_tabbar(){
				return this.$store.state.vuex_tabbar
			}
		},
		onLoad(options) {},
		onShow() {
			// #ifdef H5
				this.$u.post('app/index.php',{
					do:'index',
				}).then(res=>{
					console.log('这是返回的',res)
					this.userinfo = res.data.w.fans
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
								this.userinfo = x
								this.$u.post('app/index.php',{
									do:'getuserinfo',
									authCode:z.authCode,
									nickName:x.nickName,
									avatar:x.avatar,
								}).then(res=>{
									uni.showToast({
									    title: '返回成功',
									    duration: 2000
									})
									console.log('这是返回的',res)
								}).catch(err=>{
									console.log(err)
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
								this.$u.post('app/index.php',{
									do:'getuserinfo',
									code:z.code,
									anonymous_code:z.anonymousCode,
									encryptedData:y.encryptedData,
									iv:y.iv
								}).then(res=>{
									uni.showToast({
										title: '返回成功',
										duration: 2000
									})
									console.log('这是返回的',res)
									this.userinfo = res.data.data
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
				mp_wx_weiqing_getuserinfo(e){//这是微擎自带的方法
					let app_mp_weixin = app.$vm.$options
					app_mp_weixin.util.getUserInfo((userInfo)=> {
						//这回userInfo为用户信息
						 console.log(userInfo)
						 this.userinfo = userInfo.wxInfo
					}, e.detail)
				},
				mp_wx_getuserinfo(e){//这是自己封装的方法
					uni.login({
						success:x=> {
							this.$u.post('app/index.php',{
								do:"me_getuserinfo",
								code:x.code,
								rawData:e.detail.rawData,
								signature:e.detail.signature,
								iv:e.detail.iv,
								encryptedData:e.detail.encryptedData
							}).then(res=>{
								console.log('这是返回的',res)
							})
						}
					})
				},
			// #endif
			
			// #ifdef APP-PLUS
				get_userinfo_qq(e){//qq快捷登录
					console.log(e)
					uni.getProvider({
						service: 'oauth',
						success: (res)=> {
							console.log(res)
							if (~res.provider.indexOf('qq')) {
								uni.login({
									provider: 'qq',
									success: loginRes=> {
										console.log(JSON.stringify(loginRes))
										uni.getUserInfo({
											provider: 'qq',
											success: (z)=> {
												console.log(z)
												this.userinfo_qq = z.userInfo
												this.$u.post('app/index.php',{
													do:'me_userinfo_qq',
													openId:z.userInfo.openId,
													nickName:z.userInfo.nickName,
													gender:z.userInfo.gender,
													city:z.userInfo.city,
													province:z.userInfo.province,
													year:z.userInfo.year,
													figureurl_qq:z.userInfo.figureurl_qq,
												}).then(response=>{
													console.log('这是返回的',response)
												})
											}
										})
									}
								})
							}
						}
					})
				},
				get_userinfo_wx(e){//微信快捷登录
					uni.getProvider({
						service: 'oauth',
						success: (x)=>{
							console.log(x)
							if (~x.provider.indexOf('weixin')) {
								uni.login({
									provider: "weixin",
									success: (loginRes)=> {
										console.log(JSON.stringify(loginRes))
										uni.getUserInfo({
											provider: 'weixin',
											success: (z)=>{
												console.log(z)
												this.userinfo_wx = z.userInfo
												this.$u.post('app/index.php',{
													do:'me_userinfo_wx',
													openId:z.userInfo.openId,
													nickName:z.userInfo.nickName,
													gender:z.userInfo.gender,
													city:z.userInfo.city,
													province:z.userInfo.province,
													country:z.userInfo.country,
													avatarUrl:z.userInfo.avatarUrl,
												}).then(response=>{
													console.log('这是返回的',response)
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

<style lang="scss">
	.page_box {
		display: flex;
		flex-direction: column;
		align-items: center;
		justify-content: center;
		padding-left: 36rpx;
		padding-right: 36rpx;
		.logo {
			height: 200rpx;
			width: 200rpx;
			margin-top: 200rpx;
			margin-left: auto;
			margin-right: auto;
			margin-bottom: 50rpx;
		}
		.text-area {
			display: flex;
			justify-content: center;
		}
		.title {
			font-size: 36rpx;
			color: #8f8f94;
		}
	}
</style>
