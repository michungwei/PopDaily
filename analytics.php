<link type="text/css" rel="stylesheet" href="css/jquery.mmenu.all.css" />
<script type="text/javascript" src="scripts/jquery.mmenu.min.all.js"></script>
<script src="scripts/jquery.infinitescroll.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $('nav#menu2').mmenu({
            "extensions": [
              "pageshadow"
           ],
            footer: {
               add: true,
               content: "Popdaily"
            },
            "offCanvas": {
              "zposition": "next"
            }
         });
        $("nav#menu2").removeClass('hidden-mobile'); 
    });
</script>

<!-- Start Alexa Certify Javascript -->
<script type="text/javascript">
_atrk_opts = { atrk_acct:"4RH0l1aoHvD0fn", domain:"popdaily.com.tw",dynamic: true};
(function() { var as = document.createElement('script'); as.type = 'text/javascript'; as.async = true; as.src = "https://d31qbv1cthcecs.cloudfront.net/atrk.js"; var s = document.getElementsByTagName('script')[0];s.parentNode.insertBefore(as, s); })();
</script>
<noscript><img src="https://d5nxst8fruw4z.cloudfront.net/atrk.gif?account=4RH0l1aoHvD0fn" style="display:none" height="1" width="1" alt="" /></noscript>
<!-- End Alexa Certify Javascript -->

<script type='text/javascript'>
if($(window).width() <= 767) {
var googletag = googletag || {};
googletag.cmd = googletag.cmd || [];
(function() {
var gads = document.createElement('script');
gads.async = true;
gads.type = 'text/javascript';
var useSSL = 'https:' == document.location.protocol;
gads.src = (useSSL ? 'https:' : 'http:') + 
'//www.googletagservices.com/tag/js/gpt.js';
var node = document.getElementsByTagName('script')[0];
node.parentNode.insertBefore(gads, node);
})();
}
</script>

<script type='text/javascript'>
if($(window).width() <= 767) {
googletag.cmd.push(function() {
    googletag.defineSlot('/7682122/popdaily_mobile_inter_300x250', [[300, 250], [300, 600], [320, 480]], 'div-gpt-ad-1426590175838-0').addService(googletag.pubads());
    googletag.pubads().enableSingleRequest();
    googletag.pubads().addEventListener('slotRenderEnded', function(event) {

            $(".popupBox-close").hide();
            $("#popupBox").hide();
            popupDiv("popupBox");

    });
    googletag.enableServices();
});
}
</script>

<!-- Begin comScore Tag -->
<script>
  var _comscore = _comscore || [];
  _comscore.push({ c1: "2", c2: "19787903" });
  (function() {
    var s = document.createElement("script"), el = document.getElementsByTagName("script")[0]; s.async = true;
    s.src = (document.location.protocol == "https:" ? "https://sb" : "http://b") + ".scorecardresearch.com/beacon.js";
    el.parentNode.insertBefore(s, el);
  })();
</script>
<noscript>
  <img src="http://b.scorecardresearch.com/p?c1=2&c2=19787903&cv=2.0&cj=1" />
</noscript>
<!-- End comScore Tag -->

<script type="text/javascript">
        $(document).ready(function() {
            var i = 1,
                j = 1;
            $('[data-module="googleads"]').each(function() {
                if (! $(this).data('env') || 
                    ($(this).data('env') == 'desktop' && $(window).width() > 767) ||
                        ($(this).data('env') == 'mobile' && $(window).width() <= 767)||
                        ($(this).data('env') == 'all' && $(window).width() > 0)) {
                    var gad = '';

                    gad = '<scr' + 'ipt async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></scr' + 'ipt>';
                    gad += '<ins class="adsbygoogle" style="' + $(this).data('style') + '"';
                    gad += ' data-ad-client="ca-pub-4054396321663077"';
                    gad += ' data-ad-slot="' + $(this).data('slot') + '"';

                    if ($(this).data('format')) {
                        gad += ' data-ad-format="auto"';
                    }

                    if (i > 1) {
                        var k = i - 1;
                        gad += ' data-ad-region="test' + k + '"';
                    }

                    gad += '></ins><scr' + 'ipt>(adsbygoogle = window.adsbygoogle || []).push({});</scr' + 'ipt>';

                    $(this).html(gad);

                    if (j = 3) {
                        i++;
                        j = 1;
                    }
                }
            });
        });
    </script>