var urlbase    = $('base').attr('href');

/*================================================== LOGIN ===========================================*/
	jQuery.fn.reset = function () {
	$(this).each (function() { this.reset(); });
	}
$(document).ready(function(){
			
	        var param = /^[a-z0-9\_]+$/i;
			$('#buttonLogin').click(function(e){
				
				e.preventDefault();

				var error   = false;
				var usr    = $('#usr').val();
				var pass    = $('#pass').val();

				if(  usr.length == 0 || !param.test(usr) ){
					var error = true;
					$('#usr').focus();
				}
				
				else if ( pass == 0 || pass.length == 0 || pass.length < 4 )
				{
					var error = true;
					$('#pass').focus();
				}

				if( error == false ){

					$('#buttonLogin').attr({'disabled' : 'true'}).html('Please wait...').css({'opacity':'0.5'});

					$.post( urlbase + "public/ajaxAdmin/login.php", $("#access").serialize(),function(result){
						if( result == 'true' ){ 
							$('#buttonLogin').attr({'disabled' : 'true'}).remove();
							
							 $('.form_login').remove();
							$('#errores').fadeOut(500);

							setTimeout(function(){
								window.location.reload();
								
								},200);
							
						}
						else{
							$('#error').html( result ).slideDown();
							$('#buttonLogin').removeAttr('disabled').html('Log in <i class="glyphicon glyphicon-log-in">').css({'opacity':1});
							$("#usr,#pass").attr({'value': ''});
							
						}          //ELSE
					});      //
				}      //
			});    //

});//<================================== DOCUMENT READY ===============================> 