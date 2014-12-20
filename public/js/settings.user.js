var urlbase    = $('base').attr('href');
//=========== TRIM
function trim ( cadena )
{
	return cadena.replace(/^\s+/g,'').replace(/\s+$/g,'')
}
//** FILTERS **//
var filter     = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
var param_usr  = /^[a-zA-Z0-9\_]+$/;
//** Changes Form **//
function changesForm () {
var button = $('#editProfile');
$('form.formAjax input, select, textarea, checked').each(function () {
    $(this).data('val', $(this).val());
    $(this).data('checked', $(this).is(':checked'));
});


$('form.formAjax input, select, textarea, checked').bind('keyup change blur', function(){
    var changed  = false;
    var ifChange = false;
    button.css({'opacity':'0.5','cursor':'default'});
    
    $('form.formAjax input, select, textarea, checked').each(function () {
        if( trim( $(this).val() ) != $(this).data('val') || $(this).is(':checked') != $(this).data('checked') ){
            changed = true;
            ifChange = true;
            button.css({'opacity':'1','cursor':'pointer'})
        }
       
    });
    button.prop('disabled', !changed);
});
}//<<<--- Function
changesForm();

//<<<<--- * Options Mosaic * ---->>>>
$('#mosaic').click(function(){
	
	if( $(this).is(':checked') ) 
	{
		$(this).val('fixed')
		$('body').css({'background-attachment': 'fixed','background-repeat':'repeat repeat'});
	}
	else
	{
		$(this).val('scroll')
		$('body').css({'background-attachment': 'scroll','background-repeat':'no-repeat no-repeat'});
	}
});
//<<<-- Pos --->>>>
$('.radioIn').click(function(){
	
	if( $(this).is(':checked') && $(this).val() == 'left' ) 
	{
		$('body').css({'background-position': 'left 65px'});
	}
	else if( $(this).is(':checked') && $(this).val() == 'center' ) 
	{
		$('body').css({'background-position': 'center 65px'});
	}
	else if( $(this).is(':checked') && $(this).val() == 'right' )
	{
		$('body').css({'background-position': 'right 65px'});
	}
});

