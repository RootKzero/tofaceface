// OTHERS
function trim ( cadena )
{
	return cadena.replace(/^\s+/g,'').replace(/\s+$/g,'')
}
jQuery.fn.reset = function () 
{
	$(this).each (function() { this.reset(); });
}
//** FILTERS **//
var filter     = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
var param_usr  = /^[a-zA-Z0-9\_]+$/;
var param_pass = /^[a-zA-Z0-9]+$/i;

$(document).ready(function(){

 /*=============== Add Post ===================*/	
			$('#button_add').click(function(s){
				
				s.preventDefault();
				
				var _this      = $(this);
				var error      = false;
				var _add_post  = $('#add_post').val();
				var video_link = $('#video_link').val();
				var song_link  = $('#song_link').val();
				var photo      = $('#photoId').val();
				var _title     = _this.attr('data-title');
				var saveHtml   = _this.html();
			 	var _wait      = '...';
			 	var _saveHtml  = saveHtml + _wait;

				if( trim( _add_post ).length  == 0 
					&& video_link.length == 0 
					&& photo.length == 0 
					&& song_link == 0
				) {
					var error = true;
					return false;
				}

				if( error == false ){
					$('#button_add').attr({'disabled' : 'true'}).html(_saveHtml).css({'opacity':'0.5','cursor':'default'});
					$('#add_post').attr({'disabled' : 'true'}).css({'opacity':'0.5'});
					$('#upload').attr({'disabled' : 'true'});
					$('.file-btn').css({'opacity':'0.5'});
					
					$.post("public/ajax/addPost.php", { add_post: _add_post, video: video_link, song: song_link, photoId : photo }, function(msg) {
						
						if( msg.length > 0 && !_this.hasClass('post-user-profile') ) {
							$(msg).hide().prependTo('ul.posts').fadeIn(2000);
							 //$('.popout').html('Published successfully').fadeIn().delay(3000).fadeOut();
							 $("#form_add_post").reset();
							 $('#button_add').html(saveHtml).css({'cursor':'default'});
							 $('#add_post').removeAttr('disabled').css({'opacity': 1});
							 $('#upload').removeAttr('disabled');
							 $('.file-btn').css({'opacity':1});
							 $('#video_link, #song_link').fadeOut();
							 $('#loader_gif, .notfound').remove();
							 $('#wrapper_preview, #container_preview').fadeOut(500);
							 $('#photoId').val('');
							 $('#add_post').height('30px');
							 jQuery("span.timeAgo").timeago();
							  
						} else if( msg.length > 0 && _this.hasClass('post-user-profile') ) {
							
							 $('.popout').html(_title).fadeIn().delay( 3000 ).fadeOut();
							 $("#form_add_post").reset();
							 $('#button_add').html(saveHtml).css({'cursor':'default'});
							 $('#add_post').removeAttr('disabled').css({'opacity': 1});
							 $('#upload').removeAttr('disabled');
							 $('.file-btn').css({'opacity':1});
							 $('#video_link, #song_link').fadeOut();
							 $('#loader_gif, .notfound').remove();
							 $('#wrapper_preview, #container_preview').fadeOut(500);
							 $('#photoId').val('');
							 $('#add_post').height('30px');
							 jQuery("span.timeAgo").timeago();
							
						}
						else {
							 $('#wrapper_preview, #container_preview').fadeIn(500);
							 $('#container_preview').html('');
							 $('<div class="error_div">Error</div>').appendTo( '#container_preview' );
							 $("#form_add_post").reset();
							 $('#button_add').html(saveHtml);
							 $('#add_post').removeAttr('disabled').css({'opacity': 1});
							 $('#upload').removeAttr('disabled');
							 $('.file-btn').css({'opacity':1});
							 $('#loader_gif').remove();
							 $('#photoId').val('');
							 
						}//<-- ELSE
					});//<-- END DE $POST AJAX
				}//<-- END ERROR == FALSE
			});//<-- END FUNCTION CLICK
});// <=========================== END DOCUMENT READY ADD POST ======================================>