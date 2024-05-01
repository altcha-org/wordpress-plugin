<?php

class AltchaPlugin
{
  public static $instance;

  public static $widget_script_src = "";

  public static $wp_script_src = "";

  public static $custom_script_src = "";

  public static $widget_style_src = "";

  public static $version = "0.0.0";

  public static $widget_version = "0.0.0";

  public static $option_api = "altcha_api";

  public static $option_api_key = "altcha_api_key";

  public static $option_secret = "altcha_secret";

  public static $option_complexity = "altcha_complexity";

  public static $option_blockspam = "altcha_blockspam";

  public static $option_send_ip = "altcha_send_ip";

  public static $option_auto = "altcha_auto";

  public static $option_language = "altcha_language";

  public static $option_hidefooter = "altcha_hidefooter";

  public static $option_hidelogo = "altcha_hidelogo";

  public static $option_integration_contact_form_7 = "altcha_integration_contact_form_7";

  public static $option_integration_custom = "altcha_integration_custom";

  public static $option_integration_forminator = "altcha_integration_forminator";

  public static $option_integration_gravityforms = "altcha_integration_gravityforms";

  public static $option_integration_html_forms = "altcha_integration_html_forms";

  public static $option_integration_wordpress_login = "altcha_integration_wordpress_login";

  public static $option_integration_wordpress_register = "altcha_integration_wordpress_register";

  public static $option_integration_wordpress_reset_password = "altcha_integration_wordpress_reset_password";

  public static $option_integration_wordpress_comments = "altcha_integration_wordpress_comments";

  public static $option_integration_wpforms = "altcha_integration_wpforms";

  public static $message_cannot_submit = "Cannot submit your message.";

  public $spamfilter_result = null;

  public function init()
  {
    AltchaPlugin::$instance = $this;
    if (defined('ALTCHA_VERSION')) {
      AltchaPlugin::$version = ALTCHA_VERSION;
    }
    if (defined('ALTCHA_WIDGET_VERSION')) {
      AltchaPlugin::$widget_version = ALTCHA_WIDGET_VERSION;
    }
  }

  public function get_api()
  {
    return trim(get_option(AltchaPlugin::$option_api));
  }

  public function get_api_key()
  {
    return trim(get_option(AltchaPlugin::$option_api_key));
  }

  public function get_complexity()
  {
    return trim(get_option(AltchaPlugin::$option_complexity));
  }

  public function get_language()
  {
    return trim(get_option(AltchaPlugin::$option_language));
  }

  public function get_secret()
  {
    return trim(get_option(AltchaPlugin::$option_secret));
  }

  public function get_hidelogo()
  {
    return get_option(AltchaPlugin::$option_hidelogo);
  }

  public function get_hidefooter()
  {
    return get_option(AltchaPlugin::$option_hidefooter);
  }

  public function get_blockspam()
  {
    return get_option(AltchaPlugin::$option_blockspam);
  }

  public function get_auto()
  {
    return trim(get_option(AltchaPlugin::$option_auto));
  }

  public function get_integration_contact_form_7()
  {
    return trim(get_option(AltchaPlugin::$option_integration_contact_form_7));
  }

  public function get_integration_custom()
  {
    return trim(get_option(AltchaPlugin::$option_integration_custom));
  }

  public function get_integration_forminator()
  {
    return trim(get_option(AltchaPlugin::$option_integration_forminator));
  }

  public function get_integration_gravityforms()
  {
    return trim(get_option(AltchaPlugin::$option_integration_gravityforms));
  }

  public function get_integration_html_forms()
  {
    return trim(get_option(AltchaPlugin::$option_integration_html_forms));
  }

  public function get_integration_wordpress_register()
  {
    return trim(get_option(AltchaPlugin::$option_integration_wordpress_register));
  }

  public function get_integration_wordpress_reset_password()
  {
    return trim(get_option(AltchaPlugin::$option_integration_wordpress_reset_password));
  }

