<div class='visitor-box'>
</div>
<div class='side-pull-box'>
	<div class='side-pull-wrap'>
		<span id='sidepull-btn' class="fa fa-angle-double-right" aria-hidden="true"></span>
	</div>
</div>
<script>
$('.side-pull-box').click(function () {
	if($(this).css("margin-left") == "0px")
    {
        $('.visitor-box').animate({"margin-left": '0%'});
        $('.side-pull-box').animate({"margin-left": '10%'});
    }
    else
    {
        $('.visitor-box').animate({"margin-left": '-10%'});
        $('.side-pull-box').animate({"margin-left": '0px'});
    }
	$('#sidepull-btn').toggleClass(" fa-angle-double-left fa-angle-double-right");
});

</script>