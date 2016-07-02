<div class='visitor-box col-md-1'>
</div>
<div class='side-pull-box'>
	<div class='side-pull-wrap'>
		<span id='sidepull-btn' class="fa fa-angle-double-right" aria-hidden="true"></span>
	</div>
</div>
<script>
$('.side-pull-wrap').click(function () {
	$('.visitor-box').animate({width: 'toggle'});
	$('#sidepull-btn').toggleClass("fa-angle-double-right fa-angle-double-left");
});

</script>