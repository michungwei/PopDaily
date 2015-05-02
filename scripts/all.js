function MM_swapImgRestore() { //v3.0
	var i, x, a = document.MM_sr;
	for (i = 0; a && i < a.length && (x = a[i]) && x.oSrc; i++) x.src = x.oSrc;
}

function MM_preloadImages() { //v3.0
	var d = document;
	if (d.images) {
		if (!d.MM_p) d.MM_p = new Array();
		var i, j = d.MM_p.length,
			a = MM_preloadImages.arguments;
		for (i = 0; i < a.length; i++)
			if (a[i].indexOf("#") != 0) {
				d.MM_p[j] = new Image;
				d.MM_p[j++].src = a[i];
			}
	}
}

function MM_findObj(n, d) { //v4.01
	var p, i, x;
	if (!d) d = document;
	if ((p = n.indexOf("?")) > 0 && parent.frames.length) {
		d = parent.frames[n.substring(p + 1)].document;
		n = n.substring(0, p);
	}
	if (!(x = d[n]) && d.all) x = d.all[n];
	for (i = 0; !x && i < d.forms.length; i++) x = d.forms[i][n];
	for (i = 0; !x && d.layers && i < d.layers.length; i++) x = MM_findObj(n, d.layers[i].document);
	if (!x && d.getElementById) x = d.getElementById(n);
	return x;
}

function MM_swapImage() { //v3.0
	var i, j = 0,
		x, a = MM_swapImage.arguments;
	document.MM_sr = new Array;
	for (i = 0; i < (a.length - 2); i += 3)
		if ((x = MM_findObj(a[i])) != null) {
			document.MM_sr[j++] = x;
			if (!x.oSrc) x.oSrc = x.src;
			x.src = a[i + 2];
		}
}

function scrollTop(className) {
	$(className).click(function() {
		$('html, body').animate({
			"scrollTop": "0px"
		}, 500);
	});
}
//index page, unlimited
function popupDiv_index(div_id)
{
		var div_obj = $("#"+ div_id);
		$("#mask").show();
		$(div_obj).removeClass('hidden-mobile');
		$(div_obj).fadeIn();
		enableGta();
		$(".popupBox-close").delay(2000).show(0);
}
//article page
function popupDiv(div_id)
{
	var date = new Date();
	if( !$.cookie('popdaily_mask') && jQuery(window).width() <= 767)
	{
		date.setTime( date.getTime() + ( 60 * 60 * 1000) );
		if(console) {console.log(date);}

		$.cookie( 'popdaily_mask', 'yes', { expires : date } );
		var div_obj = $("#"+ div_id);
		$("#mask").show();
		$(div_obj).removeClass('hidden-mobile');
		$(div_obj).fadeIn();
        enableGta();
		$(".popupBox-close").delay(2000).show(0);
		if(console) {console.log(".popupBox-close delay show");}
	}
	/*var div_obj = $("#"+ div_id);
		$(div_obj).removeClass('hidden-mobile');
		$(div_obj).delay(2000).fadeIn('fast', function() {
			$("#mask").show();
			$('.popupBox-close').show();
		});*/
}

function enableGta()
{
    $('div[id^="div-gpt-ad-"]').each(function() {
        var div_id = this.getAttribute('id'),
            gtd = '<scr' + 'ipt type="text/javascript">'
                + 'googletag.cmd.push(function() { googletag.display("' + div_id + '"); });'
                + '</scr' + 'ipt>';
               
        $('#' + div_id).html(gtd);
    });
}

function hideDiv(div_id)
{
	$(".popupBox-close").hide();
	$("#mask").hide();
	$("#" + div_id).fadeOut();
}

$(function() {
	$('.popupBox-close').css('display', 'block');
	$(".popupBox-close").hide();
	scrollTop('.scrolltop');
	scrollTop('.gotop');

	var inputEl = $('#search'),
		defVal = inputEl.val();
	inputEl.bind({
		focus: function() {
			var _this = $(this);
			if (_this.val() == defVal) {
				_this.val('');
			}
		},
		blur: function() {
			var _this = $(this);
			if (_this.val() == '') {
				_this.val(defVal);
			}
		}
	});

	$('div.mobile-switch').click(function() {
		$('.mobile-list').css('display', 'block');
		$('.mobile-list').animate({
			"left": "0px",
			"opacity": "1"
		}, 700);
	});
	$('.mobileClose').click(function() {
		$('.mobile-list').animate({
			"left": "-100%",
			"opacity": "0"
		}, 700, function() {
			$(this).css('display', 'none');
		});
	});
	$('div.fbslide').find('div.closebtn').click(function() {
		$('div.fbslide').fadeOut();
	});


	$(window).scroll(function() {
		if ($(document).scrollTop() + $(window).height() >= $(document.body).outerHeight() * 0.95) {
			$('div.fbslide').stop().animate({
				//"top": "0px",
				"bottom": "0px",
				"opacity": "1"
			}, 500);
		}else{
			$('div.fbslide').stop().animate({
				"bottom": "-250px",
				"opacity": "0.3"
			}, 500);
		}
	});

});
$(window).load(function() {
	$('.adv_block').css({display:'block'});

	var $cart = $('.content_blockFB'),
		_topFootBanner = $cart.offset().top,
		L_height = $('.content_sectionL').height(),
		R_height = $('.content_sectionR').height();

	var $gotopbtn = $('.gotopbtn'),
		$linebtn  = $('.linebtn img'),
		newcontent_height = $('.content_block .description').height();


	var $win = $(window).scroll(function() {
		if(L_height > R_height){
			/*console.log('$win.scrollTop() :'+$win.scrollTop() );
			console.log('_topFootBanner :'+_topFootBanner );*/
			if ($win.scrollTop() >= _topFootBanner) {
				if ($cart.css('position') != 'fixed') {
					$cart.css({
						position: 'fixed',
						top: '0px'
					});
				}
			} else {
				$cart.css({
					position: 'static',
					top: 'auto'
				});
			}
		}
		var temp = newcontent_height - $win.scrollTop();
		if(temp >= 0 && temp <= 500)
		{
			$gotopbtn.css({
				opacity: ''+(500 - temp)/500,
				display: 'block'
			});
			$linebtn.css({
				opacity: ''+(500 - temp)/500,
				display: 'block'
			});
		}
		else if(temp < 0 && temp > -1500)
		{
			$gotopbtn.css({
				opacity: '1',
				display: 'block'
			});
			$linebtn.css({
				opacity: '1',
				display: 'block'
			});
		}
		else
		{
			$gotopbtn.css({
				opacity: '0',
				display: 'none'
			});
			$linebtn.css({
				opacity: '0',
				display: 'none'
			});

		}
		//console.log(temp);
	});
});

// $(window).load(function() {
// 	//alert($(document.body).outerHeight(true));

// 	var $cart = $('#slidebar_adv'),
// 	_top = $cart.offset().top;
// 	//console.log(_top);

// 	var $win = $(window).scroll(function() {
// 		//console.log($win.scrollTop());
// 		if ($win.scrollTop() >= _top) {
// 			if ($cart.css('position') != 'fixed') {
// 				$cart.css({
// 					position: 'fixed',
// 					top: '0px',
// 				});
// 			}
// 		} else {
// 			$cart.css({
// 				position: 'static',
// 			});
// 		}
// 	});
// });

  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-58961723-1', 'auto');
  ga('require', 'displayfeatures');
  ga('send', 'pageview');
