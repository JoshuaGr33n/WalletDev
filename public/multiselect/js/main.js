$(function() {

	$('select[multiple].active.3col').multiselect({
	  columns: 3,
	  placeholder: 'Select Vouchers',
	  search: true,
	  searchOptions: {
	      'default': 'Search Vouchers'
	  },
	  selectAll: true
	});

});