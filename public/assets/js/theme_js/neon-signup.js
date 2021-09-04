/**
 *	Neon Signup Script
 *
 *	Developed by IT Graduate
 */

var neonSignup = neonSignup || {};

;(function($, window, undefined)
{
	"use strict";
	
	$(document).ready(function()
	{
		neonSignup.$container = $("#form_signup");
		neonSignup.$steps = neonSignup.$container.find(".form-steps");
		neonSignup.$steps_list = neonSignup.$steps.find(".step");
		neonSignup.step = 'step-1'; // current step


		neonSignup.$container.validate({
			rules: {
				FirstName: {
                    required: true
                },
                LastName: {
                    required: true
                },
                CompanyName: {
                    required: true
                },
				AddressLine1: {
					required: true
				},
				City: {
					required: true
				},
				PostZipCode: {
					required: true
				},
				Country:{
                	required: true
				},
				Email: {
					required: true,
					email: true
				},
				Password: {
					required: true
				}
				
			},
			
			messages: {
				
				email: {
					email: 'Invalid E-mail.'
				}	
			},
			
			highlight: function(element){
				$(element).closest('.input-group').addClass('validate-has-error');
			},
			
			
			unhighlight: function(element)
			{
				$(element).closest('.input-group').removeClass('validate-has-error');
			},
			
			submitHandler: function(ev)
			{
				$(".login-page").addClass('logging-in');
				
				// We consider its 30% completed form inputs are filled
				neonSignup.setPercentage(30, function()
				{
					// Lets move to 98%, meanwhile ajax data are sending and processing
					neonSignup.setPercentage(98, function()
					{
                        //var formData = $("#form_signup").serializeArray();

                        // Send data to the server
						$.ajax({
							url: baseurl + '/doSignup',
							method: 'POST',
							dataType: 'json',
							data: {
								FirstName:    $("#FirstName").val(),
								LastName: 	  $("#LastName").val(),
                                CompanyName:  $("#CompanyName").val(),
								AddressLine1: $("#AddressLine1").val(),
								AddressLine2: $("#AddressLine2").val(),
								AddressLine3: $("#AddressLine3").val(),
								City:         $("#City").val(),
								PostZipCode:  $("#PostZipCode").val(),
								Country:      $("#Country").val(),
                                Email:        $("#Email").val(),
                                Password:     $("#Password").val()
                            },
							error: function(error)
							{
                                console.log(error);
								//alert("An error occoured!");
							},
							success: function(response)
							{
                                console.log(response);

                                $(".form-login-error").hide();
                                $(".form-signup-success").hide();

                                if(response.status == 'success'){

									neonSignup.setPercentage(100);
                                    // We will give some time for the animation to finish, then execute the following procedures
                                    setTimeout(function()
                                    {
                                        // Hide the description title
                                        $(".login-page .login-header .description").slideUp();

                                              // Remove loging-in state
                                            $(".login-page").removeClass('logging-in');

                                            // Now we show the success message
                                            $(".form-signup-success").slideDown('normal');

                                            // You can use the data returned from response variable

                                    }, 1000);

                                }else{
                                        console.log(response);
                                        $(".form-login-error p").html("");
                                        // If login is invalid, we store the
                                        $(".login-page").removeClass('logging-in');
                                        $(".form-login-error p").html(response.message);


                                        neonLogin.resetProgressBar(true);

                                }

							}
 						});
					});
				});
			}
		});
	
		// Steps Handler
		/*neonSignup.$steps.find('[data-step]').on('click', function(ev)
		{
			ev.preventDefault();
			
			var $current_step = neonSignup.$steps_list.filter('.current'),
				next_step = $(this).data('step'),
				validator = neonSignup.$container.data('validator'),
				errors = 0;
			
			neonSignup.$container.valid();
			errors = validator.numberOfInvalids();
			
			if(errors)
			{
				validator.focusInvalid();
			}
			else
			{
				var $next_step = neonSignup.$steps_list.filter('#' + next_step),
					$other_steps = neonSignup.$steps_list.not( $next_step ),
					
					current_step_height = $current_step.data('height'),
					next_step_height = $next_step.data('height');
				
				TweenMax.set(neonSignup.$steps, {css: {height: current_step_height}});
				TweenMax.to(neonSignup.$steps, 0.6, {css: {height: next_step_height}});
				
				TweenMax.to($current_step, .3, {css: {autoAlpha: 0}, onComplete: function()
				{
					$current_step.attr('style', '').removeClass('current');
					
					var $form_elements = $next_step.find('.form-group');
					
					TweenMax.set($form_elements, {css: {autoAlpha: 0}});
					$next_step.addClass('current');
					
					$form_elements.each(function(i, el)
					{
						var $form_element = $(el);
						
						TweenMax.to($form_element, .2, {css: {autoAlpha: 1}, delay: i * .09});
					});
					
					setTimeout(function()
					{
						$form_elements.add($next_step).add($next_step).attr('style', '');
						$form_elements.first().find('input').focus();
						
					}, 1000 * (.5 + ($form_elements.length - 1) * .09));
				}});
			}
		});*/
		
		/*neonSignup.$steps_list.each(function(i, el)
		{
			var $this = $(el),
				is_current = $this.hasClass('current'),
				margin = 20;
			
			if(is_current)
			{
				$this.data('height', $this.outerHeight() + margin);
			}
			else
			{
				$this.addClass('current').data('height', $this.outerHeight() + margin).removeClass('current');
			}
		});*/
		
		
		// Login Form Setup
		neonSignup.$body = $(".login-page");
		neonSignup.$login_progressbar_indicator = $(".login-progressbar-indicator h3");
		neonSignup.$login_progressbar = neonSignup.$body.find(".login-progressbar div");

		neonSignup.$login_progressbar_indicator.html('0%');
		
		if(neonSignup.$body.hasClass('login-form-fall'))
		{
			var focus_set = false;
			
			setTimeout(function(){
				neonSignup.$body.addClass('login-form-fall-init')
				
				setTimeout(function()
				{
					if( !focus_set)
					{
						neonSignup.$container.find('input:first').focus();
						focus_set = true;
					}
					
				}, 550);
				
			}, 0);
		}
		else
		{
			neonSignup.$container.find('input:first').focus();
		}

		
		
		// Functions
		$.extend(neonSignup, {
			setPercentage: function(pct, callback)
			{
				pct = parseInt(pct / 100 * 100, 10) + '%';
				
				// Normal Login
				neonSignup.$login_progressbar_indicator.html(pct);
				neonSignup.$login_progressbar.width(pct);
				
				var o = {
					pct: parseInt(neonSignup.$login_progressbar.width() / neonSignup.$login_progressbar.parent().width() * 100, 10)
				};
				
				TweenMax.to(o, .7, {
					pct: parseInt(pct, 10),
					roundProps: ["pct"],
					ease: Sine.easeOut,
					onUpdate: function()
					{
						neonSignup.$login_progressbar_indicator.html(o.pct + '%');
					},
					onComplete: callback
				});
			},
        });
	});
	
})(jQuery, window);