# v1.0转v2.0注意事项
1、opts.colors变更为opts.color
2、ring圆环图的扩展配置由extra.pie变更为extra.ring
3、混合图借用的扩展配置由extra.column变更为extra.mix.column
4、全部涉及到format的格式化属性变更为formatter
5、不需要再传canvasId及$this参数，如果通过uChats获取context，可能会导致this实例混乱，导致小程序开发者工具报错。如果不使用qiun-data-charts官方组件，需要在new uCharts()实例化之前，自行获取canvas的上下文context（ctx），并传入new中的context（opts.context）。为了能跨更多的端，给您带来的不便敬请谅解。