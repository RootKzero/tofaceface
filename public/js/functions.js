
(function(e){"function"==typeof define&&define.amd?define(["jquery"],e):e(window.jQuery||window.$)})(function(e){var t,o={className:"autosizejs",append:"",callback:!1,resizeDelay:10},i='<textarea tabindex="-1" style="position:absolute; top:-999px; left:0; right:auto; bottom:auto; border:0; padding: 0; -moz-box-sizing:content-box; -webkit-box-sizing:content-box; box-sizing:content-box; word-wrap:break-word; height:0 !important; min-height:0 !important; overflow:hidden; transition:none; -webkit-transition:none; -moz-transition:none;"/>',n=["fontFamily","fontSize","fontWeight","fontStyle","letterSpacing","textTransform","wordSpacing","textIndent"],s=e(i).data("autosize",!0)[0];s.style.lineHeight="99px","99px"===e(s).css("lineHeight")&&n.push("lineHeight"),s.style.lineHeight="",e.fn.autosize=function(i){return this.length?(i=e.extend({},o,i||{}),s.parentNode!==document.body&&e(document.body).append(s),this.each(function(){function o(){var t,o;"getComputedStyle"in window?(t=window.getComputedStyle(u),o=u.getBoundingClientRect().width,e.each(["paddingLeft","paddingRight","borderLeftWidth","borderRightWidth"],function(e,i){o-=parseInt(t[i],10)}),s.style.width=o+"px"):s.style.width=Math.max(p.width(),0)+"px"}function a(){var a={};if(t=u,s.className=i.className,d=parseInt(p.css("maxHeight"),10),e.each(n,function(e,t){a[t]=p.css(t)}),e(s).css(a),o(),window.chrome){var r=u.style.width;u.style.width="0px",u.offsetWidth,u.style.width=r}}function r(){var e,n;t!==u?a():o(),s.value=u.value+i.append,s.style.overflowY=u.style.overflowY,n=parseInt(u.style.height,10),s.scrollTop=0,s.scrollTop=9e4,e=s.scrollTop,d&&e>d?(u.style.overflowY="scroll",e=d):(u.style.overflowY="hidden",c>e&&(e=c)),e+=f,n!==e&&(u.style.height=e+"px",w&&i.callback.call(u,u))}function l(){clearTimeout(h),h=setTimeout(function(){var e=p.width();e!==g&&(g=e,r())},parseInt(i.resizeDelay,10))}var d,c,h,u=this,p=e(u),f=0,w=e.isFunction(i.callback),z={height:u.style.height,overflow:u.style.overflow,overflowY:u.style.overflowY,wordWrap:u.style.wordWrap,resize:u.style.resize},g=p.width();p.data("autosize")||(p.data("autosize",!0),("border-box"===p.css("box-sizing")||"border-box"===p.css("-moz-box-sizing")||"border-box"===p.css("-webkit-box-sizing"))&&(f=p.outerHeight()-p.height()),c=Math.max(parseInt(p.css("minHeight"),10)-f||0,p.height()),p.css({overflow:"hidden",overflowY:"hidden",wordWrap:"break-word",resize:"none"===p.css("resize")||"vertical"===p.css("resize")?"none":"horizontal"}),"onpropertychange"in u?"oninput"in u?p.on("input.autosize keyup.autosize",r):p.on("propertychange.autosize",function(){"value"===event.propertyName&&r()}):p.on("input.autosize",r),i.resizeDelay!==!1&&e(window).on("resize.autosize",l),p.on("autosize.resize",r),p.on("autosize.resizeIncludeStyle",function(){t=null,r()}),p.on("autosize.destroy",function(){t=null,clearTimeout(h),e(window).off("resize",l),p.off("autosize").off(".autosize").css(z).removeData("autosize")}),r())})):this}});

$('textarea').autosize(); 

var urlbase    = $('base').attr('href');
$("input").attr('autocomplete','off');
//<<<-- POPOUT --->>>>
$('.popout').hover(function(){
	$(this).fadeOut();
});
 
//=========== TRIM
function trim ( cadena )
{
	return cadena.replace(/^\s+/g,'').replace(/\s+$/g,'')
}

//<--------- waiting -------//>
(function($){
$.fn.waiting = function( p_delay ){
	var $_this = this.first();
	var _return = $.Deferred();
	var _handle = null;

	if ( $_this.data('waiting') != undefined ) {
		$_this.data('waiting').rejectWith( $_this );
		$_this.removeData('waiting');
	}
	$_this.data('waiting', _return);

	_handle = setTimeout(function(){
		_return.resolveWith( $_this );
	}, p_delay );

	_return.fail(function(){
		clearTimeout(_handle);
	});

	return _return.promise();
};
})(jQuery);

/*================================================= TYPSY ============================================*/
//TYPSY
			(function($) {
    $.fn.tipsy = function(opts) {

        opts = $.extend({fade: false, gravity: 'n'}, opts || {});
        var tip = null, cancelHide = false;

        this.hover(function() {
            
            $.data(this, 'cancel.tipsy', true);

            var tip = $.data(this, 'active.tipsy');
            if (!tip) {
                tip = $('<div class="tipsy"><div class="tipsy-inner">' + $(this).attr('title') + '</div></div>');
                tip.css({position: 'absolute', zIndex: 100000});
                $(this).attr('title', '');
                $.data(this, 'active.tipsy', tip);
            }
            
            var pos = $.extend({}, $(this).offset(), {width: this.offsetWidth, height: this.offsetHeight});
            tip.remove().css({top: 0, left: 0, visibility: 'hidden', display: 'block'}).appendTo(document.body);
            var actualWidth = tip[0].offsetWidth, actualHeight = tip[0].offsetHeight;
            
            switch (opts.gravity.charAt(0)) {
                case 'n':
                    tip.css({top: pos.top + pos.height, left: pos.left + pos.width / 2 - actualWidth / 2}).addClass('tipsy-north');
                    break;
                case 's':
                    tip.css({top: pos.top - actualHeight, left: pos.left + pos.width / 2 - actualWidth / 2}).addClass('tipsy-south');
                    break;
                case 'e':
                    tip.css({top: pos.top + pos.height / 2 - actualHeight / 2, left: pos.left - actualWidth}).addClass('tipsy-east');
                    break;
                case 'w':
                    tip.css({top: pos.top + pos.height / 2 - actualHeight / 2, left: pos.left + pos.width}).addClass('tipsy-west');
                    break;
            }

            if (opts.fade) {
                tip.css({opacity: 0, display: 'block', visibility: 'visible'}).animate({opacity: 1});
            } else {
                tip.css({visibility: 'visible'});
            }

        }, function() {
            $.data(this, 'cancel.tipsy', false);
            var self = this;
            setTimeout(function() {
                if ($.data(this, 'cancel.tipsy')) return;
                var tip = $.data(self, 'active.tipsy');
                if (opts.fade) {
                    tip.stop().fadeOut(function() { $(this).remove(); });
                } else {
                    tip.remove();
                }
            }, 100);
            
        });

    };
})(jQuery);//<---------------------- END TYPSY

