var settings_admin_tables,
	Admin_Tables = (function( jQ ){


var table_name = "";
var table_rows = "";


jQ(document).ready(function(){
	init();
});
	

function init()
{
	bindUIEvents();
}

function bindUIEvents()
{
}

function newTable( table_name , data, settings, rowdata )
{	
	if( table_name )
	{

		var el_table = '<table id="'+ table_name +'" class="dwh-datatable display hover cell-border" cellspacing="0" width="100%">\
						<thead>';

						if( data )
						{		
							el_table += addHeaders( settings );
						}

						el_table += '</thead>\
									 <tbody>';

						if( data )
						{		
							el_table += addRows( settings, rowdata );
						}

						el_table +=	'</tbody>\
									 </table>';
		
		
		return el_table;

	}	

	
}

function addHeaders( settings )
{
	if( settings  )
	{	
		/* Table rows with data */
		var el_table = '<tr>';

			jQ.each( settings , function( key , val ){
				
				var data_set = val;
				
				if( key != 'dwh_hotels_id' ){
					
					jQ.each( data_set , function( set_key , set_val ){
						el_table += '<th>'+ set_val.field_title +'</th>';
					});
				}
				
				
			});

		el_table += '</tr>';
		
		return el_table;

	}

}

function addRows( settings, data )
{
	if( settings && data  )
	{	
		/* Table rows with data */
		var el_table = '';
		
				jQ.each( data , function( key , val ){
					
					el_table += '<tr option_row="'+ key +'">';
					
						var data_set = val;

						jQ.each( settings, function( set_key, set_val ){
							
							if( set_key != 'dwh_hotels_id' ){

								var data_value = '';
								jQ.each( data_set , function( data_key , data_val ){
									if( set_key == data_key ){
										if( data_val ){
											data_value = data_val;
										}else{
											data_value = '';
										}
									}
									
								});
								
								el_table += '<td>'+ data_value +'</td>';
							}
						});
						
					el_table += '</tr>';
					
				});

		return el_table;

	}						   

}


return {

		'init' 						: init,
		'settings_admin_tables' 	: settings_admin_tables,
	 	'bindUIEvents' 				: bindUIEvents,
	 	'newTable'					: newTable,
		'addHeaders'				: addHeaders,
		'addRows'					: addRows

		};


})( jQuery );