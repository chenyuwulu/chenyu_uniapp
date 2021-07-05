<template>
	<!-- 更新日志页面 -->
	<view class="chenyu_page" style="padding-left: 40rpx;padding-top: 40rpx;">
		<u-time-line>
			<u-time-line-item v-for="(item,index) in list" :key="index">
				<template v-slot:node>
					<u-icon name="bell-fill" :color="index==0?'#1AA034':'#969696'" :size="40"></u-icon>
				</template>
				<template v-slot:content>
					<view class="chenyu_card">
						<view class="u-order-title" :style="{
							color:index==0?'#000000':'',
						}">{{item.title}}</view>
						<view class="u-order-desc" :style="{
							color:index==0?'#000000':'',
						}">
							<view class="text" v-for="(items,idx) in item.content" :key="idx">
								{{items}}
							</view>
						</view>
						<view class="u-order-time">{{item.time}}</view>
					</view>
				</template>
			</u-time-line-item>
		</u-time-line>
	</view>
</template>

<script>
	import {log} from "@/pages/subPackages/setting/common/log.js"
	const app = getApp()
	export default {
		//声明引用组件
		components:{},
		data() {
			return {
				list:log
			}
		},
		//计算属性
		computed:{},
		//检测属性
		watch:{},
		onReady() {},
		onShow() {},
		onLoad(options) {},
		onHide() {},
		methods:{
			
		}
	}
</script>

<style lang="scss">
	.u-order-title {
		color: #c8c8c8;
		font-weight: bold;
		font-size: 30rpx;
	}
	.u-order-desc {
		margin-top: 20rpx;
		color: #969696;
		font-size: 30rpx;
		.text{
			margin-top: 20rpx;
		}
	}
	.u-order-time {
		margin-top: 20rpx;
		color: #c8c8c8;
		font-size: 26rpx;
	}
</style>