$(function() {
	  $('.west').tipsy({gravity: 'w'});  
	  $('.south').tipsy({gravity: 's'});
    });
    
//================= * SCROLL ELEMENT * ===================//
				function scrollElement( element ) 
				{
					var offset = $(element).offset().top;
 					$('html, body').animate({scrollTop:offset}, 500);
				};

//** jQuery Scroll to Top Control script- (c) Dynamic Drive DHTML code library: http://www.dynamicdrive.com.
//** Available/ usage terms at http://www.dynamicdrive.com (March 30th, 09')
//** v1.1 (April 7th, 09'):
//** 1) Adds ability to scroll to an absolute position (from top of page) or specific element on the page instead.
//** 2) Fixes scroll animation not working in Opera. 
$(document).ready(function() {
var templatepath = $("#templatedirectory").html();
var scrolltotop={
	//startline: Integer. Number of pixels from top of doc scrollbar is scrolled before showing control
	//scrollto: Keyword (Integer, or "Scroll_to_Element_ID"). How far to scroll document up when control is clicked on (0=top).
	setting: {startline:100, scrollto: 0, scrollduration:1000, fadeduration:[700, 500]},
	controlHTML: '<img src="public/img/top.png" class="goTop" />', //HTML for control, which is auto wrapped in DIV w/ ID="topcontrol"
	controlattrs: {offsetx:15, offsety:12}, //offset of control relative to right/ bottom of window corner
	anchorkeyword: '#top', //Enter href value of HTML anchors on the page that should also act as "Scroll Up" links

	state: {isvisible:false, shouldvisible:false},

	scrollup:function(){
		if (!this.cssfixedsupport) //if control is positioned using JavaScript
			this.$control.css({opacity:0}) //hide control immediately after clicking it
		var dest=isNaN(this.setting.scrollto)? this.setting.scrollto : parseInt(this.setting.scrollto)
		if (typeof dest=="string" && jQuery('#'+dest).length==1) //check element set by string exists
			dest=jQuery('#'+dest).offset().top
		else
			dest=0
		this.$body.animate({scrollTop: dest}, this.setting.scrollduration);
	},

	keepfixed:function(){
		var $window=jQuery(window)
		var controlx=$window.scrollLeft() + $window.width() - this.$control.width() - this.controlattrs.offsetx
		var controly=$window.scrollTop() + $window.height() - this.$control.height() - this.controlattrs.offsety
		this.$control.css({left:controlx+'px', top:controly+'px'})
	},

	togglecontrol:function(){
		var scrolltop=jQuery(window).scrollTop()
		if (!this.cssfixedsupport)
			this.keepfixed()
		this.state.shouldvisible=(scrolltop>=this.setting.startline)? true : false
		if (this.state.shouldvisible && !this.state.isvisible){
			this.$control.stop().animate({opacity:1}, this.setting.fadeduration[0])
			this.state.isvisible=true
		}
		else if (this.state.shouldvisible==false && this.state.isvisible){
			this.$control.stop().animate({opacity:0}, this.setting.fadeduration[1])
			this.state.isvisible=false
		}
	},
	
	init:function(){
		jQuery(document).ready(function($){
			var mainobj=scrolltotop
			var iebrws=document.all
			mainobj.cssfixedsupport=!iebrws || iebrws && document.compatMode=="CSS1Compat" && window.XMLHttpRequest //not IE or IE7+ browsers in standards mode
			mainobj.$body=(window.opera)? (document.compatMode=="CSS1Compat"? $('html') : $('body')) : $('html,body')
			mainobj.$control=$('<div id="topcontrol" class="tooltip">'+mainobj.controlHTML+'</div>')
				.css({position:mainobj.cssfixedsupport? 'fixed' : 'absolute', bottom:mainobj.controlattrs.offsety, right:0, opacity:0, 'z-index': 50, cursor:'pointer'})
				.click(function(){mainobj.scrollup(); return false})
				.appendTo('body')
			if (document.all && !window.XMLHttpRequest && mainobj.$control.text()!='') //loose check for IE6 and below, plus whether control contains any text
				mainobj.$control.css({width:mainobj.$control.width()}) //IE6- seems to require an explicit width on a DIV containing text
			mainobj.togglecontrol()
			$('a[href="' + mainobj.anchorkeyword +'"]').click(function(){
				mainobj.scrollup()
				return false
			})
			$(window).bind('scroll resize', function(e){
				mainobj.togglecontrol()
			})
		})
	}
}

scrolltotop.init();
});

//==================================================//
//=               *  TOOGLE MENU *               =//
//==================================================//
	$('.toogle').click(function() {
		$('.boxLogin').slideToggle(2);
		$(this).addClass('active');
		$('#user').focus();
		return false
	});
	
	$(document).bind('click', function(e) {
		var $clicked = $(e.target);
		if ( !$clicked.parents().hasClass("toogle") 
		&& !$clicked.parents().hasClass("form_login") 
		&& !$clicked.hasClass("form_login") 
		&& !$clicked.hasClass( 'button_class' )
		)
		{
			$(".boxLogin").slideUp(1);
			$('.toogle').removeClass('active');
		}
	});
	
	$('.reply-button').click(function() {
		
		scrollElement( '#reply_post' );
		$('#reply_post').focus();
	});
	//==================================================//
//=               *  TOOGLE MENU *               =//
//==================================================//
	$('.settings_user').live('click',function() {
		$('#boxSettings').slideToggle(2);
		$(this).addClass('activeClass');
		//return false
	});
	
	$(document).bind('click', function(e) {
		var $clicked = $(e.target);
		if ( !$clicked.parents().hasClass("settings_user") && !$clicked.parents().hasClass("options_toogle") && !$clicked.hasClass("options_toogle") )
		{
			$("#boxSettings").slideUp(1);
			$('.settings_user').removeClass('activeClass');
		}
	});
	
$('.follow_active').live('mouseenter',function(){
	
	var unfollow  = $(this).attr('data-unfollow');
	var following = $(this).attr('data-type');
	
	$(this).html(unfollow);
	$(this).addClass('unfollow_button');
	 })
	 .live('mouseleave',function()
	 {
	 	var unfollow  = $(this).attr('data-unfollow');
		var following = $(this).attr('data-following');
	 	$(this).html(following);
	 	$(this).removeClass('unfollow_button');
	 });
