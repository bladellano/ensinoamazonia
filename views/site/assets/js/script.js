$(function () {

	/* Jquery Validate */

	$('#phone').mask('(00) 00000-0000');

	$('#form-contato').validate({
		rules: {
			name: {
				required: true,
				maxlength: 100,
				minlength: 3,
				minWords: 2
			},
			email: {
				required: true,
				email: true,
			},
			phone: {
				required: true,
				minlength: 15,
			},
			message: {
				required: true,
				minlength: 3,
			}
		},
		submitHandler: function () {

			var data = $('#form-contato').serializeArray();

			ajaxSubmitFormContact(data);
		}
	});

	const ajaxSubmitFormContact = (data) => {

		$.ajax({
			method: "POST",
			url: "/send-form-contact",
			data: data,
			dataType: "json",
			beforeSend: function () {
				load('open');
			},
			success: function (r) {
				if (r.success) {
					Swal.fire(
						'Tudo certo!',
						r.msg,
						'success'
					);
					$('#form-contato')[0].reset();
				} else {
					Swal.fire(
						'Ooops!',
						r.msg,
						'error'
					);
				}
			},
			complete: () => {
				load('close');
			}
		});

	}

	/* Botão que surge no rodapé p/ levar até o topo.*/
	$(window).scroll(function (e) {
		if ($(this).scrollTop() > 2500) {
			$('.topo').fadeIn();
		} else {
			$('.topo').fadeOut();
		}
	});

	$('.topo').click(function (e) {
		e.preventDefault();
		$('html, body').animate({
			scrollTop: 0
		}, 500)
	});

	/* Scrolling navegation site */
	var scrollLink = $('.scroll');

	scrollLink.click(function (e) {
		if (!$(this.hash).length)/* Retorna ao index se não encontrar ids */
			return location.href = location.href.match(/^http.*?.\w\//m)[0];

		e.preventDefault();

		$('body,html').animate({//this.hash - pega o valor do atributo id
			scrollTop: $(this.hash).offset().top
		}, 220)
	});

	/* Fixed top menu */
	$(window).scroll(function () {

		if ($(this).scrollTop() > $('#header-top').height()) {
			$('#navbar_top').addClass("fixed-top");
			$('body').css('padding-top', $('.navbar').outerHeight() + 'px');
		} else {
			$('#navbar_top').removeClass("fixed-top");
			$('body').css('padding-top', '0');
		}
	});


	/* Customização do efeito Collapse */
	$('.collapse.content--faq').on('show.bs.collapse', function () {
		var button = $('a[data-target="#' + $(this).attr('id') + '"]');
		button.addClass('active');
		button.find('div').eq(1).html('-');
	});

	$('.collapse.content--faq').on('hidden.bs.collapse', function () {
		var button = $('a[data-target="#' + $(this).attr('id') + '"]');
		button.removeClass('active');
		button.find('div').eq(1).html('+');
	});

	/* Slick */
	$('.slick-eventos').slick({
		infinite: true,
		slidesToShow: 3,
		slidesToScroll: 3,
		arrows: false,
		responsive: [
			{
				breakpoint: 768,
				settings: {
					arrows: false,
					centerMode: true,
					centerPadding: '40px',
					slidesToShow: 3
				}
			},
			{
				breakpoint: 480,
				settings: {
					arrows: false,
					centerMode: true,
					centerPadding: '40px',
					slidesToShow: 1
				}
			}
		]
	});

	$('#slick-left').click(function () {
		$('.slick-eventos').slick('slickPrev');
	});
	$('#slick-right').click(function () {
		$('.slick-eventos').slick('slickNext');
	});

}); //End script

/*Function of loading*/
function load(action) {
	var load_div = $('.ajax_load');
	if (action === 'open') {
		load_div.fadeIn().css('display', 'flex');
	} else {
		load_div.fadeOut();
	}
}