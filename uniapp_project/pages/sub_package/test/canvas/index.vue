<template>
	<view class="content">
		<!-- #ifdef MP-ALIPAY -->
		<canvas 
		canvas-id="myCanvas" 
		id="myCanvas"
		:width="pWidth*pixelRatio"
		:height="pWidth*pixelRatio"
		:style="{'width':pWidth+'px','height':pWidth+'px'}"
		style="background: #68ACFD;border-bottom-left-radius: 20rpx;border-bottom-right-radius: 20rpx;">
			
		</canvas>
		<!-- #endif -->
		
	</view>
</template>

<script>
	const app = getApp()
	const ctx = uni.createCanvasContext('myCanvas')
	export default {
		data() {
			return {
				pWidth:app.$vm.$options.globalData.pWidth,
				pixelRatio:app.$vm.$options.globalData.pixelRatio,
			}
		},
		onLoad() {
			this.min_semicircle()
			this.hong_semicircle()
		},
		onReady() {
			uni.setNavigationBarColor({
			    backgroundColor: '#68ACFD',
			})
		},
		onShow(){
			const that = this
		},
		methods: {
			//小虚线圆
			min_semicircle(){
				ctx.save()//保存初始配置，原点是左上角，填充颜色和线段也都是默认
				ctx.translate(this.pWidth, this.pWidth) // 修改XY坐标原点
			
				//绘制大半圆
				ctx.beginPath()
				ctx.setLineCap('round') // 圆角线段端点
				ctx.setLineWidth(30) // 线段粗细
				// ctx.setLineDash([5, 15]);
				const semicircle_color = ctx.createLinearGradient(-(this.pWidth*0.8), 0, this.pWidth*0.8, 0)
				semicircle_color.addColorStop(0, '#FFFFFF')
				semicircle_color.addColorStop(1, '#EBEBEB')
				ctx.arc(0, 0, this.pWidth*0.8, 0, 1 * Math.PI, true)
				ctx.rotate(180 * Math.PI / 180) // 根据圆心进行角度旋转
				ctx.strokeStyle = semicircle_color // 填充线段的颜色
				
				ctx.stroke() // 绘制线段
				ctx.restore()
				ctx.draw(true,this.nei_semicircle())
			},
			//大虚线圆
			big_semicircle(){
				const that = this
				// ctx.save()
				
				// ctx.translate(this.pWidth, this.pWidth) // 修改XY坐标原点
				// ctx.rotate(180 * Math.PI / 180) // 根据圆心进行角度旋转
				
				let x = 0
				let timer = setInterval(function () {
				  x += 1
				  if (x <= 80) {
					  ctx.save()
					  ctx.translate(that.pWidth, that.pWidth) // 修改XY坐标原点
					  ctx.rotate(180 * Math.PI / 180) // 根据圆心进行角度旋转
					//绘制大半圆
					ctx.beginPath()
					ctx.setLineCap('round') // 圆角线段端点
					ctx.setLineWidth(30) // 线段粗细
					// ctx.setLineDash([5, 15]);
					const semicircle_color = ctx.createLinearGradient(-(that.pWidth*0.8), 0, that.pWidth*0.8, 0)
					semicircle_color.addColorStop(0, '#E55554')
					semicircle_color.addColorStop(1, '#7ED321')
					
					ctx.arc(0, 0, that.pWidth*0.8, 0, x * Math.PI/100, false)
					ctx.strokeStyle = semicircle_color // 填充线段的颜色
					
					ctx.stroke() // 绘制线段
					ctx.restore()
					ctx.draw(true)
					
					console.log('if执行的')
				  } else {
					clearInterval(timer)
					console.log('else执行的')
				  }
				}, 50)
			},
			//内阴影圆
			nei_semicircle(){
				ctx.save()
				ctx.translate(this.pWidth, this.pWidth) // 修改XY坐标原点
				const color = ctx.createLinearGradient(0, -(this.pWidth*0.6), 0, this.pWidth*0.6)
				color.addColorStop(0, '#39ACF6')
				color.addColorStop(1, '#2F98FF')
				ctx.beginPath()//创建绘制路径
				ctx.arc(0, 0, this.pWidth*0.6, 0, 2 * Math.PI,true)
				ctx.setFillStyle(color)
				ctx.setShadow(0, 0, 100, '#2E8FF7')
				ctx.fill()
				ctx.restore()
				ctx.draw(true,this.drawSin())
			},
			//红圆
			hong_semicircle(){
				ctx.save()
				ctx.translate(this.pWidth, this.pWidth)
				ctx.beginPath()//创建绘制路径
				ctx.arc(0, 0, 70, 0, 2 * Math.PI)
				ctx.setFillStyle('#ED5E4E')
				ctx.fill()
				ctx.restore()
				ctx.draw(true,this.big_semicircle())
				this.wenzi(80)
			},
			//画个波浪
			drawSin(){
				//range控件信息
				var Range = 0.46;   //用于做一个临时的range
				//画布属性
				var mW = this.pWidth*2;
				var mH = this.pWidth*2;
				//Sin 曲线属性
				var sX = 0;
				var axisLength = mW; //轴长
				var waveWidth = 0.015 ;   //波浪宽度,数越小越宽    
				var waveHeight = 6; //波浪高度,数越大越高
				var speed = 0.09; //波浪速度，数越大速度越快
				var xOffset = 1.9; //波浪x偏移量
				ctx.lineWidth = 1;
				//画sin 曲线函数
				let drawsin = function(xOffset, color, waveHeight){
				    ctx.save();
				    var points=[];  //用于存放绘制Sin曲线的点
				    ctx.beginPath();
				    //在整个轴长上取点
				    for(var x = sX; x < sX + axisLength; x += 20 / axisLength){
				        //此处坐标(x,y)的取点，依靠公式 “振幅高*sin(x*振幅宽 + 振幅偏移量)”
				        var y = Math.sin((-sX - x) * waveWidth + xOffset) * 0.8 + 0.1;
				        var dY = mH * (1 - Range );
				        points.push([x, dY + y * waveHeight]);
				        ctx.lineTo(x, dY + y * waveHeight);     
				    }
				    //封闭路径
				    ctx.lineTo(axisLength, mH);
				    ctx.lineTo(sX, mH);
				    ctx.lineTo(points[0][0],points[0][1]);
				    ctx.fillStyle = color;
				    ctx.fill();
				    ctx.restore();
				};
				// drawSin(xOffset+Math.PI*0.7, 'rgba(28, 134, 209, 0.5)', 20);
				drawsin(xOffset, '#3F8AF4', 20);
			},
			//中间百分比文字
			wenzi(num){
				ctx.save()
				ctx.translate(this.pWidth, this.pWidth) // 修改XY坐标原点
				var size =50;
				ctx.font = size + 'px Microsoft Yahei';
				ctx.textAlign = 'center';
				ctx.textBaseline = 'middle'
				ctx.fillStyle = "#FFFFFF";
				ctx.fillText(~~num + '%', 0, 0); // ~是取反，~~ 的目的是为了保证nowRange是数字
				ctx.restore()
			}
		}
	}
</script>

<style>

</style>
