var urlbase    = $('base').attr('href');
$("input").attr('autocomplete','off');
//=========== TRIM
function trim ( cadena )
{
	return cadena.replace(/^\s+/g,'').replace(/\s+$/g,'')
}

//================= * SCROLL ELEMENT * ===================//
				function scrollElement( element ) 
				{
					var offset = $(element).offset().top;
 					$('html, body').animate({scrollTop:offset}, 500);
				};


//====================================//
/*               ALERT                */
//===================================//
(function($) {
	
	$.alerts = {
		
		// These properties can be read/written by accessing $.alerts.propertyName from your scripts at any time
		
		verticalOffset: -75,                // vertical offset of the dialog from center screen, in pixels
		horizontalOffset: 0,                // horizontal offset of the dialog from center screen, in pixels/
		repositionOnResize: true,           // re-centers the dialog on window resize
		overlayOpacity: .8,                // transparency level of overlay
		overlayColor: '#000',               // base color of overlay
		draggable: true,                    // make the dialogs draggable (requires UI Draggables plugin)
		okButton: '&nbsp;Accept&nbsp;',         // text for the OK button
		cancelButton: '&nbsp;Cancel&nbsp;', // text for the Cancel button
		dialogClass: null,                  // if specified, this class will be applied to all dialogs
		
		// Public methods
		
		alert: function(message, title, callback) {
			if( title == null ) title = 'Alert';
			$.alerts._show(title, message, null, 'alert', function(result) {
				if( callback ) callback(result);
			});
		},
		
		confirm: function(message, title, callback) {
			if( title == null ) title = 'Confirm';
			$.alerts._show(title, message, null, 'confirm', function(result) {
				if( callback ) callback(result);
			});
		},
			
		prompt: function(message, value, title, callback) {
			if( title == null ) title = 'Prompt';
			$.alerts._show(title, message, value, 'prompt', function(result) {
				if( callback ) callback(result);
			});
		},
		
		// Private methods
		
		_show: function(title, msg, value, type, callback) {
			
			$.alerts._hide();
			$.alerts._overlay('show');
			
			$("BODY").append(
			  '<div id="popup_container">' +
			    '<h1 id="popup_title"></h1>' +
			    '<div id="popup_content">' +
			      '<div id="popup_message"></div>' +
				'</div>' +
			  '</div>');
			
			if( $.alerts.dialogClass ) $("#popup_container").addClass($.alerts.dialogClass);
			
			// IE6 Fix
			var pos = ($.browser.msie && parseInt($.browser.version) <= 6 ) ? 'absolute' : 'fixed'; 
			
			$("#popup_container").css({
				position: pos,
				zIndex: 99999,
				padding: '35px 15px 20px',
				margin: 0
			});
			
			$("#popup_title").text(title);
			$("#popup_content").addClass(type);
			$("#popup_message").text(msg);
			$("#popup_message").html( $("#popup_message").text().replace(/\n/g, '<br />') );
			
			$("#popup_container").css({
				minWidth: $("#popup_container").outerWidth(),
				maxWidth: $("#popup_container").outerWidth()
			});
			
			$.alerts._reposition();
			$.alerts._maintainPosition(true);
			
			switch( type ) {
				case 'alert':
					$("#popup_message").after('<div id="popup_panel"><input type="button" value="' + $.alerts.okButton + '" id="popup_ok" /></div>');
					$("#popup_ok").click( function() {
						$.alerts._hide();
						callback(true);
					});
					$("#popup_ok").focus().keypress( function(e) {
						if( e.keyCode == 13 || e.keyCode == 27 ) $("#popup_ok").trigger('click');
					});
				break;
				case 'confirm':
					$("#popup_message").after('<div id="popup_panel"><input type="button" value="' + $.alerts.okButton + '" id="popup_ok" /> <input type="button" value="' + $.alerts.cancelButton + '" id="popup_cancel" /></div>');
					$("#popup_ok").click( function() {
						$.alerts._hide();
						if( callback ) callback(true);
					});
					$("#popup_cancel").click( function() {
						$.alerts._hide();
						if( callback ) callback(false);
					});
					$("#popup_ok").focus();
					$("#popup_ok, #popup_cancel").keypress( function(e) {
						if( e.keyCode == 13 ) $("#popup_ok").trigger('click');
						if( e.keyCode == 27 ) $("#popup_cancel").trigger('click');
					});
				break;
				case 'prompt':
					$("#popup_message").append('<br /><input type="text" size="30" id="popup_prompt" />').after('<div id="popup_panel"><input type="button" value="' + $.alerts.okButton + '" id="popup_ok" /> <input type="button" value="' + $.alerts.cancelButton + '" id="popup_cancel" /></div>');
					$("#popup_prompt").width( $("#popup_message").width() );
					$("#popup_ok").click( function() {
						var val = $("#popup_prompt").val();
						$.alerts._hide();
						if( callback ) callback( val );
					});
					$("#popup_cancel").click( function() {
						$.alerts._hide();
						if( callback ) callback( null );
					});
					$("#popup_prompt, #popup_ok, #popup_cancel").keypress( function(e) {
						if( e.keyCode == 13 ) $("#popup_ok").trigger('click');
						if( e.keyCode == 27 ) $("#popup_cancel").trigger('click');
					});
					if( value ) $("#popup_prompt").val(value);
					$("#popup_prompt").focus().select();
				break;
			}
			
			// Make draggable
			if( $.alerts.draggable ) {
				try {
					$("#popup_container").draggable({ handle: $("#popup_title") });
					$("#popup_title").css({ cursor: 'move' });
				} catch(e) { /* requires jQuery UI draggables */ }
			}
		},
		
		_hide: function() {
			$("#popup_container").remove();
			$.alerts._overlay('hide');
			$.alerts._maintainPosition(false);
		},
		
		_overlay: function(status) {
			switch( status ) {
				case 'show':
					$.alerts._overlay('hide');
					$("BODY").append('<div id="popup_overlay"></div>');
					$("#popup_overlay").css({
						position: 'absolute',
						zIndex: 99998,
						top: '0px',
						left: '0px',
						width: '100%',
						height: $(document).height(),
						background: $.alerts.overlayColor,
						opacity: $.alerts.overlayOpacity
					});
				break;
				case 'hide':
					$("#popup_overlay").remove();
				break;
			}
		},
		
		_reposition: function() {
			var top = (($(window).height() / 2) - ($("#popup_container").outerHeight() / 2)) + $.alerts.verticalOffset;
			var left = (($(window).width() / 2) - ($("#popup_container").outerWidth() / 2)) + $.alerts.horizontalOffset;
			if( top < 0 ) top = 0;
			if( left < 0 ) left = 0;
			
			// IE6 fix
			if( $.browser.msie && parseInt($.browser.version) <= 6 ) top = top + $(window).scrollTop();
			
			$("#popup_container").css({
				top: top + 'px',
				left: left + 'px'
			});
			$("#popup_overlay").height( $(document).height() );
		},
		
		_maintainPosition: function(status) {
			if( $.alerts.repositionOnResize ) {
				switch(status) {
					case true:
						$(window).bind('resize', $.alerts._reposition);
					break;
					case false:
						$(window).unbind('resize', $.alerts._reposition);
					break;
				}
			}
		}
		
	}
	
	// funciones de acceso directo
	jAlert = function(message, title, callback) {
		$.alerts.alert(message, title, callback);
	}
	
	jConfirm = function(message, title, callback) {
		$.alerts.confirm(message, title, callback);
	};
		
	jPrompt = function(message, value, title, callback) {
		$.alerts.prompt(message, value, title, callback);
	};
	
})(jQuery);	
//==================================================//
//=               *  logout *               =//
//==================================================//
$('#logout').click(function(){
	
	var time = 100;
	var out  = 'logout=out';
	
	
	$('body').keydown(function (event) {

	    if( event.which  == 116 || event.which  == 27  )
	    {
	     	return false;   
	    }
   });//======== FUNCTION 
   
	setTimeout(function(){
	$.ajax({
		
		type: 'GET',
		url: 'public/ajaxAdmin/logout.php',
		data: out,
		success:function( msj )
		{
			if ( msj == 'OK' ) {
				window.location.reload();
			}
		},// success
		error:function(){
				alert('Error');
			}
	});
	
	},time);
});
//===================================================//
//=                  LIVEQUERY                      =//
//===================================================//
(function($) {
$.extend($.fn, {
	livequery: function(type, fn, fn2) {
		var self = this, q;

		// Handle different call patterns
		if ($.isFunction(type))
			fn2 = fn, fn = type, type = undefined;

		// See if Live Query already exists
		$.each( $.livequery.queries, function(i, query) {
			if ( self.selector == query.selector && self.context == query.context &&
				type == query.type && (!fn || fn.$lqguid == query.fn.$lqguid) && (!fn2 || fn2.$lqguid == query.fn2.$lqguid) )
					// Found the query, exit the each loop
					return (q = query) && false;
		});

		// Create new Live Query if it wasn't found
		q = q || new $.livequery(this.selector, this.context, type, fn, fn2);

		// Make sure it is running
		q.stopped = false;

		// Run it immediately for the first time
		q.run();

		// Contnue the chain
		return this;
	},

	expire: function(type, fn, fn2) {
		var self = this;

		// Handle different call patterns
		if ($.isFunction(type))
			fn2 = fn, fn = type, type = undefined;

		// Find the Live Query based on arguments and stop it
		$.each( $.livequery.queries, function(i, query) {
			if ( self.selector == query.selector && self.context == query.context &&
				(!type || type == query.type) && (!fn || fn.$lqguid == query.fn.$lqguid) && (!fn2 || fn2.$lqguid == query.fn2.$lqguid) && !this.stopped )
					$.livequery.stop(query.id);
		});

		// Continue the chain
		return this;
	}
});

$.livequery = function(selector, context, type, fn, fn2) {
	this.selector = selector;
	this.context  = context;
	this.type     = type;
	this.fn       = fn;
	this.fn2      = fn2;
	this.elements = [];
	this.stopped  = false;

	// The id is the index of the Live Query in $.livequery.queries
	this.id = $.livequery.queries.push(this)-1;

	// Mark the functions for matching later on
	fn.$lqguid = fn.$lqguid || $.livequery.guid++;
	if (fn2) fn2.$lqguid = fn2.$lqguid || $.livequery.guid++;

	// Return the Live Query
	return this;
};

$.livequery.prototype = {
	stop: function() {
		var query = this;

		if ( this.type )
			// Unbind all bound events
			this.elements.unbind(this.type, this.fn);
		else if (this.fn2)
			// Call the second function for all matched elements
			this.elements.each(function(i, el) {
				query.fn2.apply(el);
			});

		// Clear out matched elements
		this.elements = [];

		// Stop the Live Query from running until restarted
		this.stopped = true;
	},

	run: function() {
		// Short-circuit if stopped
		if ( this.stopped ) return;
		var query = this;

		var oEls = this.elements,
			els  = $(this.selector, this.context),
			nEls = els.not(oEls);

		// Set elements to the latest set of matched elements
		this.elements = els;

		if (this.type) {
			// Bind events to newly matched elements
			nEls.bind(this.type, this.fn);

			// Unbind events to elements no longer matched
			if (oEls.length > 0)
				$.each(oEls, function(i, el) {
					if ( $.inArray(el, els) < 0 )
						$.event.remove(el, query.type, query.fn);
				});
		}
		else {
			// Call the first function for newly matched elements
			nEls.each(function() {
				query.fn.apply(this);
			});

			// Call the second function for elements no longer matched
			if ( this.fn2 && oEls.length > 0 )
				$.each(oEls, function(i, el) {
					if ( $.inArray(el, els) < 0 )
						query.fn2.apply(el);
				});
		}
	}
};

$.extend($.livequery, {
	guid: 0,
	queries: [],
	queue: [],
	running: false,
	timeout: null,

	checkQueue: function() {
		if ( $.livequery.running && $.livequery.queue.length ) {
			var length = $.livequery.queue.length;
			// Run each Live Query currently in the queue
			while ( length-- )
				$.livequery.queries[ $.livequery.queue.shift() ].run();
		}
	},

	pause: function() {
		// Don't run anymore Live Queries until restarted
		$.livequery.running = false;
	},

	play: function() {
		// Restart Live Queries
		$.livequery.running = true;
		// Request a run of the Live Queries
		$.livequery.run();
	},

	registerPlugin: function() {
		$.each( arguments, function(i,n) {
			// Short-circuit if the method doesn't exist
			if (!$.fn[n]) return;

			// Save a reference to the original method
			var old = $.fn[n];

			// Create a new method
			$.fn[n] = function() {
				// Call the original method
				var r = old.apply(this, arguments);

				// Request a run of the Live Queries
				$.livequery.run();

				// Return the original methods result
				return r;
			}
		});
	},

	run: function(id) {
		if (id != undefined) {
			// Put the particular Live Query in the queue if it doesn't already exist
			if ( $.inArray(id, $.livequery.queue) < 0 )
				$.livequery.queue.push( id );
		}
		else
			// Put each Live Query in the queue if it doesn't already exist
			$.each( $.livequery.queries, function(id) {
				if ( $.inArray(id, $.livequery.queue) < 0 )
					$.livequery.queue.push( id );
			});

		// Clear timeout if it already exists
		if ($.livequery.timeout) clearTimeout($.livequery.timeout);
		// Create a timeout to check the queue and actually run the Live Queries
		$.livequery.timeout = setTimeout($.livequery.checkQueue, 20);
	},

	stop: function(id) {
		if (id != undefined)
			// Stop are particular Live Query
			$.livequery.queries[ id ].stop();
		else
			// Stop all Live Queries
			$.each( $.livequery.queries, function(id) {
				$.livequery.queries[ id ].stop();
			});
	}
});
// Register core DOM manipulation methods
$.livequery.registerPlugin('append', 'prepend', 'after', 'before', 'wrap', 'attr', 'removeAttr', 'addClass', 'removeClass', 'toggleClass', 'empty', 'remove', 'html');

// Run Live Queries when the Document is ready
$(function() { $.livequery.play(); });

})(jQuery);