//====================================//
/*               ALERT                */
//===================================//
var accept = $('body').attr('data-accept');
var cancel = $('body').attr('data-cancel');
		
(function($) {
	
	$.alerts = {
		
		// These properties can be read/written by accessing $.alerts.propertyName from your scripts at any time
		
		verticalOffset: -75,                // vertical offset of the dialog from center screen, in pixels
		horizontalOffset: 0,                // horizontal offset of the dialog from center screen, in pixels/
		repositionOnResize: true,           // re-centers the dialog on window resize
		overlayOpacity: .8,                // transparency level of overlay
		overlayColor: '#000',               // base color of overlay
		draggable: true,                    // make the dialogs draggable (requires UI Draggables plugin)
		okButton: '&nbsp;'+accept+'&nbsp;',         // text for the OK button
		cancelButton: '&nbsp;'+cancel+'&nbsp;', // text for the Cancel button
		dialogClass: null,                  // if specified, this class will be applied to all dialogs
		
		// Public methods
		
		alert: function(message, title, callback) {
			if( title == null ) title = 'Alert';
			$.alerts._show( title, message, null, 'alert', function(result) {
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
$('.logout').click(function(){
	
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
		url: 'public/ajax/logout.php',
		data: out,
		success:function( msj )
		{
			if ( msj == 'OK' )
			{
				window.location.reload();
			}
		},// success
		error:function(){
				jAlert('Error');
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
        imagewidth: 40,
        width: 40
    });

//===========================================//
//=               MODAL MESSAGE             =//
//===========================================//
// MODAL WINDOW
	$(function() {
        $(".modal").dialog({
            autoOpen: false,
            closeText: '',
            resizable: false,
			modal: true,
			show: "fade",
			hide: "fade",
            width: 'auto',//700,
			height: 'auto'//392
        });
 });
        $('#media_galery').live('click',function()
        {
        	

        	var _document = $('body');

            //$(".modal").dialog('open');
            
            _document.addClass('scroll_none');
            
            _document.keydown(function (event) {
             if( event.which  == 27  )
             {
             _document.removeClass('scroll_none').removeAttr('class');
             }
     		});//======== FUNCTION 
     	
	     	$(document).bind('click', function(e) {
			var $clicked = $(e.target);
			if ( !$clicked.parents("#cboxContent") )
			{
				_document.removeClass('scroll_none').removeAttr('class');
			}
		  });
	
     	$('#cboxClose').click(function(){
     		_document.removeClass('scroll_none').removeAttr('class');
     	  });//<----
            return false;
        });
	

	
	//==================== EXPAND ========================//
	$('a.expand').live('click',function() {
		
		var _hide   = $(this).attr('data-hide');
		
		$(this).addClass('activeSpan');
		$(this).parent().find('.details-post').slideDown(); 
		$(this).parents('li').find('.grid-reply').slideDown(); 
		$(this).parents('li').find('.spanReply').slideDown();		
		$(this).parent().find('.textEx').html(_hide); 
		$(this).removeClass('expand');
		
		if( $(this).hasClass( 'reply' ) )
		{
			$(this).parent().find('#reply_post').focus();
		}
	});
	
	$('a.activeSpan').live('click',function() {
		var _expand = $(this).attr('data-expand');
		
		$(this).addClass('expand');
		$(this).parent().find('.details-post').slideUp();
		$(this).parents('li').find('.grid-reply').slideUp();
		$(this).parents('li').find('.spanReply').slideUp(); 
		$(this).parent().find('.textEx').html(_expand); 
		$(this).removeClass('activeSpan');
	});
	
	$('.optionsUser > li:last').css({'border':'none'});
	
	//========== SEND MESSAGE
	$('.sendMessage').click(function() {
		var element     = $(this);
		var _thisText   = $(this).html();
		var _thisUser   = $(this).attr('data-username');
		var id_user     = $(this).attr( 'data-id' );
		var dataSend    = $(this).attr('data-send');
		var _document   = $('body');
		
		 /* Reposition Modal */
		function _repositionBox(){ 
			var verticalOffset = -75;
			var left = (($(window).width() / 2) - ($(".popoutUser_message").outerWidth() / 2));
			if( left < 0 ) { left = 0; } 
			$(".popoutUser_message").css({
				left: left + 'px' 
				});
			}
			//<--- * REPOSITION POPOUT * ---->
			_repositionBox();
			$(window).bind('resize', _repositionBox );
   
		$('#boxSettings').slideUp(1);
		$('.settings_user').removeClass('activeClass');
		
		$('#container_popout_message').fadeIn( 1 );
		$('.textPopout_message').html( _thisText+' &rsaquo; @' + _thisUser );
		$('.content_user_message').html('<div id="grid_post"> <form action="" method="post" accept-charset="UTF-8" id="send_msg_profile"><input type="hidden" name="id_user" id="id_user" value="'+id_user+'" /><textarea name="message" id="message"></textarea> <button id="button_message" disabled="disabled" style="opacity: 0.5; cursor: default;" type="submit">'+dataSend+'</button> <div data-max="140" id="counter"></div> </form> <span class="notfound" style="display:none; width: 500px; padding: 0; overflow: hidden; text-align: center;"></span></div><!-- grid_post -->');
		
		$('.popoutUser_message').fadeIn( 500 );
		$('#message').focus();
		
            _document.addClass('scroll_none');
            
            // ESC
            _document.keydown(function (event) {
             if( event.which  == 27  ) {
             	$('.content_user_message, .textPopout_message').html('');
             	_document.removeClass('scroll_none').removeAttr('class');
             	$('#container_popout_message, .popoutUser_message').fadeOut( 1 );
             }
     		});//======== FUNCTION 
     		
     		// BIND CLICK
	     	$(document).bind('click', function(e) {
			var $clicked = $(e.target);
			if ( !$clicked.parents().hasClass("popoutUser_message") && !$clicked.hasClass("popoutUser_message") ) {
				$('.content_user_message, .textPopout_message').html('');
				_document.removeClass('scroll_none').removeAttr('class');
				$('#container_popout_message, .popoutUser_message').fadeOut( 1 );
			}
		  });
		  
		  // CLOSE BUTTON
		  $('.close_popout_message').click(function(){
		  	$('.content_user_message, .title_popout_message').html('');
     		_document.removeClass('scroll_none').removeAttr('class');
     		$('#container_popout_message, .popoutUser_message').fadeOut( 1 );
     	  });//<----
            
     	  return false;
	});//<<<--- SEND MESSAGE
	
	
			/*=============== SEND REPLY ===================*/	
			$('#button_reply').live('click',function(s){
				
				s.preventDefault();
				
				var element     = $(this);
				var error       = false;
				var _reply_post = element.parents('li').find('#reply_post').val();
				var saveHtml    =  element.parents('li').find('#button_reply').html();
			 	var _wait       = '...';
			 	var _saveHtml   = saveHtml + _wait;
						
				if( trim( _reply_post ) == '' && trim( _reply_post ).length  == 0 ){
					var error = true;
					return false;
				}
				

				if( error == false ){
					element.parents('li').find('#button_reply').attr({'disabled' : 'true'}).html(_saveHtml).css({'opacity':'0.5','cursor':'default'});
					
					$.post("public/ajax/replyPost.php", element.parents('li').find("#form_reply_post").serialize(), function(msg){
						
						if( msg.length != 0 ){
							element.parents('li').find( '.grid-reply' ).before( msg );
							 jQuery("span.timeAgo").timeago();
							 element.parents('li').find('#reply_post').val('');
							 element.parents('li').find('#button_reply').html(saveHtml);
						} 
					});//<-- END DE $POST AJAX
				}//<-- END ERROR == FALSE
			});//<<<-------- * END FUNCTION CLICK * ---->>>>
			
			
			/*=============== SEND REPLY ===================*/	
			$('#button-reply-status').click(function(s){
				
				s.preventDefault();
				
				var element     = $(this);
				var error       = false;
				var _reply_post = $('#reply_post').val();
				var saveHtml    = $(this).html();
			 	var _wait       = '...';
			 	var _saveHtml   = saveHtml + _wait;
				
				if( trim( _reply_post ) == '' && trim( _reply_post ).length  == 0 ){
					var error = true;
					return false;
				}
				

				if( error == false ){
					$('#button-reply-status').attr({'disabled' : 'true'}).html(_saveHtml).css({'opacity':'0.5','cursor':'default'});
					
					$.post("public/ajax/replyPost.php", $("#form_reply_post").serialize(), function(msg){
						
						if( msg.length != 0 ) {
							$( msg ).hide().appendTo('#reply-status-wrap').fadeIn( 500 );
							 jQuery("span.timeAgo").timeago();
							 $('#reply_post').val('');
							 $('#button-reply-status').html(saveHtml);
						} else {
							$('#button-reply-status').attr({'disabled' : 'true'});
						}
					});//<-- END DE $POST AJAX
				}//<-- END ERROR == FALSE
			});//<<<-------- * END FUNCTION CLICK * ---->>>>
			
			
			$('#button_message').live('click',function(s){
				s.preventDefault();
				
				var element     = $(this);
				var error       = false;
				var _message    = $('#message').val();
				var dataWait    = $('.sendMessage').attr('data-wait');
				var dataSuccess = $('.sendMessage').attr('data-success');
				var dataSent    = $('.sendMessage').attr('data-send');
				var dataError   = $('.sendMessage').attr('data-error');
				
				if( _message == '' && trim( _message ).length  == 0 )
				{
					var error = true;
					return false;
				}
				

				if( error == false ){
					$('#button_message').attr({'disabled' : 'true'}).html(dataWait).css({'opacity':'0.5','cursor':'default'});
					
					$.post("public/ajax/send_message.php", $("#send_msg_profile").serialize(), function(msg){
						
						if( msg.length != 0 ){
							 $('#message').val('');
							 $('#button_message').html(dataSent);
							 $('.popout').html(dataSuccess).fadeIn(500).delay(4000).fadeOut();
							 $('body').removeClass('scroll_none').removeAttr('class');
							 $('#container_popout_message, .popoutUser_message').fadeOut( 1 );
							 $('.content_user_message, .textPopout_message').html('');
						}
						else
						{
							$('.popout').html(dataError).fadeIn(500).delay(4000).fadeOut();
						}
						
					});//<-- END DE $POST AJAX
				}//<-- END ERROR == FALSE
			});//<<<-------- * END FUNCTION CLICK * ---->>>>
			
			
	//=========== ADD POST
	$('textarea#add_post').keyup(function(){
		
		var $allowed = $('body').attr('data-max');
		var _videoLink = $('input#video_link').val();
		var _songLink = $('input#song_link').val();
		var _photoId   = $('input#photoId').val();
		
		if ( trim( $(this).val() ).length >= 1 && trim( $(this).val() ).length <= $allowed  )
		{
			$('#button_add').removeAttr('disabled').css({'opacity':'1','cursor':'pointer'});
			return false;
		}
		else if( trim( $(this).val() ).length == 0 && _videoLink.length != 0 || _photoId.length != 0 || _songLink.length != 0 )
		{
			$('#button_add').removeAttr('disabled').css({'opacity':'1','cursor':'pointer'});
			return false;
		}
		else
		{
			$('#button_add').attr({'disabled' : 'true'}).css({'opacity':'0.5','cursor':'default'});
			return false;
		}
	});
	
	//=========== REPLY POST
	$('textarea#reply_post, textarea#reply_msg').live('keyup',function(){
		
		var $allowed   = $('body').attr('data-max');
		
		if ( trim( $(this).val() ).length >= 1 && trim( $(this).val() ).length <= $allowed )
		{
			$(this).parent().find('#button_reply, #button-reply-status, #button-reply-msg').removeAttr('disabled').css({'opacity':'1','cursor':'pointer'});
			return false;
		}
		else
		{
			$(this).parent().find('#button_reply, #button-reply-status, #button-reply-msg').attr({'disabled' : 'true'}).css({'opacity':'0.5','cursor':'default'});
			return false;
		}
	});
	
	//=========== MESSAGE
	$('textarea#message').live('keyup',function(){
		
		var $allowed   = $('body').attr('data-max');
		
		if ( trim( $(this).val() ).length >= 1 && trim( $(this).val() ).length <= $allowed )
		{
			$(this).parent().find('#button_message').removeAttr('disabled').css({'opacity':'1','cursor':'pointer'});
			return false;
		}
		else
		{
			$(this).parent().find('#button_message').attr({'disabled' : 'true'}).css({'opacity':'0.5','cursor':'default'});
			return false;
		}
	});
	
	function isValidURL(url){
    	var RegExp = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;

	    if(RegExp.test(url)){
	        return true;
	    }else{
	        return false;
	    }
	    }
	    
	    var $thtml = $('#add_post').html();
	    
	//=========== VIDEO TRUE
	$('input#video_link').live('keyup',function(){
		
		var value = $(this).val();
		
		if ( trim( $(this).val() ).length != 0 && isValidURL($(this).val()) ) {
			
			$('#button_add').removeAttr('disabled').css({'opacity':'1','cursor':'pointer'});
			$(value).appendTo( '#add_post' );
			return false;
		} else {
			$('#button_add').attr({'disabled' : 'true'}).css({'opacity':'0.5','cursor':'default'});
			return false;
		}
	});
	
	//=========== SONG TRUE
	$('input#song_link').live('keyup',function(){
		
		var value = $(this).val();
		
		if ( trim( $(this).val() ).length != 0 && isValidURL($(this).val()) ) {
			
			$('#button_add').removeAttr('disabled').css({'opacity':'1','cursor':'pointer'});
			$(value).appendTo( '#add_post' );
			return false;
		} else {
			$('#button_add').attr({'disabled' : 'true'}).css({'opacity':'0.5','cursor':'default'});
			return false;
		}
	});

//============= VIDEO

//========== VIDEO POST

	$('div.video_post').click(function()
	{
		$("#video_link").each(function() {
        _display = $(this).css("display");
        
        if( _display == "block") {
          $(this).slideUp('fast',function() {
           $(this).css("display","none");
           $("#video_link").val('');
          });
        } else {
          $(this).fadeIn('slow',function() {
            $(this).css("display","block");
          });
          $("#video_link").focus();
			 $("#song_link").fadeOut( 1 );
			 $("#song_link").val('');
        }
      });
	});
	//<------- END FUNCTION
	
	//========== SONG POST

	$('div.song_post').click(function()
	{
		$("#song_link").each(function() {
        _display = $(this).css("display");
        
        if( _display == "block") {
          $(this).slideUp('fast',function() {
           $(this).css("display","none");
           $("#song_link").val('');
          });
        } else {
          $(this).fadeIn('slow',function() {
            $(this).css("display","block");
          });
          $("#song_link").focus();
			 $("#video_link").fadeOut( 1 );
			 $("#video_link").val('');
        }
      });
	});
	//<------- END FUNCTION
	
	
  /* $('textarea#add_post, #reply_post, #reply_msg').live('click',function() {
   	
   		$(this).animate({ height:100},{ duration: 200, easing: 'easeOutQuart' });
   	
   });*/
   
   $(document).bind('click', function(e) 
   {
			var $clicked = $(e.target);
			var $data    = $('#add_post').val();
			if ( !$clicked.parents().hasClass("post_add") && !$clicked.hasClass("post_add") && $data == 0 )
			{
				$('textarea#add_post').animate({ height:30},{ duration: 150, easing: 'easeInQuart' });
			}
		  });
		  

$(document).ready(function(){
	
	/*= DELETE POST =*/
	$(".trash").live('click',function(){
	var element   = $(this);
	var id        = element.attr("data");
	var token_id  = element.attr("data-token");
	var _title    = element.attr("data-message");
	var _confirm  = element.attr('data-confirm');
	var image     = element.attr("data-image");
	var info      = 'id=' + id + '&token=' + token_id + '&image=' + image;
	
	jConfirm( _title , _confirm, function( r ) {
	
	if( r == true ) {
	
		 $.ajax({
		   type: "POST",
		   url: "public/ajax/delete_post.php",
		   dataType: 'json',
		   data: info,
		   success: function( data ){
		   if( data.status == 'ok' ) { 
		   	element.parents('li').fadeTo(200,0.00, function(){
   		        element.parents('li').slideUp(200, function(){
   		  	     element.parents('li').remove();
   		       });
   		      });
		   }//<-- IF
			   else {
			   	 jAlert( data.res, data.res );
			   }
		    }//<-- RESULT 
	      });//<--- AJAX

	    }//END IF R TRUE 
	 
	  }); //Jconfirm  
	      
});//<--- Click
	  
	  /*= DELETE POST =*/
	$(".trashStatus").click(function(){
	var element   = $(this);
	var id        = element.attr("data");
	var token_id  = element.attr("data-token");
	var image     = element.attr("data-image");
	var _title    = element.attr("data-message");
	var _confirm  = element.attr('data-confirm');
	var info      = 'id=' + id + '&token=' + token_id + '&image=' + image;
	var url       = $('.detail_top > a').attr('href');
	
	jConfirm( _title, _confirm, function( r ){
	
	     if( r == true )
	     {
	
		 $.ajax({
		   type: "POST",
		   url: "public/ajax/delete_post.php",
		   data: info,
		   dataType: 'json',
		   success: function( data ){
		   if( data.status == 'ok' )
		   { 
		   	  window.location.href = url;
		   }//<-- IF
			   else
			   {
			   	 jAlert( data.res, data.res );
			   }
		 }//<-- RESULT 
	   });//<--- AJAX

	 }//END IF R TRUE 
	 
	  }); //Jconfirm  
	      
});//<--- Click
	  
	  /*= ADD_FAV =*/
	$(".favorite").live('click',function(){
	var element   = $(this);
	var id        = element.attr("data");
	var token_id  = element.attr("data-token");
	var _favorite = element.attr('data-fav');
	var favorited = element.attr('data-fav-active');
	var favs      = element.parent().find('span');
	var info      = 'id=' + id + '&token=' + token_id;
	var timeQuery = 1000;
	
	element.removeClass( 'favorite' );
	//$('.popout').html('Wait...').fadeIn();
	
	if( favs.hasClass( 'favorited' ) ) {
		   	element.addClass( 'favorite' );
		   	 element.find('i').removeClass('iconfavorited');
		   	  element.find('span').removeClass('favorited');
		   	  element.parents('li').find('.add_fav').remove();
		   	  element.find('span').html(_favorite);
		   	  $('.statusProfile').find('.add_fav').remove();
		}
		else {
			
			element.addClass( 'favorite' );
		   	  element.find('i').addClass('iconfavorited');
		   	  element.find('span').addClass('favorited');
		   	  element.find('span').html(favorited);
		   	  element.parents('li').append('<span class="add_fav"></span>');
		   	  $('.statusProfile').append('<span class="add_fav"></span>');
		}
		   	
	setTimeout(function(){
		
		 $.ajax({
		   type: "POST",
		   url: "public/ajax/favorites.php",
		   data: info,
		   success: function( result ){
		   	
		   	if( result == '') {
			   	 window.location.reload();
			   	 element.addClass( 'favorite' );
			   	 element.find('i').removeClass('iconfavorited');
			   	  element.find('span').removeClass('favorited');
			   	  element.parents('li').find('.add_fav').remove();
			   	  element.find('span').html(_favorite);
			   	  $('.statusProfile').find('.add_fav').remove();
		   	}
		 }//<-- RESULT 
	   });//<--- AJAX

	},timeQuery );
	      
});//<----- CLICK

  /*= REPOST =*/
	$(".repost_button").live('click',function(){
	var element   = $(this);
	var id        = element.attr("data");
	var token_id  = element.attr("data-token");
	var _repost   = element.attr("data-rep");
	var reposted  = element.attr("data-rep-active");
	var reps      = element.parent().find('span');
	var info      = 'id=' + id + '&token=' + token_id;
	var timeQuery = 1000;
	
	element.removeClass( 'repost_button' );
	
	if( reps.hasClass( 'repostedSpan' ) ) {
		   element.addClass( 'repost_button' );
		   	 element.find('i').removeClass('iconRepost');
		   	  element.find('span').removeClass('repostedSpan');
		   	  element.find('span').html(_repost);
		}
		else {
			
			element.addClass( 'repost_button' );
		   	  element.find('i').addClass('iconRepost');
		   	  element.find('span').addClass('repostedSpan');
		   	  element.find('span').html(reposted);
		}
		   	
	setTimeout(function(){
		
		 $.ajax({
		   type: "POST",
		   url: "public/ajax/reposted.php",
		   data: info,
		   success: function( result ) {
		   	
		   	if( result == '') {
			   	 window.location.reload();
		   	}
		 }//<-- RESULT 
	   });//<--- AJAX

	},timeQuery );
	      
});//<----- CLICK

    /*= FOLLOW =*/
	$(".whofollow").live('click',function(){
	var element    = $(this);
	var id         = element.attr("data-id");
	var _follow    = element.attr("data-follow");
	var _following = element.attr("data-following");
	var username   = element.attr('data-username');
	var info       = 'id=' + id;
	var timeQuery  = 1000;
	
	element.removeClass( 'whofollow' );
	
	setTimeout(function(){
		
		 $.ajax({
		   type: "POST",
		   url: "public/ajax/follow.php",
		   data: info,
		   dataType : 'json',
		   success: function( result ){
		   if( result.status == 1 )
		   { 
		   	 element.addClass( 'whofollow' );
		   	 $('.popout').html( _following + ' @' + username ).fadeIn().delay(2500).fadeOut();
		   	 element.html( _following + ' @' + username );
		   }
		   else if(  result.status == 2 )
		   {
		   	 element.addClass( 'whofollow' );
		     element.html( _follow + ' @' + username );
		   }
		   else if(  result.status == 3 )
		   {
		   	 element.addClass( 'whofollow' );
		   	 $('.popout').html( _following + ' @' + username ).fadeIn().delay(2500).fadeOut();
		   	 element.html(_following+' @' + username );
		   }
		   //<-- IF
			   else {
			   	 jAlert( result.error );
			   	 $('.popout').fadeOut();
			   }
		 }//<-- RESULT 
	   });//<--- AJAX

	 
	},timeQuery );
	      
});//<----- CLICK
	  
	  $('.getData').live('click',function(){
	  	 	
	  	var element = $(this);
	  	element.removeClass( 'getData' );
	  	$postId     = element.attr('data');
	  	$tokenId    = element.attr('data-token');
	  	$data       = 'postId='+ $postId +'&token=' + $tokenId;
	  	
	  	$.ajax({ 
	  		  
	  		  type     : 'GET',
	  		  url      : 'public/ajax/getData.php',
	  		  dataType : 'json',
	  		  data     : $data
	  		  }).done( function( data ) { 
	  		  	if( data ) {
	  				
	  		  		 element.removeAttr('data').removeAttr('data-token');
	  		  		//<--- PHOTOS Y FAVORITES ----->
	  		  		if( data.media != '' ) {
	  		  			element.parents('li').find( '.details-post' ).append( data.media );
	  		  		}
	  		  		if( data.replys != '' ) {
	  		  			var total_data_reply = data.replys.length;
						
						for( var i = 0; i < total_data_reply; i++ ) {
								element.parents('li').find( '.details-post' ).after( data.replys[i] );
							}
							
							jQuery("span.timeAgo").timeago();
	  		  		}
	  		  		if( data.favs != '' ) {
	  		  			var total_data = data.favs.length;
						
						for(var i = 0; i < total_data; i++ ) {
								element.parents('li').find( '.favs_title' ).after( data.favs[i] );
								$('.south').tipsy({gravity: 's'});
								
							}
	  		  			
	  		  		}
	  		  		
	  		  		$('textarea').autosize();
	  		  		
	  		  	}
	  		  	});//<--- Done
	  		  	
	  		  //<---- * end ajax * ---->
	  	 });//<---- * end click * ---->
	  	 
	  	 //<---------- * Remove Reply * ---------->
	  	 $('.removeReply').live('click',function(){
	  	 	
	  	 	var element = $(this);
	  	 	var data    = element.attr('data');
	  	 	var query   = '_replyId='+data;
	  	 	
	  	 	$.ajax({
	  	 		type : 'GET',
	  	 		url  : urlbase+'public/ajax/delete_reply.php',
	  	 		data : query,
	  	 		
	  	 	}).done(function( result ){
	  	 		
	  	 		if( result == 1 )
	  	 		{
	  	 			element.parents('span.spanReply').fadeTo( 200,0.00, function(){
   		             element.parents('span.spanReply').slideUp( 200, function(){
   		  	           element.parents('span.spanReply').remove();
   		              });
   		           });
	  	 		}
	  	 		else
	  	 		{
	  	 			element.removeClass('removeReply');
	  	 			return false;
	  	 		}
	  	 		
	  	 	});//<--- Done
	  	 	
	  	 });//<---- * end click * ---->
	  	 
	  	 
	  	  //<---------- * Remove Reply * ---------->
	  	 $('.removeMsg').live('click',function(){
	  	 	
	  	 	var element = $(this);
	  	 	var data    = element.attr('data');
	  	 	var query   = '_msgId='+data;
	  	 	
	  	 	element.parents('li').fadeTo( 200,0.00, function(){
   		             element.parents('li').slideUp( 200, function(){
   		  	           element.parents('li').remove();
   		              });
   		           });
   		           
	  	 	$.ajax({
	  	 		type : 'POST',
	  	 		url  : urlbase+'public/ajax/delete_msg.php',
	  	 		dataType: 'json',
	  	 		data : query,
	  	 		
	  	 	}).done(function( data ){
	  	 		
	  	 		if( data.status === 0 ) {
	  	 			jAlert( data.error );
	  	 			return false;
	  	 		}
	  	 		
	  	 	});//<--- Done
	  	 });//<---- * End click * ---->
	  	 
	  	 //<---------- * Remove All Messages * ---------->
	  	 $('.removeAllMsg').live('click',function(){
	  	 	
	  	 	var element = $(this);
	  	 	var data    = element.attr('data');
	  	 	var query   = '_userId='+data;
	  	 	
	  	 	element.parents('li').fadeTo( 200,0.00, function(){
   		             element.parents('li').slideUp( 200, function(){
   		  	           element.parents('li').remove();
   		              });
   		           });
   		           
	  	 	$.ajax({
	  	 		type : 'POST',
	  	 		url  : urlbase+'public/ajax/delete_all_msg.php',
	  	 		dataType: 'json',
	  	 		data : query,
	  	 		
	  	 	}).done(function( data ){
	  	 		
	  	 		if( data.status === 0 ) {
	  	 			jAlert( data.error );
	  	 			return false;
	  	 		}
	  	 		
	  	 	});//<--- Done
	  	 });//<---- * End click * ---->
	  	 
	//<<<--- * Report Post ---->>>>/
	$(".reportPost").live('click',function(){
	var element   = $(this);
	var id        = element.attr("data");
	var token     = element.attr('data-token');
	var info      = '_postId=' + id+'&_token='+token;
	
	element.removeClass( 'reportPost' );

		
		 $.ajax({
		   type: "POST",
		   url: "public/ajax/report_post.php",
		   dataType: 'json',
		   data: info,
		   success: function( data ){
		   	
		   if( data.status == 'ok' ) { 
		   	 $('.popout').html(data.res).fadeIn().delay(2500).fadeOut();
		   } 
		   //<-- IF
			   else
			   {
			   	 jAlert(data.res);
			   	 $('.popout').fadeOut();
			   }
		 }//<-- RESULT 
	   });//<--- AJAX

	 
	
	      
});//<----- CLICK

//<<<--- * Report User ---->>>>/
	$(".report_user_spam").live('click',function(){
	var element   = $(this);
	var id        = element.attr("data-id");
	var info      = '_userId=' + id;
	
	element.removeClass( 'report_user_spam' );
	
		 $.ajax({
		   type: "POST",
		   url: "public/ajax/report_user.php",
		   dataType : 'json',
		   data: info,
		   success: function( data ){
		   	
		   if( data.status == 'ok' ) { 
		   	 $('.popout').html(data.res).fadeIn().delay(2500).fadeOut();
		   } 
		   //<-- IF
			   else
			   {
			   	 jAlert(data.res);
			   	 $('.popout').fadeOut();
			   }
		 }//<-- RESULT 
	   });//<--- AJAX

});//<----- CLICK

//<<<--- * Block User ---->>>>/
	$(".block_user_id").live('click',function(){
	var element   = $(this);
	var id        = element.attr("data-id");
	var info      = '_userId=' + id;
	var timeQuery = 500;
	
	element.removeClass( 'block_user_id' );
	
	setTimeout(function(){
		
		 $.ajax({
		   type: "POST",
		   url: "public/ajax/block_user.php",
		   dataType: 'json',
		   data: info,
		   success: function( data ){
		   
		   if( data.status == 'ok' ) { 
		   	 $('.popout').html(data.res).fadeIn().delay(2500).fadeOut();
		   	 setTimeout(function(){ 
		   	 	window.location.reload();
		   	 },2500 );
		   } 
		   
		   else
			   {
			   	 jAlert(data.res);
			   	 $('.popout').fadeOut();
			   }

		 }//<-- RESULT 
	   });//<--- AJAX

	 
	},timeQuery );
	      
});//<----- CLICK

/*= FOLLOW =*/
	$(".followBtn").live('click',function(){
	var element    = $(this);
	var id         = element.attr("data-id");
	var username   = element.attr("data-username");
	var _follow    = element.attr("data-follow");
	var _following = element.attr("data-following");
	var info       = 'id=' + id;
	var timeQuery  = 1000;
	
	element.removeClass( 'followBtn' );
	//$('.popout').html('Wait...').fadeIn();
	
	if( element.hasClass( 'follow_active' ) ) {
		element.addClass( 'followBtn' );
		   	element.removeClass( 'follow_active unfollow_button' );
		   element.html( _follow );
		   	  
		}
		else {
			
			element.addClass( 'followBtn' );
		   	  element.removeClass( 'follow_active unfollow_button' );
		   	    element.addClass( 'followBtn' );
		   	   element.addClass( 'follow_active' );
		   	  element.html( _following );
		}
		
	setTimeout(function(){
		
		 $.ajax({
		   type: "POST",
		   url: "public/ajax/follow.php",
		   dataType: 'json',
		   data: info,
		   success: function( result ){
		   	
		   	if( result.status == 0 ) { 
		   		element.addClass( 'followBtn' );
			   	  element.removeClass( 'follow_active unfollow_button followBtn' );
			   	   element.html('Follow' );
			   	  element.html( type );
			   	  $('.popout').html( result.error  ).fadeIn()
		   	}
		 }//<-- RESULT 
	   });//<--- AJAX

	 
	},timeQuery );
	      
});//<----- CLICK
		
		//<--------- * See MSG * ------>
		$('.see_msg').live('click',function(e){
			
			e.preventDefault();
			
			var _this     = $(this);
			var id        = _this.attr("data");
			var info      = '_userId=' + id;
			var titleInit = $('.titleBar').attr('data-title');
			var _reply    = _this.attr('data-reply');
			var username  = _this.parents('li').find('.usernameClass').html();
			
			$('.titleBar').html('<a href="'+urlbase+'messages/">'+titleInit+'</a> &rsaquo; ' + username);
			
			 $('.posts').html('');
			 
			 /* Loader */
			var loaderGif = '<div id="container-loader"> <div class="loading-bar"></div> </div>';
			$('.posts').append(loaderGif);
			 
			 $.ajax({
			   type: "POST",
			   url: "public/ajax/get_message_id.php",
			   data: info,
			   success: function( result ){
			   if( result.length > 1 ) {
			   	
			   	 $('#container-loader').remove(); 
			   	 $('.posts').append(result);
			   	 $('<span class="spanStatus replyStatus" style="border: none; padding-top: 0;"> <div class="grid-reply"> <form action="" method="post" accept-charset="UTF-8" id="form_reply_post"> <input type="hidden" name="id_reply" id="id_reply" value="'+id+'"> <textarea name="reply_msg" id="reply_msg"></textarea><div class="counter"></div> <div class="counter"></div> <button id="button-reply-msg" disabled="disabled" style="opacity: 0.5; cursor: default;" type="submit">'+_reply+'</button> </form> </div> </span>').insertAfter('.posts');
			   	 
			   	 jQuery("span.timeAgo").timeago();
			   	 
			   	 var _numElement =  $('.posts > li').length;
			   	 
			   	 if( _numElement > 5 ) {
			   	 	scrollElement( '#reply_msg' );
			   	 } else {
			   	 	$('body,html').animate({
								scrollTop: 0
							}, 500);
			   	 }
			   	    $('#reply_msg').focus();
			   	    $('textarea').autosize(); 
			   	    
			   } else {
				   	 	window.location.reload();
				    	 
				   	 $('.popout').fadeOut();
				   }
			 }//<-- RESULT 
		   });//<--- AJAX
		});//<<<--- Click
	  
	  
	  $('#button-reply-msg').live('click',function(s){
				s.preventDefault();
				
				var element   = $(this);
				var error     = false;
				var _message  = $('#reply_msg').val();
				var saveHtml  = element.html();
			 	var _wait     = '...';
			 	var _saveHtml = saveHtml + _wait;
					
				if( _message == '' && trim( _message ).length  == 0 ) {
					var error = true;
					return false;
				}
				

				if( error == false ) {
					$('#button-reply-msg').attr({'disabled' : 'true'}).html(_saveHtml).css({'opacity':'0.5','cursor':'default'});
					
					$.post("public/ajax/send_message_id.php", $("#form_reply_post").serialize(), function(msg){
						
						if( msg.length != 0 ) {
							$(msg).hide().appendTo('.posts').fadeIn( 800 );
							 $('#reply_msg').val('');
							 $('#button-reply-msg').html(saveHtml);
							 jQuery("span.timeAgo").timeago();
						} 
						
					});//<-- END DE $POST AJAX
				}//<-- END ERROR == FALSE
			});//<<<-------- * END FUNCTION CLICK * ---->>>>


	$('#buttonSearch').click(function(e){			
		var search    = $('#btnItems').val();
		if( trim( search ).length < 1  || trim( search ).length == 0 || trim( search ).length > 100 ) {
			return false;
		} else {
			return true;
			
		}
	});//<--- * FIN FUNCIÓN DE BÚSQUEDA * --->
	
			
	//<------------- * AUTOCOMPLETE * ---------->
$(window).bind("load", function() {
	
$('#btnItems').keyup(function(e){
	
	e.preventDefault();
    e.stopPropagation();
    
    
    var valueClean  = $(this).val().replace(/\#+/gi,'%23');
    var _valueClean = $(this).val().replace(/<(?=\/?script)/ig, "&lt;");
    
    $('.searchGlobal').html( '<a href="search/?q='+trim( valueClean )+'"><i class="searchIco"></i> '+trim( _valueClean )+'</a>' );
			
	//$(this).waiting( 500 ).done(function() {
		 	if( e.which != 16 
		 		&& e.which != 17 
				&& e.which != 18 
				&& e.which != 20 
				&& e.which != 32 
		 		&& e.which != 37 
		 	    && e.which != 38 
		 	    && e.which != 39 
		 	    && e.which != 40 
		 	    ) {
     		 	$('.toogle_search > li.list').remove();
     		 	
			}
    		
			var $element     = $(this);
			var inputOutput  = $element.val();
			var value        = inputOutput.replace(/\s+/gi,' ');
     		
     				
     		// || e == ''
			if( trim( value ).length == 0 || trim( value ).length >= 50  ) {
				$('.boxSearch').slideUp( 1 );
			} else if( e.which == 16 
				|| e.which == 17 
				|| e.which == 18 
				|| e.which == 20 
				|| e.which == 32 
				|| e.which == 37 
				|| e.which == 38 
				|| e.which == 39 
				|| e.which == 40 
				) {
				return false;
			} else {

					
				
			$(this).waiting( 500 ).done(function() {
				
				$.get("public/ajax/autocomplete.php", { look : trim( value ) }, function( sql ) {
				
					if ( sql != '' ) {
						$('.toogle_search > li.list').remove();
						$( sql ).hide().appendTo('.toogle_search').slideDown( 1 );
						
  							
					}
					//<-- * TOTAL LI * -->
					var total   = $('.toogle_search > li').length;
					
					$('.boxSearch').slideDown( 1 );
				
				});
				});//<----- * WAITING * ---->
				
			}
			
		 //});//<----- * WAITING * ---->
				
			$(document).bind('click', function(ev) {
			var $clicked = $(ev.target);
			if ( !$clicked.parents().hasClass("boxSearch") && !$clicked.hasClass("mention") )
			{
				$(".boxSearch").slideUp( 5 );
			}
	 		});//<-------- * FIN CLICK * --------->
	    
   });//<--------- * END KEYUP * ------>
});//<----------- * DOM LOAD  * --------->

$('.openModal').live('click',function(e){
 	
 	e.preventDefault();
    e.stopPropagation();
    
    $('.content_user').html('');
    
    $('.content_user').append('<div class="preload_profile"></div>');
    
    //<--- VARS
    var element   = $(this);
    var param     = /^[0-9]+$/i;
    var _document = $('body');
    var userId    = element.attr('data-id');
	
	if( !param.test( userId ) ) {
		return false;
	}
	setTimeout(function() {
		$.get("public/ajax/profile_summary.php", { id_user : userId }, function( response ) {
		
		if ( response ) {
			
				$('.preload_profile').remove();
			if( response.status == 1 ) {
				$('.content_user').hide().html( response.html ).slideDown( 500 );
				$('.west').tipsy({gravity: 'w'});
				
				
			} else {
				$('.content_user').append('<div class="error_show">'+response.html+'</div>');
				element.removeAttr('data-id')
				}		
		}//<-- DATA 
	},'json'); 
	
	}, 500 );
	
 	$('#container_popout').show();// Show Container Popout
 	$('.popoutUser').fadeIn();

	    _document.addClass('scroll_none_popout');
	    
	    _document.keydown(function (event) {
	     if( event.which  == 27  )
	     {
	     _document.removeClass('scroll_none_popout').removeAttr('class');
	     $('#container_popout').hide();
	 	 $('.popoutUser').fadeOut();
	    }
	});//======== FUNCTION 
	
	
     		
});//<----------- *  End Click * ------------->
 
 //**** close click
 $('#container_popout, .close_popout').live('click',function(e){
 	$('body').removeClass('scroll_none_popout').removeAttr('class');
		 $('#container_popout').hide();
		 $('.popoutUser').fadeOut();
 });
 
 
 /* Reposition Modal */
 function _reposition(){
				
	var verticalOffset = -75;
	
	var left = (($(window).width() / 2) - ($(".popoutUser").outerWidth() / 2));
	if( left < 0 ) { left = 0; }

	
	$(".popoutUser").css({
		left: left + 'px'
	});
}
	//<--- * REPOSITION POPOUT * ---->
   _reposition();
   $(window).bind('resize', _reposition );
		
});//<------------ * DOM * ------------>