  public function get_integration_wordpress_login()
  {
    return trim(get_option(AltchaPlugin::$option_integration_wordpress_login));
  }

  public function get_integration_wordpress_comments()
  {
    return trim(get_option(AltchaPlugin::$option_integration_wordpress_comments));
  }

  public function get_integration_wpforms()
  {
    return trim(get_option(AltchaPlugin::$option_integration_wpforms));
  }

  function get_ip_address()
  {
    foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key) {
      if (array_key_exists($key, $_SERVER) === true) {
        foreach (explode(',', $_SERVER[$key]) as $ip) {
          $ip = trim($ip);

          if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false) {
            return $ip;
          }
        }
      }
    }
  }

  public function get_challengeurl()
  {
    $api = $this->get_api();
    if ($api === "selfhosted") {
      $base_url = get_site_url();
      return "$base_url/wp-json/altcha/v1/challenge";
    }
    $api_key = $this->get_api_key();
    return "https://$api.altcha.org/api/v1/challenge?apiKey=$api_key";
  }

  public function get_translations()
  {
    $language = $this->get_language();
    return ALTCHA_VERSION_TRANSLATIONS[$language] ?: ALTCHA_VERSION_TRANSLATIONS["en"];
  }

  public function random_secret()
  {
    return bin2hex(random_bytes(12));
  }

  public function verify($payload, $hmac_key = null)
  {
    if ($hmac_key === null) {
      $hmac_key = $this->get_secret();
    }
    if (empty($payload) || empty($hmac_key)) {
      return false;
    }
    $data = json_decode(base64_decode($payload));
    if ($data->verificationData) {
      return $this->verify_server_signature($payload, $hmac_key);
    }
    return $this->verify_solution($payload, $hmac_key);
  }

  public function verify_server_signature($payload, $hmac_key = null)
  {
    if ($hmac_key === null) {
      $hmac_key = $this->get_secret();
    }
    $data = json_decode(base64_decode($payload));
    $alg_ok = ($data->algorithm === 'SHA-256');
    $calculated_hash = hash('sha256', $data->verificationData, true);
    $calculated_signature = hash_hmac('sha256', $calculated_hash, $hmac_key);
    $signature_ok = ($data->signature === $calculated_signature);
    $verified = ($alg_ok && $signature_ok);
    if ($verified) {
      $this->spamfilter_result = array();
      parse_str($data->verificationData, $this->spamfilter_result);
    }
    return $verified;
  }

  public function verify_solution($payload, $hmac_key = null)
  {
    if ($hmac_key === null) {
      $hmac_key = $this->get_secret();
    }
    $data = json_decode(base64_decode($payload));
    $alg_ok = ($data->algorithm === 'SHA-256');
    $calculated_challenge = hash('sha256', $data->salt . $data->number);
    $challenge_ok = ($data->challenge === $calculated_challenge);
    $calculated_signature = hash_hmac('sha256', $data->challenge, $hmac_key);
    $signature_ok = ($data->signature === $calculated_signature);
    $verified = ($alg_ok && $challenge_ok && $signature_ok);
    return $verified;
  }

  public function generate_challenge($hmac_key = null, $complexity = null)
  {
    if ($hmac_key === null) {
      $hmac_key = $this->get_secret();
    }
    if ($complexity === null) {
      $complexity = $this->get_complexity();
    }
    $salt = $this->random_secret();
    switch ($complexity) {
      case 'low':
        $min_secret = 100;
        $max_secret = 1000;
        break;
      case 'medium':
        $min_secret = 1000;
        $max_secret = 20000;
        break;
      case 'high':
        $min_secret = 10000;
        $max_secret = 100000;
        break;
      default:
        $min_secret = 100;
        $max_secret = 10000;
    }
    $secret_number = random_int($min_secret, $max_secret);
    $challenge = hash('sha256', $salt . $secret_number);
    $signature = hash_hmac('sha256', $challenge, $hmac_key);
    $response = [
      'algorithm' => 'SHA-256',
      'challenge' => $challenge,
      'maxnumber' => $max_secret,
      'salt' => $salt,
      'signature' => $signature
    ];
    return $response;
  }

  public function get_widget_attrs($mode)
  {
    $challengeurl = $this->get_challengeurl();
    $api = $this->get_api();
    $api_key = $this->get_api_key();
    $can_hide_branding = $api === 'selfhosted' || str_starts_with($api_key, 'key_');
    $hidelogo = $can_hide_branding && $this->get_hidelogo();
    $hidefooter = $can_hide_branding && $this->get_hidefooter();
    $blockspam = $this->get_blockspam();
    $auto = $this->get_auto();
    $strings = json_encode($this->get_translations());
    $attrs = array(
      'challengeurl' => $challengeurl,
      'strings' => $strings,
    );
    if ($auto) {
      $attrs['auto'] = $auto;
    }
    if ($hidelogo) {
      $attrs['hidelogo'] = '1';
    }
    if ($hidefooter) {
      $attrs['hidefooter'] = '1';
    }
    if ($blockspam) {
      $attrs['blockspam'] = '1';
    }
    if ($mode === "captcha_spamfilter") {
      $attrs['spamfilter'] = '1';
    }
    return $attrs;
  }

  public function render_widget($mode, $wrap = false)
  {
    $attrs = $this->get_widget_attrs($mode);
    $attributes = join(' ', array_map(function ($key) use ($attrs) {
      if (is_bool($attrs[$key])) {
        return $attrs[$key] ? $key : '';
      }
      return $key . '="' . esc_attr($attrs[$key]) . '"';
    }, array_keys($attrs)));
    $html =
      "<altcha-widget "
      . $attributes
      . "></altcha-widget>"
      . "<noscript>"
      . "<div class=\"altcha-no-javascript\">This form requires JavaScript!</div>"
      . "</noscript>";
    if ($wrap) {
      return '<div class="altcha-widget-wrap">' . $html . '</div>';
    }
    return $html;
  }

  public function spam_filter_check($data, $ip = null)
  {
    if ($ip === null) {
      $ip = $this->get_ip_address();
    }
    return $this->spam_filter_call(array(
      'ipAddress' => $ip,
      'fields' => $this->remove_private_keys($data),
    ));
  }

  public function spam_filter_call($body)
  {
    $api = $this->get_api();
    $api_key = $this->get_api_key();
    $resp = wp_remote_post("https://$api.altcha.org/api/v1/classify", array(
      'body' => json_encode($body),
      'headers' => array(
        'authorization' => "Bearer $api_key",
        'accept' => 'application/json',
        'content-type' => 'application/json',
        'referer' => get_site_url(),
      ),
      'timeout' => 15
    ));
    $status = $resp['response']['code'];
    if ($status === 200) {
      $json = json_decode($resp['body'], true);
      $this->spamfilter_result = $json;
      return $json['classification'] !== 'BAD';
    }
    return false;
  }

  function remove_private_keys($array)
  {
    $filtered = [];
    foreach ($array as $key => $value) {
      if (strpos($key, '_') !== 0) {
        $filtered[$key] = $value;
      }
    }
    return $filtered;
  }
}

if (!isset(AltchaPlugin::$instance)) {
  $altcha_plugin_instance = new AltchaPlugin();
  $altcha_plugin_instance->init();
}

require plugin_dir_path(__FILE__) . 'admin.php';
require plugin_dir_path(__FILE__) . 'settings.php';

add_action(
  'rest_api_init',
  function () {
    $namespace = 'altcha/v1';
    $route     = 'challenge';
    register_rest_route($namespace, $route, array(
      'methods'   => WP_REST_Server::READABLE,
      'callback'  => 'altcha_generate_challenge_encpoint'
    ));
  }
);

function altcha_generate_challenge_encpoint()
{
  return new WP_REST_Response(AltchaPlugin::$instance->generate_challenge());
}
