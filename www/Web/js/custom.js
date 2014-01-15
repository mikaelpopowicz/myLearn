$(document).ready(function() {
	$('.datatable').dataTable({
		"sPaginationType": "bs_normal",
		"aoColumnDefs": [
		      { "bSortable": false, "aTargets": [ 0 ] }
		]
	});
	
	
	$('span.help-block').parents('div.form-group').addClass('has-error');
})
