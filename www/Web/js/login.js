$('#connexion').on('submit', function() {
	var pass = $('#passw0rd').val();
	var md = CryptoJS.MD5(pass);
	$('#passw0rd').val(md);
});