//===============================================================//
//=                         PHOTO UPLOAD                        =//
//===============================================================//
(function($){$.fn.filestyle=function(options)
{
	var settings = {width:250};
	if(options){$.extend(settings,options);};return this.each(function()
    {var self=this;
    var wrapper=$("<div class='file-btn'>")
    .css({"width":settings.imagewidth+"px","height":settings.imageheight+"px","background-position":"right",
    "display":"block","float":"right","overflow":"hidden","cursor":"pointer"});
     $(self).wrap(wrapper);$(self)
     .css({"position":"relative","height":settings.imageheight+"px","width":settings.width+"px","display":"block",
     "cursor":"pointer","opacity":"0.0"});if($.browser.mozilla)
     {if(/Win/.test(navigator.platform)){$(self).css("margin-left","0");}
     else{$(self).css("margin-left","0");};}
     });};})(jQuery);
     
    //<--- * UPLOAD * --->
    $("input#upload, input#uploadAvatar, input#uploadCover, #upload_bg").filestyle({
        imageheight: 30,
        imagewidth: 45,
        width: 45
    });
	
	var param   = /^[0-9]+$/i;
	
			/*=============== ** ===================*/	
			$('.button_save_general').live('click',function(s){
				
				s.preventDefault();
				
				var element     = $(this);
				var error       = false;
				var _SiteName   = $('#title').val().length;
				var msg_length  = $('#message_length').val();
				var post_length = $('#post_length').val();
				
				if( _SiteName == '' && trim( _SiteName )  == 0 )
				{
					var error = true;
					$('#titulo').focus();
					return false;
				}
				
				else if( msg_length == '' && trim( msg_length ).length  == 0 )
				{
					var error = true;
					$('#message_length').focus();
					return false;
				}
				
				else if( !param.test( msg_length ) )
				{
					var error = true;
					$('#message_length').focus();
					return false;
				}
				
				else if( post_length == '' && trim( post_length ).length  == 0 )
				{
					var error = true;
					$('#post_length').focus();
					return false;
				}
				
				else if( !param.test( post_length ) )
				{
					var error = true;
					$('#post_length').focus();
					return false;
				}

				if( error == false ){
					$('.button_save_general').attr({'disabled' : 'true'}).val('Wait...').css({'opacity':'0.5','cursor':'default'});
					
					$.post("public/ajaxAdmin/settings_general.php", $("#upload").serialize(), function(result){
						
						if( result == 'ok' ){
							$('#edit_success').html('Saved successfully').fadeIn(500).delay(4000).fadeOut()
							 $('.button_save_general').removeAttr('disabled').val('Save').css({ 'opacity': 1, 'cursor':'pointer' })
						}
						else
						{
							$('.button_save_general').removeAttr('disabled').val('Save').css({ 'opacity': 1, 'cursor':'pointer' })
							$('#errors').html('Error occurred').fadeIn(500).delay(4000).fadeOut();
						}
					});//<-- END OF $POST AJAX
				}//<-- END ERROR == FALSE
			});//<<<-------- * END FUNCTION CLICK * ---->>>>
		
		/*=============== ** ===================*/	
			$('.button_ad').live('click',function(s){
				
				s.preventDefault();
				
				var element     = $(this);
				var error       = false;


				if( error == false ){
					$('.button_ad').attr({'disabled' : 'true'}).val('Wait...').css({'opacity':'0.5','cursor':'default'});
					
					$.post("public/ajaxAdmin/ad_settings.php", $("#upload").serialize(), function(result){
						
						if( result == 'ok' ){
							$('#edit_success').html('Saved successfully').fadeIn(500).delay(4000).fadeOut()
							 $('.button_ad').removeAttr('disabled').val('Save').css({ 'opacity': 1, 'cursor':'pointer' })
						}
						else
						{
							$('.button_ad').removeAttr('disabled').val('Save').css({ 'opacity': 1, 'cursor':'pointer' })
							$('#errors').html('Error occurred').fadeIn(500).delay(4000).fadeOut();
						}
					});//<-- END OF $POST AJAX
				}//<-- END ERROR == FALSE
			});//<<<-------- * END FUNCTION CLICK * ---->>>>
		
		/*=============== ** ===================*/	
			$('.button_pass').live('click',function(s){
				
				s.preventDefault();
				
				var element     = $(this);
				var error       = false;
				var pass        = $('#pass').val().length;
				
				if( pass == '' && pass == 0 )
				{
					var error = true;
					$('#pass').focus();
					return false;
				}

				if( error == false ){
					$('.button_pass').attr({'disabled' : 'true'}).val('Wait...').css({'opacity':'0.5','cursor':'default'});
					
					$.post("public/ajaxAdmin/password_change.php", $("#upload").serialize(), function(result){
						
						if( result == 'ok' ){
							
							$('#pass').val('');
							$('#edit_success').html('Saved successfully').fadeIn(500).delay(4000).fadeOut();
							$('.button_pass').removeAttr('disabled').val('Save').css({ 'opacity': 1, 'cursor':'pointer' })
						}
						else
						{
							$('.button_pass').removeAttr('disabled').val('Save').css({ 'opacity': 1, 'cursor':'pointer' })
							$('#errors').html('Error occurred').fadeIn(500).delay(4000).fadeOut();
						}
					});//<-- END OF $POST AJAX
				}//<-- END ERROR == FALSE
			});//<<<-------- * END FUNCTION CLICK * ---->>>>
			
		/*=============== ** ===================*/	
			$('.button_edit_pages').live('click',function(s){
				
				s.preventDefault();
				
				var element     = $(this);
				var error       = false;
				var title       = $('#title').val();
				
				if( title == '' || title == 0 || trim( title ).length == 0  ){
					var error = true;
					$('#title').focus();
					$('#errors').html('Title can not be empty').fadeIn();
				}
				
				if( error == false ){
					$('.button_edit_pages').attr({'disabled' : 'true'}).val('Wait...').css({'opacity':'0.5','cursor':'default'});
					
					$.post("public/ajaxAdmin/edit_pages.php", $("#upload").serialize(), function(result){
						
						if( result == 'ok' ){
							$('#errors').fadeOut();
							$('#edit_success').html('Saved successfully').fadeIn(500).delay(4000).fadeOut();
							$('.button_edit_pages').removeAttr('disabled').val('Save').css({ 'opacity': 1, 'cursor':'pointer' })
						}
						else
						{
							$('.button_edit_pages').removeAttr('disabled').val('Save').css({ 'opacity': 1, 'cursor':'pointer' })
							$('#errors').html('Error occurred').fadeIn(500).delay(4000).fadeOut();
						}
					});//<-- END OF $POST AJAX
				}//<-- END ERROR == FALSE
			});//<<<-------- * END FUNCTION CLICK * ---->>>>
			
			
			/*===================== ADD PAGES ========================= */
			var paramUrl   = /^[a-z0-9\_\-]+$/i;
			/*=============== ** ===================*/	
			$('.button_add_pages').live('click',function(s){
				
				s.preventDefault();
				
				var element     = $(this);
				var error       = false;
				var title       = $('#add_title').val();
				var url       = $('#add_url').val();
				
				if( title == '' || title == 0 || trim( title ).length == 0  ){
					var error = true;
					$('#add_title').focus();
					$('#errors').html('Title can not be empty').fadeIn();
				} else if ( url == '' || url == 0 || trim( url ).length == 0 ) {
					var error = true;
					$('#add_url').focus();
					$('#errors').html('URL can not be empty').fadeIn();
				} else if( !paramUrl.test( url ) ) {
					var error = true;
					$('#add_url').focus();
					$('#errors').html('URL must not contain special characters or spaces').fadeIn();
				}
				
				if( error == false ){
					$('.button_add_pages').attr({'disabled' : 'true'}).val('Wait...').css({'opacity':'0.5','cursor':'default'});
					
					$.post("public/ajaxAdmin/ajax_add_page.php", $("#upload").serialize(), function(result){
						
						if( result == 'ok' ){
							$('#errors').fadeOut();
							$('#edit_success').html('Page created successfully').fadeIn(500).delay(4000).fadeOut();
							$('#upload input, textarea').val('');
							$('.button_add_pages').removeAttr('disabled').val('Save').css({ 'opacity': 1, 'cursor':'pointer' });
						} else if( result == 'no' ) {
							$('.button_add_pages').removeAttr('disabled').val('Save').css({ 'opacity': 1, 'cursor':'pointer' })
							$('#errors').html('The URL is already in use').fadeIn(500).delay(4000).fadeOut();
							$('#add_url').focus();
						} else if ( result == 'url' ) {
							$('.button_add_pages').removeAttr('disabled').val('Save').css({ 'opacity': 1, 'cursor':'pointer' })
							$('#errors').html('URL must not contain special characters or spaces').fadeIn(500).delay(4000).fadeOut();
							$('#add_url').focus();
						} else {
							$('.button_add_pages').removeAttr('disabled').val('Save').css({ 'opacity': 1, 'cursor':'pointer' })
							$('#errors').html('Error occurred').fadeIn(500).delay(4000).fadeOut();
						}
					});//<-- END OF $POST AJAX
				}//<-- END ERROR == FALSE
			});//<<<-------- * END FUNCTION CLICK * ---->>>>
			
	    
	    //============================================//
		//=             Delete Account               =//
		//============================================//
		$('#delete_page').live('click',function(){
			var element = $(this);
			var id    = $(this).attr('data-id');
			var info      = 'id=' + id;
			var url       = $('#link_to_pages').attr('href');
		 jConfirm("Sure you want to delete this page? ", 'Confirm', function( r ){
	
	     if( r == true ) {
				 $.ajax({
				   type: "POST",
				   url: "public/ajaxAdmin/delete_page.php",
				   data: info,
				   success: function( result ){
				   if( result == 'ok' ) { 
				   	
				   	 window.location.href=url;
				   	 
				   }//<-- IF
					   else {
					   	 jAlert('Error occurred');
					   }
				 }//<-- RESULT 
			   });//<--- AJAX
	 }//END IF R TRUE 
	 
	  }); //Jconfirm  
});//<<<--- *  End Click * --->>>

			
			
		//============================================//
		//=               Type Account               =//
		//============================================//
		$('.radioAccount').click(function(){
			var id    = $(this).attr('data-id');
			var value = $(this).val();
			var info      = 'id=' + id + '&value=' + value;
			
				 $.ajax({
				   type: "POST",
				   url: "public/ajaxAdmin/type_account.php",
				   data: info,
				   success: function( result ){
				   if( result == 'ok' )
				   { 
				   	
				   }//<-- IF
					   else
					   {
					   	 jAlert('Error occurred');
					   }
				 }//<-- RESULT 
			   });//<--- AJAX
		});//<<<--- *  End Click * --->>>
		
		//============================================//
		//=             Suspended Account             =//
		//============================================//
		$('.suspended').live('click',function(){
			var element = $(this);
			var id    = $(this).attr('data-id');
			var info      = 'id=' + id;
			
				 $.ajax({
				   type: "POST",
				   url: "public/ajaxAdmin/suspended_account.php",
				   data: info,
				   success: function( result ){
				   if( result == 'ok' )
				   { 
				   	 element.addClass('active');
				   	 element.removeClass('suspended').attr({'title':'Activate'});
				   	 element.parents('tr').find('.statusTd').html('Suspended');
				   	 //window.location.reload();
				   	 
				   }//<-- IF
					   else
					   {
					   	 jAlert('Error occurred');
					   }
				 }//<-- RESULT 
			   });//<--- AJAX
		});//<<<--- *  End Click * --->>>
		
		//============================================//
		//=             Activate Account             =//
		//============================================//
		$('.active').live('click',function(){
			var element = $(this);
			var id    = $(this).attr('data-id');
			var info      = 'id=' + id;
			
				 $.ajax({
				   type: "POST",
				   url: "public/ajaxAdmin/activate_account.php",
				   data: info,
				   success: function( result ){
				   if( result == 'ok' )
				   { 
				   	 element.addClass('suspended');
				   	 element.removeClass('active').attr({'title':'Suspended'});
				   	 element.parents('tr').find('.statusTd').html('Active');
				   	 //window.location.reload();
				   	 
				   }//<-- IF
					   else
					   {
					   	 jAlert('Error occurred');
					   }
				 }//<-- RESULT 
			   });//<--- AJAX
		});//<<<--- *  End Click * --->>>
		
		//============================================//
		//=             Delete Account               =//
		//============================================//
		$('.delete').live('click',function(){
			var element = $(this);
			var id    = $(this).attr('data-id');
			var info      = 'id=' + id;
		 jConfirm("Sure you want to delete this user? ", 'Confirm', function( r ){
	
	     if( r == true ) {
				 $.ajax({
				   type: "POST",
				   url: "public/ajaxAdmin/delete_account.php",
				   data: info,
				   success: function( result ){
				   if( result == 'ok' )
				   { 
				   	
				   	 window.location.reload();
				   	 
				   }//<-- IF
					   else
					   {
					   	 jAlert('Error occurred');
					   }
				 }//<-- RESULT 
			   });//<--- AJAX
	 }//END IF R TRUE 
	 
	  }); //Jconfirm  
});//<<<--- *  End Click * --->>>


		//============================================//
		//=             Delete Posts               =//
		//============================================//
		$('.deletePost').live('click',function(){
			var element = $(this);
			var id    = $(this).attr('data-id');
			var info      = 'id=' + id;
		 jConfirm("Sure you want to delete this Post? ", 'Confirm', function( r ){
	
	     if( r == true )
	     {
				 $.ajax({
				   type: "POST",
				   url: "public/ajaxAdmin/delete_post.php",
				   data: info,
				   success: function( result ){
				   if( result == 'ok' )
				   { 
				   	
				   	 window.location.reload();
				   	 
				   }//<-- IF
					   else
					   {
					   	 jAlert('Error occurred');
					   }
				 }//<-- RESULT 
			   });//<--- AJAX
			   
			   
	 }//END IF R TRUE 
	 
	  }); //Jconfirm  
});//<<<--- *  End Click * --->>>

