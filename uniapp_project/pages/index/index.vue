<template>
	<view class="page_box">
		<u-gap height="100" />
		<image class="logo" :src="list.w.current_module.logo" />
		<u-gap height="50" />
		<view class="content">
			<text class="title">{{list.w.current_module.description}}</text>
		</view>
		<u-tabbar :height="100" activeColor="#0071FE" :list="vuex_tabbar" />
	</view>
</template>

<script>
	export default {
		data() {
			return {
				list: {}
			}
		},
		computed:{
			vuex_tabbar(){
				return this.$store.state.vuex_tabbar
			}
		},
		onLoad(options) {
			//直接共用request，充分利用ifdef,样例中特意把h5版本和其他版本做了方法不同的区分。
			//在实际使用中，全平台的方法名大多都是统一的，所以在写逻辑代码的时候，甚至都不需要区分平台方法
			//！！！注意在config,siteinfo配置中详细配置区分！！！
			this.$u.post('',{//直接使用uview的封装方法来调用
				// #ifdef MP-WEIXIN || MP-ALIPAY || MP-TOUTIAO || APP-PLUS
					do:'test',
				// #endif
				// #ifdef H5
					do:'index',
				// #endif
			}).then(res=>{
				this.list = res
			})
		},
		onShow(){},
		methods: {}
	}
</script>

<style lang="scss">
.page_box {
	display: flex;
	flex-direction: column;
	align-items: center;
	justify-content: center;
	.logo{
		width: 200rpx;
		height: 200rpx;
	}
	.content{
		padding-left: 36rpx;
		padding-right: 36rpx;
		.title {
			font-size: 34rpx;
			color: #8f8f94;
		}
	}
}
</style>
