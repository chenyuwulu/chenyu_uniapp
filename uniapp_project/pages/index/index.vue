<template>
	<view class="chenyu_page page_box" v-if="list!=null">
		<u-gap height="50"></u-gap>
		<image class="logo" :src="list.w.current_module.logo" />
		<u-gap height="50" />
		<view class="content">
			<text class="title">{{list.w.current_module.description}}</text>
		</view>
		<u-tabbar :height="100" activeColor="#418BC9" :list="vuex_tabbar" />
	</view>
</template>

<script>
	export default {
		data() {
			return {
				list: null
			}
		},
		watch:{},
		computed:{
			vuex_tabbar(){//这是底部tabbar
				return this.$store.state.vuex_tabbar
			}
		},
		onLoad(options) {
			this.$u.post('app/index.php',{//直接使用uview的封装方法来调用
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
		onHide(){},
		onUnload(){},
		methods: {
			
		}
	}
</script>

<style lang="scss">
.page_box {
	align-items: center;
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
