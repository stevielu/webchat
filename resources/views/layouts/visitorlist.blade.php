<div class='visitor-box'>
</div>
<div class='side-pull-box'>
	<div class='side-pull-wrap'>
		<span id='sidepull-btn' class="fa fa-angle-double-right" aria-hidden="true"></span>
	</div>
</div>
<script>
$('.side-pull-box').click(function () {
	console.log($('.visitor-box').css("margin-left"));
	if($('.visitor-box').css("margin-left") == "-135px")
    {
        $('.visitor-box').animate({"margin-left": '0'});
        $('.visitor-box').css("display",'inline-block');
    }
    else
    {
        $('.visitor-box').animate({"margin-left": '-135px'});
        $('.visitor-box').css({"display",'none'});
    }
	$('#sidepull-btn').toggleClass(" fa-angle-double-left fa-angle-double-right");
});

</script>