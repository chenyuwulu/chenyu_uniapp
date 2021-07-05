<template>
	<view class="chenyu_page" style="display: flex;flex-direction: column;align-items: center;">
		<block v-if="list!=null">
			<u-gap height="50"></u-gap>
			<image class="logo" :src="list.w.current_module.logo" />
			<u-gap height="50"></u-gap>
		</block>
		<!-- #ifdef H5 -->
		<view style="margin-left: 36rpx;margin-right: 36rpx;">
			<u-collapse :item-style="{border: '2rpx solid rgb(230, 230, 230)',padding: '0 8rpx'}">
				<u-collapse-item title="微信jssdk和uniapp自身api的差别展示" :open="false">
					<u-table>
						<u-tr><!-- 标题 -->
							<u-th>jssdk-api</u-th>
							<u-th>uniapp-api</u-th>
						</u-tr>
						<u-tr><!-- 分享给朋友 -->
							<u-td><u-button size="mini" @click="share_friend">分享给朋友</u-button></u-td>
							<u-td><u-button size="mini" disabled>无</u-button></u-td>
						</u-tr>
						<u-tr><!-- 分享给朋友圈 -->
							<u-td><u-button size="mini" @click="share_friend">分享给朋友圈</u-button></u-td>
							<u-td><u-button size="mini" disabled>无</u-button></u-td>
						</u-tr>
						<u-tr><!-- 选择图片 -->
							<u-td><u-button size="mini" @click="chooseImage">选择图片</u-button></u-td>
							<u-td><u-button size="mini" @click="unichooseImage">选择图片</u-button></u-td>
						</u-tr>
						<u-tr><!-- 查看图片 -->
							<u-td><u-button size="mini" @click="previewImage">查看图片</u-button></u-td>
							<u-td><u-button size="mini" @click="unipreviewImage">查看图片</u-button></u-td>
						</u-tr>
						<u-tr><!-- 获取网络状态 -->
							<u-td><u-button size="mini" @click="getNetworkType">获取网络状态</u-button></u-td>
							<u-td><u-button size="mini" @click="unigetNetworkType">获取网络状态</u-button></u-td>
						</u-tr>
						<u-tr><!-- 扫码 -->
							<u-td><u-button size="mini" @click="scan">扫码</u-button></u-td>
							<u-td><u-button size="mini" disabled>无</u-button></u-td>
						</u-tr>
						<u-tr><!-- 查看地图 -->
							<u-td><u-button size="mini" @click="openLocation">查看地图</u-button></u-td>
							<u-td><u-button size="mini" @click="uniopenLocation">查看地图</u-button></u-td>
						</u-tr>
						<u-tr><!-- 定位 -->
							<u-td><u-button size="mini" @click="getlocation">获取定位</u-button></u-td>
							<u-td><u-button size="mini" @click="unigetlocation">获取定位</u-button></u-td>
						</u-tr>
						<u-tr><!-- 关闭 -->
							<u-td><u-button size="mini" @click="closeWindow">关闭当前网页</u-button></u-td>
							<u-td><u-button size="mini" disabled>无</u-button></u-td>
						</u-tr>
					</u-table>
					<view>关于没有展示低功耗蓝牙和录音，我的建议是不要在网页去实现这个功能。</view>
					<view>有过多不可控因素，引导用户去小程序或APP更好把控。</view>
					<u-gap height="120"></u-gap>
				</u-collapse-item>
			</u-collapse>
		</view>
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
			showtoast(text){
				uni.showToast({
					title: text,
					icon:'none',
					duration: 2000,
					success: () => {}
				})
			},
			showModal(text){
				uni.showModal({
					title:"内容",
					content:text,
					showCancel:false
				})
			},
			// #ifdef H5
			share_friend(){//分享给朋友
				this.$store.state.jssdk.updateAppMessageShareData({
					title: '这里是标题', // 分享标题
					desc: '这里是描述', // 分享描述
					link: 'https://weiqing.chenyuwulu.top/app/index.php?i=10&c=entry&do=entry&m=chenyu_uniapp', // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
					imgUrl: 'https://weiqing.chenyuwulu.top/addons/chenyu_uniapp/icon.jpg', // 分享图标
					success:()=>{
						this.showtoast("设置成功")
					}
				})
			},
			share_friends_circle(){//分享给朋友圈
				this.$store.state.jssdk.updateTimelineShareData({
					title: '这里是标题', // 分享标题
					link: 'https://weiqing.chenyuwulu.top/app/index.php?i=10&c=entry&do=entry&m=chenyu_uniapp', // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
					imgUrl: 'https://weiqing.chenyuwulu.top/addons/chenyu_uniapp/icon.jpg', // 分享图标
					success:()=>{
						this.showtoast("设置成功")
					}
				})
			},
			chooseImage(){//选择图片
				this.$store.state.jssdk.chooseImage({
					count: 9, // 默认9
					sizeType: ['original', 'compressed'], // 可以指定是原图还是压缩图，默认二者都有
					sourceType: ['album', 'camera'], // 可以指定来源是相册还是相机，默认二者都有
					success: (res)=> {
						this.showModal(JSON.stringify(res))
					}
				})
			},
			unichooseImage(){//uni选择图片
				uni.chooseImage({
					count: 9, //默认9
					sizeType: ['original', 'compressed'], //可以指定是原图还是压缩图，默认二者都有
					sourceType: ['album','camera'], //从相册选择
					success: (res)=>{
						this.showModal(JSON.stringify(res))
					}
				})
			},
			previewImage(){//预览图片
				this.$store.state.jssdk.previewImage({
					current: 'https://cn.bing.com/th?id=OHR.SerraMalagueta_ZH-CN4592152973_1920x1080.jpg', // 当前显示图片的http链接
					urls: [
						"https://cn.bing.com/th?id=OHR.SerraMalagueta_ZH-CN4592152973_1920x1080.jpg",
						"https://cn.bing.com/th?id=OHR.LakeSchreckseeBY_ZH-CN0786328970_1920x1080.jpg",
						"https://cn.bing.com/th?id=OHR.WakatobiNP_ZH-CN0672859436_1920x1080.jpg"
					] // 需要预览的图片http链接列表
				})
			},
			unipreviewImage(){//uni预览图片
				uni.previewImage({
					current:"https://cn.bing.com/th?id=OHR.SerraMalagueta_ZH-CN4592152973_1920x1080.jpg",
					urls: [
						"https://cn.bing.com/th?id=OHR.SerraMalagueta_ZH-CN4592152973_1920x1080.jpg",
						"https://cn.bing.com/th?id=OHR.LakeSchreckseeBY_ZH-CN0786328970_1920x1080.jpg",
						"https://cn.bing.com/th?id=OHR.WakatobiNP_ZH-CN0672859436_1920x1080.jpg"
					] // 需要预览的图片http链接列表
				})
			},
			getNetworkType(){//获取网络状态
				this.$store.state.jssdk.getNetworkType({
				  success: (res)=> {
				    this.showModal(JSON.stringify(res))
				  }
				})
			},
			unigetNetworkType(){//uni获取网络状态
				uni.getNetworkType({
					success: (res)=> {
						this.showModal(JSON.stringify(res))
					}
				})
			},
			scan(){//扫码
				this.$store.state.jssdk.scanQRCode({
					needResult: 1, // 默认为0，扫描结果由微信处理，1则直接返回扫描结果，
					scanType: ["qrCode","barCode"], // 可以指定扫二维码还是一维码，默认二者都有
					success:(res)=>{
						this.showModal(res.resultStr)
					}
				})
			},
			openLocation(){//查看地图
				this.$store.state.jssdk.openLocation({
				  latitude: 31.11325, // 纬度，浮点数，范围为90 ~ -90
				  longitude: 121.38206, // 经度，浮点数，范围为180 ~ -180。
				  name: '', // 位置名
				  address: '', // 地址详情说明
				  scale: 28, // 地图缩放级别,整型值,范围从1~28。默认为最大
				  infoUrl: '' // 在查看位置界面底部显示的超链接,可点击跳转
				})
			},
			uniopenLocation(){//uni查看地图
				uni.openLocation({
					latitude: 31.11325,
					longitude: 121.38206,
					success: ()=>{}
				});
			},
			getlocation(){//定位
				this.$store.state.jssdk.getLocation({
					type: 'wgs84', // 默认为wgs84的gps坐标，如果要返回直接给openLocation用的火星坐标，可传入'gcj02'
					success: (res)=>{
						this.showModal(JSON.stringify(res))
					}
				})
			},
			unigetlocation(){//uni定位
				uni.getLocation({
					type:"wgs84",
					success: (res) => {
						this.showModal(JSON.stringify(res))
					}
				})
			},
			closeWindow(){
				this.$store.state.jssdk.closeWindow()
			},
			// #endif
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