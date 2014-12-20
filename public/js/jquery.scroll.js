(function($) {

	$.fn.scrollPagination = function(options) {
		
		var settings = { 
			nop     : 10, // The number of posts per scroll to be loaded
			offset  : 0, // Initial offset, begins at 0 in this case
			error   : '', // When the user reaches the end this is the message that is
			                            // displayed. You can change this if you want.
			delay   : 500, // When you scroll down the posts will load after a delayed amount of time.
			               // This is mainly for usability concerns. You can alter this as you see fit
			scroll  : true, // The main bit, if set to false posts will not load as the user scrolls. 
			query   : 0,
			file    : null,
			totalGlobal : 0
			
			               // but will still load if the user clicks.
		}
		
		// Extend the options so they work with the plugin
		if(options) {
			$.extend(settings, options);
		}
		
		// For each so that we keep chainability.
		return this.each(function() {		
			
			// Some variables 
			$this = $(this);
			$settings = settings;
			var offset = $settings.offset;
			var query  = $settings.query;
			var busy = false; // Checks if the scroll action is happening 
			                  // so we don't run it multiple times
			
			// Custom messages based on settings
			if($settings.scroll == true) $initmessage = '';
			else $initmessage = '';
			
			// Append custom messages and extra UI
			$this.append('<div class="content"></div><div class="loading-bar displayLoad"></div><li class="watermark"></li>');
			$this.find('.watermark').css({'display': 'none'});
			
			function getData() {

				// Post data to ajax.php
				$.get('public/ajax/'+$settings.file, {
						
					action        : 'scrollIndex',
				    number        : $settings.nop,
				    offset        : offset,
				    query         : query,
					    
				}, function(data) {
					
					$this.find('.loading-bar').removeClass( 'displayLoad' );
					// Change loading bar content (it may have been altered)
					$this.find('.loading-bar').html($initmessage);
						
					// If there is no data returned, there are no more posts to be shown. Show error
					//$this.find('.loading-bar').html($settings.error);
					if( data.length < 2 ) { 
						$this.find('.loading-bar').remove();
						$('#container-loader').remove();
						$this.find('.watermark').css({'display': 'block'});
												
					}
					else {
						//jAlert( data.length  );
						$this.find('.watermark').css({'display': 'block'});
						$('#container-loader').remove();
						// Offset increases
					    //offset = offset+$settings.nop; 
						    
						// Append the data to the content div
					   	$this.find('.content').append(data);
					   	//<-- * TOTAL LI * -->
						var total   = $('.content > li').length;
						
						if( total < $settings.nop )
						{
							$this.find('.loading-bar').remove();
						}
						jQuery("span.timeAgo").timeago();
						// No longer busy!	
						
						offset = $('li.hoverList:last').attr('data');
						query  = 1;
						
						busy = false;
					}	
						
				});

			}	
			
			getData(); // Run function initially
			
			// If scrolling is enabled
			if($settings.scroll == true) {
				// .. and the user is scrolling
				$(window).scroll(function() {
					
					$('#lightboxOverlay').height($(document).height());
					// Check the user is at the bottom of the element
					if($(window).scrollTop() + $(window).height() > $this.height() && !busy) {
						
						
						// Now we are working, so busy is true
						busy = true;
						
						if( $settings.totalGlobal < $settings.nop )
						{
							return false;
						}
						// Tell the user we're loading posts
						//$this.find('.loading-bar').html('Loading...');
						
						// Run the function to fetch the data inside a delay
						// This is useful if you have content in a footer you
						// want the user to see.
						setTimeout(function() {
							
							getData();
							
						}, $settings.delay);
							
					}	
				});
			}
			
			// Also content can be loaded by clicking the loading bar/
			$this.find('.loading-bar').click(function() {
			
				if(busy == false) {
					busy = true;
					//$this.find('.loading-bar').html('Loading...');
					setTimeout(function() {
							
							getData();
							
						}, $settings.delay);
				}
			
			});
			
		});
	}

})(jQuery);
