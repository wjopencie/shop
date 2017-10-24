<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Highcharts Example</title>

	</head>
	<body>
<script src="<?=ROOT?>Admin/view/Highcharts6/code/highcharts.js"></script>
<script src="<?=ROOT?>Admin/view/Highcharts6/code/modules/exporting.js"></script>

<button onclick="chk(this.innerText)">点击生成商品价格分析图表</button>
<script type="text/javascript">

    function chk(data) {

        $.post("<?=BASE_URL?>/Admin/Index/pie",{d:data},function (msg) {
            var json = {
                chart: {
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false,
                    type: 'pie'
                },
                title: {text: data },
                tooltip: {pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'},
                plotOptions: { pie: {allowPointSelect: true, cursor: 'pointer',
                    dataLabels: { enabled: true,format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                        style: {color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'}
                    }
                }
                },
                series: [{
                    name: 'Brands',colorByPoint: true,
                    data: []
                }]
            };
            json.series[0].data = msg;
            Highcharts.chart('container', json);
        },"json");
    }
</script>
<div id="container" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto"></div>
<script type="text/javascript" src="<?=ROOT?>public/js/jquery-1.7.2.min.js"></script>

	</body>
</html>
