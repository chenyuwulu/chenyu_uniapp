<template>
<view class="content">
	<image class="logo" :src="list.w.current_module.logo"></image>
	<view class="text-area">
		<text class="title">{{list.w.current_module.description}}</text>
	</view>
</view>
</template>

<script>
	const app = getApp()
	export default {
		data() {
			return {
				list: {}
			}
		},
		onLoad() {
			/*
			下面的request访问为了方便区别跨端所以全部区分,
			根据实际情况可以将一样情况的端合并使用同一套代码,无需全部区分各端书写
			*/
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
						this.list = res.data
		       }
		   })
		   // #endif
			// #ifdef MP-WEIXIN
			let app_mp_weixin = app.$vm.$options
			console.log(app_mp_weixin)
			app_mp_weixin.util.request({
				url: 'entry/wxapp/test',
				data: {
					m: 'chenyu_uniapp'
				},
				method: 'post',
				success: (res) => {
						console.log(res)
						this.list = res.data.data
				}
			})
			// #endif
			// #ifdef MP-ALIPAY
			let app_mp_alipay = app.$vm.$options
			console.log(app_mp_alipay)
			uni.request({
			    url: app_mp_alipay.siteInfo.siteroot, //仅为示例，并非真实接口地址。
			    data: {
						i:app_mp_alipay.siteInfo.uniacid,
						// t:0,
						v:app_mp_alipay.siteInfo.version,
						// from:'aliapp',
						c:'entry',
						a:'aliapp',
						m:'chenyu_uniapp',
						do:'test'
			    },
					method:"POST",
			    header: {
						'content-type': 'application/x-www-form-urlencoded' //自定义请求头信息
			    },
			    success: (res) => {
						console.log(res)
						this.list = res.data.data
			    }
			})
			// #endif
			// #ifdef MP-TOUTIAO
			let app_mp_byte = app.$vm.$options
			console.log(app_mp_byte)
			uni.request({
			    url: app_mp_byte.siteInfo.siteroot, //仅为示例，并非真实接口地址。
			    data: {
						i:app_mp_byte.siteInfo.uniacid,
						// t:0,
						v:app_mp_byte.siteInfo.version,
						// from:'aliapp',
						c:'entry',
						a:'toutiaoapp',
						m:'chenyu_uniapp',
						do:'test'
			    },
					method:"POST",
			    header: {
						'content-type': 'application/x-www-form-urlencoded' //自定义请求头信息
			    },
			    success: (res) => {
						console.log(res)
						this.list = res.data.data
			    }
			})
			// #endif
		},
		methods: {
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
