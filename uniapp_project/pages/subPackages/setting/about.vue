<template>
	<!-- 关于页面 -->
	<view v-if="w" class="chenyu_page" style="padding-left: 20rpx;padding-right: 20rpx;display: flex;flex-direction: column;align-items: center;">
		<u-gap height="100"></u-gap>
		<image style="width: 200rpx;height: 200rpx;" :src="w.current_module.logo" />
		<u-gap height="20"></u-gap>
		<view class="title">
			{{w.current_module.title}}
		</view>
		<view class="content">
			<view class="text">
				{{w.current_module.description}}
			</view>
		</view>
		<u-gap height="50"></u-gap>
		<!-- #ifdef MP-WEIXIN -->
			<view class="content" style="width: 100%;">
				本项目所使用的组件库：
				<view class="open_button_list">
					<u-button
						shape="square"
						size="default"
						:ripple="true"
						type="primary"
						@click="go_to_mp(uview_appid)"
						>uview</u-button>
					<u-button
						shape="square"
						size="default"
						:ripple="true"
						type="primary"
						@click="go_to_mp(uniui_appid)"
					>uni-ui</u-button>
					<u-button
						shape="square"
						size="default"
						:ripple="true"
						type="primary"
						@click="go_to_mp(thorui_appid)"
					>thorui</u-button>
				</view>
			</view>
		<!-- #endif -->
	</view>
</template>

<script>
	const app = getApp()
	export default {
		//声明引用组件
		components:{},
		data() {
			return {
				// #ifdef MP-WEIXIN
				uview_appid:"wxc256e348c4032ebd",
				uniui_appid:"wx999bf02c8e05dfc9",
				thorui_appid:"wxb6a98ca343f57a38",
				// #endif
				
				// #ifdef MP-QQ
				uview_appid:"",
				uniui_appid:"1109689877",
				thorui_appid:"1109627073",
				// #endif
				w:false,
			}
		},
		//计算属性
		computed:{},
		//检测属性
		watch:{},
		onReady() {},
		onShow() {},
		onLoad(options) {
			this.$u.post('app/index.php',{
				do:'index',
			}).then(res=>{
				this.w = res.w
			})
		},
		onHide() {},
		methods:{
			go_to_mp(appid){
				uni.navigateToMiniProgram({
				  appId: appid
				})
			}
		}
	}
</script>

<style lang="scss">
	.title{
		color: #000000;
		font-size: 35rpx;
		font-weight: bold;
		text-align: center;
		height: 100rpx;
		line-height: 100rpx;
	}
	.content{
		padding: 30rpx 30rpx;
		background-color: #FFFFFF;
		border-radius: 20rpx;
		box-shadow:1rpx 1rpx 18rpx 1rpx rgba(#999999,0.47);
		display: flex;
		flex-direction: column;
		.text{
			color: #000000;
			font-size: 30rpx;
			text-indent:2em;
		}
		.open_button_list{
			padding-top: 20rpx;
			padding-bottom: 20rpx;
			display: flex;
			flex-direction: row;
			justify-content: space-around;
		}
	}
</style>
