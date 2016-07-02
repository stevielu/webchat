<div class='visitor-box'>
</div>
<div class='side-pull-box'>
	<div class='side-pull-wrap'>
		<span id='sidepull-btn' class="fa fa-angle-double-right" aria-hidden="true"></span>
	</div>
</div>
<script>
$('.side-pull-wrap').click(function () {
	$('.visitor-box').toggle('slide', {
            direction: 'left'
        }, 1000);
	$('#sidepull-btn').toggleClass(" fa-angle-double-left fa-angle-double-right");
});

</script>