//<<<--- *  * --->>>
$('.button_new_admin').click(function(e){
				
				e.preventDefault();

				var error          = false;
				var name_admin     = $('#name_admin').val();
				var user_admin     = $('#user_admin').val();
				var pass_new       = $('#pass_new').val();
				var repeat_pass    = $('#repeat_pass').val();
			 

				if( name_admin == '' || name_admin == 0 || trim( name_admin ).length == 0  ){
					var error = true;
					$('#name_admin').focus();
				}
				
				else if( user_admin == 0 || trim( user_admin ).length < 1 ){
					var error = true;
					$('#user_admin').focus();
				}
				
				else if( pass_new.length == 0 ){
					var error = true;
					$('#pass_new').focus();

				}
				
				else if( repeat_pass.length == 0 ){
					var error = true;
					$('#repeat_pass').focus();

				}

				if( error == false ){
					$('.button_new_admin').attr({'disabled' : 'true'}).val('Wait...').css({'opacity':'0.5'});
					
					$.post("public/ajaxAdmin/ajax_add_user.php", $("#add_user_form").serialize(),function(data){
						
						if( data.success == 1 ){
							 $('#add_user_form  input').val('');
							 $('#success_add').fadeIn(500).html( data.res + ' <a class="close" data-dismiss="alert" href="javascript:void(0);" aria-hidden="true">&times;</a>' );
							 $('.button_new_admin').val('Save').removeAttr('disabled').css({'opacity': 1});
							 $('#error_add').fadeOut(500);
						}
						else{
							 $('#error_add').fadeIn(500);
							 $('#error_add').html( data.res + ' <a class="close" data-dismiss="alert" href="javascript:void(0);" aria-hidden="true">&times;</a>' );
							 $('.button_new_admin').removeAttr('disabled').val('Save').css({'opacity': 1});
							 
							 if( data.focus ) { 
							 	$('#'+data.focus).focus(); 
							 	}
						}//<-- ELSE
					},'json');//<-- END $POST AJAX
				}//<-- END ERROR == FALSE
			});//<-- END FUNCTION CLICK
			

		//============================================//
		//=             Delete User Admin             =//
		//============================================//
		$('#deleteUsers').live('click',function(){
			var element = $(this);
			var id      = $(this).data('id');
			var info      = 'id=' + id;
		 jConfirm("Sure you want to delete this user? ", 'Confirm', function( r ){
	
	     if( r == true )
	     {
				 $.ajax({
				   type: "POST",
				   url: "public/ajaxAdmin/delete_user_admin.php",
				   data: info,
				   success: function( result ){
				   if( result == 'ok' ) { 
				   	 window.location.reload();
				   }//<-- IF
					   else
					   {
					   	 jAlert('Error occurred');
					   }
				 }//<-- RESULT 
			   });//<--- AJAX
	 }//END IF R TRUE 
	 
	  }); //Jconfirm  

});//<<<--- *  End Click * --->>>