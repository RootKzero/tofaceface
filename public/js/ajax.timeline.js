//<----- TimeLine
function TimeLine() {	
	
	var param     = /^[0-9]+$/i;
	var _FirstId  = $('li.hoverList:first').attr('data');
	var _list     = $('.content').html();
	
	if( !param.test( _FirstId ) ) {
		return false;
	}
	
	if( _list != '' ) {
		
		//****** COUNT DATA
		$.get("public/ajax/timeline.php", { since_id:_FirstId }, function( res ) {	
		if ( res ) {
			
			if( res.total != 0 ) {
				$('.news_post').html( res.total + ' ' + res.html ).fadeIn();
			}
		   }//<-- DATA
	     	
		},'json');
	}//<<<--- _list != '
}//End Function TimeLine

//******* SHOW POSTS CLICK
$('.news_post').live('click',function(e){ 
    
    var param     = /^[0-9]+$/i;
	var _FirstId  = $('li.hoverList:first').attr('data');
	
	if( !param.test( _FirstId ) ) {
		return false;
	}
	
	$('.news_post').fadeOut( 1 ).html(''); 
	
	$.get("public/ajax/timeline.php", { since_id:_FirstId }, function( data ) { 
		if ( data ) { 
			var total_data = data.posts.length; 
			
			for( var i = 0; i < total_data; ++i ) { 
				$( data.posts[i] ).hide().prependTo( '.posts' ).fadeIn( 500 ); 
				} 
				jQuery("span.timeAgo").timeago(); 
				}//<-- DATA 
			},'json'); 
		});
		
timer = setInterval("TimeLine()", 5000);