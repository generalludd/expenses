<?php
$data= [];
foreach($totals as $total){
	$data[] = [
		'name'=> $total->name,
		'y'=> abs(round($total->total,2)),
	];
}
?>
<?php if(!empty($data)):?>
<div id="container" style="width:100%; height:400px;"></div>
<script type="text/javascript">
	document.addEventListener('DOMContentLoaded', function () {
		var myChart = Highcharts.chart('container', {
			chart: {
				type: 'pie'
			},
			title: {
				text: "<?php print $title; ?>"
			},
			series: [{
				name: "<?php print $label; ?>",
				colorByPoint: true,
				data: <?php print json_encode($data);?>
			}]
		});
	});
</script>
<?php endif;
