<template>
	<view class="chenyu_page page_box">
		
		<!-- #ifdef H5 -->
			<u-gap height="100"></u-gap>
			<image style="width: 200rpx;height: 200rpx;" :src="(userinfo.avatar?userinfo.avatar:'/static/logo.png')" />
			<u-gap height="20"></u-gap>
			<view>{{userinfo.nickname}}</view>
			<u-gap height="20"></u-gap>
			<view style="color: #888888;">因为后端是微擎，所以暂时不打算在微擎下制作h5的点击授权逻辑。</view>
		<!-- #endif -->
		
		<!-- #ifdef MP-WEIXIN -->
			<u-gap height="100" />
				<image style="width: 200rpx;height: 200rpx;" :src="(userinfo.avatarUrl?userinfo.avatarUrl:'/static/logo.png')" />
			<u-gap height="20" />
			<view>{{userinfo.nickName}}</view>
			<u-gap height="50" />
			<view>
				此按钮是原微擎方法，鉴于微信小程序改版了获取openid和用户信息。不推荐用
				<text class="text-red">但是拒绝授权还是会执行request</text>
			</view>
			<u-button shape="circle" type="success" :custom-style="{color:'#FFFFFF','background-color':'#418BC9'}" open-type="getUserInfo" @getuserinfo="mp_wx_weiqing_getuserinfo">用户授权</u-button>
			<view style="margin-top: 50rpx;">此按钮脱离微擎封装方法，自己传加密数据自己解密，用于方便后期多平台使用(会记录在user_mp_wx表)</view>
			<u-button shape="circle" type="success" :custom-style="{color:'#FFFFFF','background-color':'#418BC9'}" @click="mp_wx_getuserinfo">用户授权</u-button>
		<!-- #endif -->
		
		<!-- #ifdef MP-TOUTIAO -->
			<u-gap height="100" />
				<image style="width: 200rpx;height: 200rpx;" :src="(userinfo.avatarUrl?userinfo.avatarUrl:'/static/logo.png')" />
			<u-gap height="20" />
			<view>{{userinfo.nickName}}</view>
		<!-- #endif -->
		
		<!-- #ifdef MP-ALIPAY -->
			<view>
				<image style="width: 200rpx;height: 200rpx;" :src="(userinfo.avatar?userinfo.avatar:'/static/logo.png')" />
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

		<u-gap height="50"></u-gap>
		<view class="list_box">
			<block v-for="(item,index) in setting_list" :key="index">
				<view class="item" @tap="navigateTo(item.url)">
					<view class="left content-text">
						<u-icon :name="item.icon" size="40" color="#7A7E83"></u-icon>
						<view style="margin-left: 20rpx;font-weight: bold;">{{item.name}}</view>
					</view>
					<view class="right">
						<u-icon name="arrow-right" size="30" color="#7A7E83"></u-icon>
					</view>
				</view>
				<view v-if="setting_list.length!=index+1" style="margin-left: 20rpx;margin-right: 20rpx;width:auto;height: 2rpx;background-color: #EEEEEE;"></view>
			</block>
		</view>
		<u-tabbar :icon-size="60" :height="120" :border-top="true"  activeColor="#418BC9" :list="vuex_tabbar" />
	</view>
</template>

<script>
	const app = getApp()
	export default {
		data() {
			return {
				// #ifdef MP-WEIXIN || MP-QQ
					login_code:"",
					login_timestamp:0,
				// #endif
				userinfo:{},
				// #ifdef APP-PLUS
				userinfo_qq:{},
				userinfo_wx:{},
				// #endif
				setting_list: [
					{	name:"更新日志",
						icon:"calendar",
						url:"/pages/subPackages/setting/update_log"
					},
					{	name:"关于",
						icon:"more-circle",
						url:"/pages/subPackages/setting/about"
					},
				],
			}
		},
		computed:{//tabbar使用
			vuex_tabbar(){
				return this.$store.state.vuex_tabbar
			}
		},
		onLoad(options) {
			// #ifdef H5
				this.$u.post('app/index.php',{
					do:'index',
				}).then(res=>{
					console.log('这是返回的',res)
					this.userinfo = res.w.fans
				})
			// #endif
			// #ifdef MP-WEIXIN || MP-QQ
				this.mp_get_logincode()
			// #endif
		},
		onShow() {
			// #ifdef MP-WEIXIN
				this.userinfo = uni.getStorageSync('userInfo').wxInfo
			// #endif
			
			// #ifdef MP-ALIPAY
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
									this.userinfo = res.data
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
					uni.getUserProfile({
						desc:"获取用户信息",
						lang:"zh_CN",
						success:info=>{
							if(this.login_timestamp>new Date().getTime()){
								this.$u.post('app/index.php',{
									do:"me_getuserinfo",
									code:this.login_code,
									rawData:info.rawData,
									signature:info.signature,
									iv:info.iv,
									encryptedData:info.encryptedData
								}).then(res=>{
									this.userinfo = res
								})
								this.mp_get_logincode()
							} else {
								uni.login({
									success: (x) => {
										this.$u.post('app/index.php',{
											do:"me_getuserinfo",
											code:x.code,
											rawData:info.rawData,
											signature:info.signature,
											iv:info.iv,
											encryptedData:info.encryptedData
										}).then(res=>{
											this.userinfo = res
										})
									}
								})
							}
						},
						fail:err=>{
							console.log(err)
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
			
			// #ifdef MP-WEIXIN || MP-QQ
				mp_get_logincode(e){//刷新data里的code时效
					uni.login({
						success: (res) => {
							this.login_timestamp = new Date().getTime()+(5*60*1000)
							this.login_code = res.code
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
	.list_box{
		width: 100%;
		background-color: #FFFFFF;
		border-radius: 20rpx;
		overflow: hidden;
		box-shadow:1rpx 1rpx 18rpx 1rpx rgba(#999999,0.47);
		.item{
			background-color: #FFFFFF;
			height: 100rpx;
			display: flex;
			justify-content: space-between;
			align-items: center;
			padding-left: 20rpx;
			padding-right: 20rpx;
			&:active{
				background-color: #f2f2f2;
			}
			.left{
				display: flex;
				align-items: center;
			}
			.right{}
		}
	}
</style>
