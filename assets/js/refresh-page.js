$.access_token = '';
function set_access_token(token)
{
	$.access_token = token;
}

function general_refresh_page()
{
	var refreshUrl = laravel_base;
	var refreshSuccess = false;

	if (typeof(Storage) !== "undefined") {
		var ajaxRequestUrl = sessionStorage.getItem('ajaxRequestUrl');

		if (ajaxRequestUrl != null)
		{
			refreshUrl = ajaxRequestUrl;
		}

		$.loaded = true;

		$.ajax({
			type: 'get',
			url : refreshUrl,
			data : {'access_token' : $.access_token},
			beforeSend: function(){
				// closing modal sebelum refresh page
				claravel_modal_close('modal_notif');

				loading('utama');
				if (typeof preloader !== 'undefined')
				{
					preloader.on();
					$.loaded = true;
					//return true; // lanjutkan send
				}
				else
				{
					$.loaded = false;
				}
				//window.location.reload();
				//return false; // abort send
			},
			success: function(data) {
				if($.loaded)
				{
					$('#utama').html(data);
				}
				else
				{
					window.location.reload();
				}
			},
			complete: function(){
				if (typeof preloader !== 'undefined')
				{
					preloader.off();
				}
			}
		});
	}
	else
	{
		window.location.reload();
	}
}

document.onkeydown = function(e) {
	var keys = {116:1}; // F5

	if (keys[e.keyCode]) {
		e = e || window.event;
		if (e.preventDefault) e.preventDefault();
		e.returnValue = false;
		return false;
	}
}

window.onkeyup = function(e) {
	var key = e.keyCode ? e.keyCode : e.which;

	// F5 key pressed
	if (key == 116) {
		if (typeof general_refresh_page === "function") {
			general_refresh_page();
		}
		else if (typeof refresh_page === "function") {
			refresh_page();
		}
		else {
			window.location.reload();
		}
	}
}
