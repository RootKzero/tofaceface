function TimeLine() {	
	var param    = /^[0-9]+$/i;
	var _FirstId = $('li.hoverList:first').attr('data');
	var _query   = $('#query_data').attr('data-query');
	var _list    = $('.content').html();
	
	if( !param.test( _FirstId ) ) {
		return false;
	}
	
	if( _list != '' ) {
		$.get("public/ajax/ajax.timeline.php", { since_id:_FirstId, query: _query }, function( data ){	
		if ( data ) {
			
			if( data.total != 0 ) {
				$('.news_post').html( data.total + ' ' + data.html ).fadeIn();
			}
				
		   }//<-- DATA
	     	
		},'json');
	}//<<<-- IF _LIST
		
}//End Function TimeLine

//******* SHOW POSTS CLICK
$('.news_post').live('click',function(e){ 
    
    var param     = /^[0-9]+$/i;
	var _FirstId  = $('li.hoverList:first').attr('data');
	var _query   = $('#query_data').attr('data-query');
	
	if( !param.test( _FirstId ) ) {
		return false;
	}
	
	$('.news_post').fadeOut( 1 ).html(''); 
	
	$.get("public/ajax/ajax.timeline.php", { since_id:_FirstId, query: _query }, function( res ) { 
		if ( res ) { 
			var total_data = res.posts.length; 
			
			for( var i = 0; i < total_data; ++i ) { 
				$( res.posts[i] ).hide().prependTo( '.posts' ).fadeIn( 900 ); 
				} 
				jQuery("span.timeAgo").timeago(); 
				}//<-- DATA 
			},'json'); 
		});
		
timer = setInterval("TimeLine()", 10000);
