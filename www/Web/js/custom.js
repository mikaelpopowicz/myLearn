$(document).ready(function() {
	$('.datatable').dataTable({
		"aoColumnDefs": [
		      { "bSortable": false, "aTargets": [ 0 ] }
		]
	});

	$('.selectpicker').selectpicker();
	
	$('#datepicker').datepicker({
		format: 'dd/mm/yyyy',
		weekStart: 1
	}).on('changeDate', function() {
		$(this).datepicker('hide');
	});

	$('#check_all').click(function () {
		var cases = $('#tabs').find('input[type=checkbox]');
		$(cases).prop('checked', this.checked);
	});
	
	$('#check_all1').click(function () {
		var cases = $('#tabs1').find('input[type=checkbox]');
		$(cases).prop('checked', this.checked);
	});
	
	$('#check_all2').click(function () {
		var cases = $('#tabs2').find('input[type=checkbox]');
		$(cases).prop('checked', this.checked);
	});	
	
	$('span.help-block').parents('div.form-group').addClass('has-error');
})
