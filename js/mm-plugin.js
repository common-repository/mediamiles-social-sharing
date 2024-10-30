
/*--------- MediaMiles Jquery File----------------*/
	function mediamiles_redirect(url)
	{
		location.assign(url);
	}

/*--------- Code for error Notification */
	function showError(txt){
		jQuery('.l_error p').text(txt);
		jQuery('.l_error').slideDown();
		setTimeout(function(){jQuery('.l_error').slideUp('slow')}, 3000);
	}
	
/*---------  Validation and for Laudd Registration*/
	function validate()
	{
		var site_id = jQuery('#mediamiles_site_id').val();	
		var redirect_page = jQuery('#thanks-redirect-page').val();	
		var redirect_cancel_url = jQuery('#redirect-cancel-url').val();
		if (site_id == ''){
			showError("Please enter a valid Site ID.");
			jQuery('#mediamiles_site_id').focus();
			return false;
		} else {
			jQuery.ajax({
				type: "POST",
				url: ajaxurl,
				data:"site_id=" + site_id + "&action=check_mediamiles_site_id_status",
				beforeSend: function() {
					jQuery('#submit_site_id').val('Loading...');
				},
				success: function(data) {
					jQuery('#submit_site_id').val('Submit');
					if( data == 1){
						window.location.href= redirect_page; 
					} else {
						showError("Please enter a valid Site ID.");
					}
				}
			});
			return false;
		}
	}

