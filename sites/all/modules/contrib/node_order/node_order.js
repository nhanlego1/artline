var $ = jQuery.noConflict();

$(document).ready(function(){
	initDraggable();
});

function initDraggable() {
	if($('#node-order-content-by-type table.sticky-enabled').get(0)) {
		var $table = $('#node-order-content-by-type table.sticky-enabled');
		$table.find('thead tr').prepend('<th></th>');
		$table.find('tbody tr')
		.prepend('<td class="handle"><a class="tabledrag-handle" href="#" title="Drag to re-order"><div class="handle">&nbsp;</div></a></td>')
		.addClass('draggable');
		$('#node-order-content-by-type table.sticky-enabled').tableDnD({
			onDrop: function(table, row) {
				var rows = table.rows;
				//alert(rows.length);
				for (var i=rows.length-1; i>=0; i--) {
					$table.find('tbody div.weight-selector select:eq('+i+')').val(i);			
				}
				if(!$('span.tabledrag-changed').get(0)) {
					$('#node-order-content-by-type table.sticky-enabled').before('<div class="messages warning" style="display: block;"><span class="warning tabledrag-changed">*</span> Weights will not be saved until the form is submitted.</div>');
				}
			},
			dragHandle: "handle"
		});
	}
}