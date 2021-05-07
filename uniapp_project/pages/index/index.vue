<template>
	<view class="chenyu_page page_box" >
		<block v-if="list!=null">
			<u-gap height="50"></u-gap>
			<image class="logo" :src="list.w.current_module.logo" />
			<u-gap height="50" />
			<view class="content">
				<text class="title">{{list.w.current_module.description}}</text>
			</view>
		</block>
		<u-button @click="scan">扫码</u-button>
		<u-button @click="getlocation">获取坐标jssdk版</u-button>
		<u-button @click="unigetlocation">获取坐标uniapi版</u-button>
		<u-tabbar :icon-size="60" :height="120" :border-top="true"  activeColor="#418BC9" :list="vuex_tabbar" />
	</view>
</template>

<script>
	let jssdk = require("@/common/wx_jssdk.js")
	const app = getApp()
	export default {
		data() {
			return {
				list: null,
				latitude:0
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
			this.$u.post('app/index.php',{
				do:'weixin_jssdk',
				url:"https://weiqing.chenyuwulu.top/addons/chenyu_uniapp/template/mobile/h5/"
			}).then(res=>{
				jssdk.config({
						debug: false, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。  
						appId: res.jssdk.appId, // 必填，公众号的唯一标识  
						timestamp: res.jssdk.timestamp, // 必填，生成签名的时间戳  
						nonceStr: res.jssdk.nonceStr, // 必填，生成签名的随机串  
						signature: res.jssdk.signature, // 必填，签名，见附录1  
						jsApiList: ["scanQRCode"]
				})
			})
		},
		onShow(){},
		onHide(){},
		onUnload(){},
		methods: {
			// #ifdef H5
			scan(){//微信公众号调起扫码
				jssdk.ready(()=>{
					jssdk.scanQRCode({
						needResult: 1, // 默认为0，扫描结果由微信处理，1则直接返回扫描结果，
						scanType: ["qrCode","barCode"], // 可以指定扫二维码还是一维码，默认二者都有
						success:(ress)=>{
							uni.showModal({
								title:"内容",
								content:ress.resultStr,
								showCancel:false
							})
						}
					})
				})
			},
			getlocation(){
				jssdk.ready(()=>{
					jssdk.getLocation({
					  type: 'wgs84', // 默认为wgs84的gps坐标，如果要返回直接给openLocation用的火星坐标，可传入'gcj02'
					  success: (res)=>{
							uni.showModal({
								title:"内容",
								content:JSON.stringify(res),
								showCancel:false
							})
					  }
					})
				})
			},
			unigetlocation(){
				uni.getLocation({
					type:"wgs84",
					success: (ress) => {
						console.log(ress)
						this.latitude = ress.latitude
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
