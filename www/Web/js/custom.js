$(document).ready(function() {
	$('.datatable').dataTable({
		"aoColumnDefs": [
		      { "bSortable": false, "aTargets": [ 0 ] }
		]
	});

	$('.selectpicker').selectpicker();

	$('#check_all').click(function () {
		var cases = $('#tabs').find('input[type=checkbox]');
		$(cases).prop('checked', this.checked);
	});
	
	
	$('span.help-block').parents('div.form-group').addClass('has-error');
})