$(document).ready(function(){
	
	 //<<---------------- * Profile * -------------->>
	 $('.profile-settings').live('click',function(e){
	 	
	 	e.preventDefault();
	 	var name = $('#nameEdit').val();
	 	var saveHtml = $(this).html();
	 	var _wait    = '...';
	 	var _saveHtml = saveHtml + _wait;
	 	
	 	if( name == '' || name == 0 || trim( name ).length == 0 )
	 	{
			var error = true;
			$('#nameEdit').focus();
			return false;
		}
		else {
				$('.profile-settings').attr({'disabled' : 'true'}).html(_saveHtml).css({'opacity':'0.5'});
				$.post(urlbase+"public/ajax/settings_profile.php", $("#formSettings").serialize(),function(data) {
				
				if( data.response == 'true' ) {
					$('.popout').html(data.save_success).fadeIn(200).delay(2500).fadeOut(200);
					$('.profile-settings').html(saveHtml);
					changesForm();
				} else {
					$('.popout').html(data.response).fadeIn(200).delay(7000).fadeOut(200);
					$('.profile-settings').html(saveHtml);
					changesForm();
				}
			}, 'json');//<<<--- * POST * --->>>
		}//<<<--- * ELSE * --->
	 });//<<---- * CLICK * --->
	 
	 
	 //<<---------------- * Settings * -------------->>
	 $('.profile-settings-account').live('click',function(e){
	 	
	 	e.preventDefault();
	 	var username  = $('#username').val();
		var email     = $('#email').val();
		var saveHtml  = $(this).html();
	 	var _wait     = '...';
	 	var _saveHtml = saveHtml + _wait;
	 	
	 	if( username == 0 || trim( username ).length == 0 ) {
			var error = true;
			$('#username').focus();
			return false;
	    } else if( email.length == 0 ) {
			var error = true;
			$('#email').focus();
			return false;
		} else {
			$('.profile-settings-account').attr({'disabled' : 'true'}).html(_saveHtml).css({'opacity':'0.5'});
			$.post(urlbase+"public/ajax/settings_account.php", $("#formSettings").serialize(),function( data )
			{
				var urlGo = urlbase + 'settings/';
				
				if( data.action == 'true' )
				{
					$('.popout').html(data.output).fadeIn(200).delay(2500).fadeOut(200);
					$('.profile-settings-account').html(saveHtml);
					
					if( data.user == 1  ) {
						$('.myprofile').attr({href: urlbase+data.new_user})
					}
					
					if( data.langChange == 1 ) {
						setTimeout(function(){
							window.location.href = urlGo;
						}, 1500 );
					}
					
					changesForm();
					$('.error-update').fadeOut();
				} else {

					$('.error-update').html( data.action ).fadeIn(200);
					$('.profile-settings-account').html(saveHtml);
					
					if( data.focus ) {
						$('#'+data.focus).focus();
					}
					
					changesForm();
				}
			},'json');//<<<--- * POST * --->>>
		}//<<<--- * ELSE * --->
	 });//<<---- * CLICK * --->
	 
	 
	 //<<---------------- * Passwords * -------------->>
	 $('.profile-settings-password').live('click',function(e){
	 	
	 	e.preventDefault();
	 		
	 		var saveHtml  = $(this).html();
		 	var _wait     = '...';
		 	var _saveHtml = saveHtml + _wait;
	 	
			$('.profile-settings-password').attr({'disabled' : 'true'}).html(_saveHtml).css({'opacity':'0.5'});
			$.post(urlbase+"public/ajax/update_pass.php", $("#formSettings").serialize(),function( data )
			{
				if( data.response == 'true' )
				{
					$('.popout').html( data.save_success ).fadeIn(200).delay(2500).fadeOut(200);
					$('.profile-settings-password').html(saveHtml);
					$("#formSettings input").val('');
					
					changesForm();
					$('.error-update').fadeOut();
				}
				else
				{
					$('.error-update').html( data.response ).fadeIn(200);
					if( data.focus ) {
						$('#'+data.focus).focus();
					}
					
					$('.profile-settings-password').html(saveHtml);
				}
			},'json');//<<<--- * POST * --->>>
	 });//<<---- * CLICK * --->
	 
	 //<<<<----- Change Theme ------>>>>>
	 $(".themeChange").live('click',function(){ 
			//=== PARAM
			var element     = $(this);
			var id          = element.attr("data");
			var info        = 'theme_id=' + id;
			var dataStatus  = element.attr("data-status");
			
			if( dataStatus != 1 )
			{
				
				$('.themeChange').attr( 'data-status', 0 );
				$(".themeChange").css({border: 'none'});
				element.attr( 'data-status', 1 );

				$.ajax({
				   type: "POST",
				   dataType : 'json',
				   url: urlbase+"public/ajax/themes.php",
				   data: info,
				   success: function( data ){
				   if( data )
				   {
				   	if( data.session == 0 )
				   	{
				   		window.location.reload();
				   	}
				   	$('#loader_gif').remove();
				   	$('<div class="deleteBg" data-id="'+data.theme+'" style="background: none; cursor: pointer;" title="Delete Image" id="loader_gif"></div>').appendTo('.labelAvatar');
				   	$('body,.labelAvatar').css({backgroundImage:'url("public/backgrounds/'+data.theme+'")'});
						   }
						}//<-- OUTPUT
					});//<-- AJAX
			  }//<<-- Active
			  else
			  {
			  	return false;
			  }
			});//<<<<<<<--- * CLICK * --->>>>>>>>>>>
	
	//===== DELETE PHOTO
		$(".deleteBg").live('click',function(){ 
			//=== PARAM
			var element     = $(this);
			var id          = element.attr("data");
			var bg          = element.attr("data-id");
			var info        = 'id_session=' + id + '&bg='+bg;
			$.ajax({
			   type: "POST",
			   url: urlbase+"public/ajax/no_bg.php",
			   data: info,
			   success: function( output ){
			   if( output == 'TRUE' )
			   {
			   		$('body,.labelAvatar').css({backgroundImage:'none'});
			   	     element.fadeOut('fast',function(){
		   		      element.remove();
		   		});//<-- FUNCTION
					   }
					 }//<-- OUTPUT
				});//<-- AJAX
			});//<<<<<<<--- * CLICK * --->>>>>>>>>>>
			
			
			//<<---------------- * Design Settings * -------------->>
	 $('.profile-settings-design').live('click',function(e){
	 	
	 	e.preventDefault();
	 	
	 	var saveHtml  = $(this).html();
	 	var _wait     = '...';
	 	var _saveHtml = saveHtml + _wait;
	 	$('.profile-settings-design').attr({'disabled' : 'true'}).html(_saveHtml).css({'opacity':'0.5'});
			$.post(urlbase+"public/ajax/settings_design.php", $("#formSettings").serialize(),function( data ) {
				if( data.session == 0 ) { 
					window.location.reload();
					}
				if( data.action == 'true' ) {
					$('.profile-settings-design').removeAttr('disabled').css({'opacity':1}).html(saveHtml);
					$('.popout').html( data.save_success ).fadeIn(200).delay(2500).fadeOut(200);
					
				} else {
					$('.popout').html( data.action ).fadeIn(200);
					$('.profile-settings-design').removeAttr('disabled').css({'opacity':1}).html(saveHtml);
				}
			},'json');//<<<--- * POST * --->>>
		
	 });//<<---- * CLICK * --->
			
});//<<--------------------- * DOM * -------------------->>
