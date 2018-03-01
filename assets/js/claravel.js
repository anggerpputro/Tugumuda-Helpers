$(document).ready(function(){
   	$('.sidebar-menu').on('click','a#menu-mhs',function(e){
       var str = $(this).attr('href');
       var n = str.search("dashboard");
       loading('inner_utama');
       if(n > 0){
       }
       else{
           	e.preventDefault();
           	e.stopImmediatePropagation();
          	preloader = new $.materialPreloader({
			    position: 'top',
			    height: '5px',
			    col_1: '#159756',
			    col_2: '#da4733',
			    col_3: '#3b78e7',
			    col_4: '#fdba2c',
			    fadeIn: 200,
			    fadeOut: 200
			});

            $.ajax({
                type: 'get',
                url : $(this).attr('href'),
                beforeSend: function(){
                	preloader.on();
                },
                success: function(data) {
                	preloader.off();
                    $('#utama').html(data);
                }
            });
       }
   	});

   	$('.sidebar-menu').on('click','a#menu-akhir',function(e){
       var str = $(this).attr('href');
       var n = str.search("dashboard");
       loading('utama');
       if(n > 0){
       }
       else{
           	e.preventDefault();
           	e.stopImmediatePropagation();
          	preloader = new $.materialPreloader({
			    position: 'top',
			    height: '5px',
			    col_1: '#159756',
			    col_2: '#da4733',
			    col_3: '#3b78e7',
			    col_4: '#fdba2c',
			    fadeIn: 200,
			    fadeOut: 200
			});

			// var untuk nyimpen this element, biar bisa dibaca di ajax
			var menu_akhir = $(this);

            $.ajax({
                type: 'get',
                url : $(this).attr('href'),
                beforeSend: function(){
                	preloader.on();

					// remove class active di semua <li>
					$(".sidebar-menu li").removeClass("active");
                },
                success: function(data) {
                    $('#utama').html(data);
                },
				complete: function(){
					preloader.off();

					// add class active di current li
					menu_akhir.parent().addClass('active');
					menu_akhir.parent().parent().parent().addClass('active');
				}
            });
       }
   	});
});

$(function () {

	$(document).ajaxSend(function(event, request, settings) {
//            $('#utama').fadeOut(400);
//               $('#utama').hide();
//    	$('#loading').show();

		// jika type request == get
		if (settings.type.toLowerCase() == 'get')
		{
			// save request url ke sessionStorage
			if (typeof(Storage) !== "undefined") {
				sessionStorage.setItem('ajaxRequestUrl', settings.url);
			} else {
				// Sorry! No Web Storage support..
			}
		}
	});
	//Tampilkan error di modal saja
	$(document).ajaxError(function(event, request, settings) {
		claravel_modal('Wooops..something wrong bro',request.responseText,'modal_notif');
		console.error(request.responseText);
	});
	$(document).ajaxComplete(function(event, request, settings) {
		// untuk ngilangin preloader mau ajax sucess ataupun error
		if (typeof preloader !== 'undefined')
		{
			preloader.off();
		}
	});

//	$(document).on("submit", ".form-ajaxin", function(){
//		$.ajax({
//	        type: $(this).attr('method'),
//	        url : $(this).attr('action'),
//	        data : $(this).serialize(),
//	        success: function(data) {
//	         	$('#utama').html(data);
//	         	$('select').select2({
//			   		width: 250
//			    });
//			    $('.ttp').tooltip();
//	        }
//	    });
//		return false;
//	});
//
//	$(document).on("click", ".ajaxin", function(){
//		$.ajax({
//	        type: "GET",
//	        url : $(this).attr('href'),
//	        success: function(data) {
//	         	$('#utama').html(data);
//	         	$('select').select2({
//			   		width: 250
//			    });
//			    $('.ttp').tooltip();
//	        }
//	    });
//		return false;
//	});

	$(document).on("click", ".pagination > li > a", function(){
		$.ajax({
	        type: "GET",
	        url : $(this).attr('href'),
	        success: function(data) {
	         	$('#utama').html(data);
	         	$('select').select2({
			   		width: 250
			    });
			    $('.ttp').tooltip();
	        }
	    });
		return false;
	});


	$('select').select2({
   		width: 250
    });

	$(document).on("click", "#checkall", function(){
	    $('input:checkbox').not(this).prop('checked', this.checked);
	});

	$(document).on("click", "a.del", function(){
	    var index = $('a.del').index( this );
	    index = index + 1;
	    $('input:checkbox').eq( index ).prop('checked', 'checked');
	    $(this).closest('form').submit();
	    return false;
	});

	$(document).on("click", "#nav-toggle", function(){
          $('.dropdown').data('closable', true);
          if ($('#nav_sidebar').hasClass('sidebar-mini')){
              //set big
              $('#nav_sidebar').removeClass('sidebar-mini');
              $('#nav_sidebar').addClass('sidebar');
              $('#utama').removeClass('col-md-12');
              $('#utama').addClass('col-md-10');
              $('#utama').css('padding-left','20px');
              $('.header-main').hide();
          }else{
              ///set mini
              $('#nav_sidebar').removeClass('sidebar');
              $('#nav_sidebar').addClass('sidebar-mini');
              $('#utama').removeClass('col-md-10');
              $('#utama').addClass('col-md-12');
              $('#utama').css('padding-left','67px');
              $('.header-main').show();
          }
      });

    $('.dropdown').on({
        "shown.bs.dropdown": function() { $(this).data('closable', false); },
        "click":             function() { $(this).data('closable', true);  },
        "hide.bs.dropdown":  function() { return $(this).data('closable'); }
    });

       $('#nav-toggle').trigger('click');
	$('.ttp').tooltip();
});

function url(name) {
    name = name.toLowerCase(); // lowercase
    name = name.replace(/^\s+|\s+$/g, ''); // remove leading and trailing whitespaces
    name = name.replace(/\s+/g, '-'); // convert (continuous) whitespaces to one -
    name = name.replace(/[^a-z-]/g, ''); // remove everything that is not [a-z] or -
    return name;
}

function autoComplete(element, url, ph, dataPost){
	$(element).select2({
        placeholder: ph,
        minimumInputLength: 1,
        allowClear: true,
        width: '100%',
	    ajax: {
	      url: url,
	      dataType: 'json',
	      type:'POST',
	      data: function (term, page) {
	      	dt = {'q': term};
	        return $.extend(dt, dataPost);
	      },
	      results: function (data, page) {
	        return { results: data };
	      }
	    }
    });
}
