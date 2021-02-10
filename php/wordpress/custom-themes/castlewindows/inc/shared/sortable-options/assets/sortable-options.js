/**
 * OptionTree Sortable options
 */

"use strict";

jQuery(document).ready(function($) {

	var	fieldId;

	if ( typeof screenSortableOptions == 'undefined' )
		return;

	for ( fieldId in screenSortableOptions ) {
		if ( !screenSortableOptions.hasOwnProperty(fieldId) )
			continue;

		( function( fieldId ) {
			$('#setting_'+fieldId).map(function() {
				var setting = $(this),
					fields = setting.find('.format-setting-inner');

				// Reorder inner elements by id
				if ( screenSortableOptions[fieldId] ) {

					// Get all checked fields by ids
					for (var i = screenSortableOptions[fieldId].length-1; i >= 0; i--) {
						fields.prepend( setting.find('p:has(#'+fieldId+'-'+screenSortableOptions[fieldId][i]+')') );
					};
				}

				fields.sortable({
					placeholder: 'sortable-placeholder',
					handle: 'label',
					cursor: 'move',
					opacity: 0.65
				});
			
			});
		} )( fieldId );
		
	};	

});