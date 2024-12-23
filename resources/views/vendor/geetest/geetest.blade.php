<script src="//lib.baomitu.com/jquery/2.2.4/jquery.min.js"></script>
<script src="//static.geetest.com/static/tools/gt.js"></script>
<div id="{{ $captchaid }}"></div>
<p id="wait-{{ $captchaid }}" class="show">Loading verification code...</p>
@define use Illuminate\Support\Facades\Config
<script type="text/javascript">
  const geetest = function(url) {
    const handlerEmbed = function(captchaObj) {
      $("#{{ $captchaid }}").closest('form').submit(function(e) {
        const validate = captchaObj.getValidate();
        if (!validate) {
          alert('{{ Config::get('geetest.client_fail_alert')}}');
          e.preventDefault();
        }
      });
      captchaObj.appendTo("#{{ $captchaid }}");
      captchaObj.onReady(function() {
        $('#wait-{{ $captchaid }}')[0].className = 'hide';
      });
      if ('{{ $product }}' === 'popup') {
        captchaObj.bindOn($('#{{ $captchaid }}').closest('form').find(':submit'));
        captchaObj.appendTo('#{{ $captchaid }}');
      }
    };
    $.ajax({
      url: url + '?t=' + (new Date()).getTime(),
      type: 'get',
      dataType: 'json',
      success: function(data) {
        initGeetest({
          gt: data.gt,
          challenge: data.challenge,
          product: "{{ $product ?: Config::get('geetest.product', 'float') }}",
          width: 'auto',
          offline: !data.success,
          new_captcha: data.new_captcha,
          lang: '{{ Config::get('geetest.lang', 'en') }}',
          http: '{{ Config::get('geetest.protocol', 'http') }}' + '://',
        }, handlerEmbed);
      },
    });
  };
  (function() {
    geetest('{{ $url ?: Config::get('geetest.url', 'geetest') }}');
  })();
</script>
<style>
    .hide {
        display: none;
    }
</style>
