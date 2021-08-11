<template>
	<view class="chenyu_page" style="display: flex;flex-direction: column;align-items: center;">
		<block v-if="list!=null">
			<u-gap height="50"></u-gap>
			<image class="logo" :src="list.w.current_module.logo" />
			<u-gap height="50"></u-gap>
		</block>
		<!-- #ifdef H5 -->
		<chenyu-jssdkapi></chenyu-jssdkapi>
		<!-- #endif -->
		
		<u-tabbar :icon-size="60" :height="120" :border-top="true"  activeColor="#418BC9" :list="vuex_tabbar" />
	</view>
</template>

<script>
	const app = getApp()
	export default {
		data() {
			return {
				list: null,
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
				do:'index',
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
	.logo{
		width: 200rpx;
		height: 200rpx;
	}
	.content{
		margin-left: 36rpx;
		margin-right: 36rpx;
		font-size: 34rpx;
		color: #8f8f94;
	}
</style>