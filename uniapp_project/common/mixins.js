export const public_mixins = {//公共混入区域，影响所有页面
	data(){//公共变量参数
		return{
			
		}
	},
	computed:{//计算属性
		
	},
	onReady(){//页面渲染前执行
		// #ifdef MP-QQ
			uni.showShareMenu({
				showShareItems: ['qq', 'qzone', 'wechatFriends', 'wechatMoment']
			})
		// #endif
	},
	// #ifdef MP-WEIXIN
	onShareAppMessage(res){//微信小程序分享
		if(res.form == "button"){
			console.log("触发了按钮的分享")
		} else {
			console.log("非按钮触发的分享")
		}
	},
	onShareTimeline(){//分享到朋友圈
		console.log("触发了分享朋友圈")
	},
	// #endif
	methods: {
		//这是对已有的uniapp的api做简单使用封装
		navigateTo(url){
			uni.navigateTo({
				url: url
			})
		},
		redirectTo(url){
			uni.redirectTo({
				url: url
			})
		},
		reLaunch(url){
			uni.reLaunch({
				url: url
			})
		},
		switchTab(url){
			uni.switchTab({
				url: url
			})
		},
		navigateBack(delta){
			uni.navigateBack({
				delta: delta
			})
		},
		showtoast(text){
			uni.showToast({
				title: text,
				icon:'none',
				duration: 2000,
				success: () => {
					// setTimeout(()=>{
					// 	uni.hideToast()
					// },2000)
				}
			})
		},
		
		//这是自己写的封装方法或复杂的uniapp的api使用方法
	}
}