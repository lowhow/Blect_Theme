window.onload = function() {
	var url = new URL(window.location.href);
	var c = url.searchParams.get("lang");
	if (c !== null){
		document.body.classList.add( 'lang-' + c );
	}
};
