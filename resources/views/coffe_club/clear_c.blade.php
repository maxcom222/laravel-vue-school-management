<script>
$(document).ready(function(e) {
    lscache.flush();
	type = lscache.get('init_choice');
	document.write('<h1>You cache is gone</h1>');
	console.log(type);
});
</script>