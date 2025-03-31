<?php

if (!defined('ABSPATH')) exit;

class AltchaPlugin
{
  public static $instance;

  public static $language = "";

  public static $widget_script_src = "";

  public static $wp_script_src = "";

  public static $admin_script_src = "";

  public static $admin_css_src = "";

  public static $custom_script_src = "";

  public static $widget_style_src = "";

  public static $version = "0.0.0";

  public static $widget_version = "0.0.0";

  public static $option_api = "altcha_api";

  public static $option_api_key = "altcha_api_key";

  public static $option_secret = "altcha_secret";

  public static $option_complexity = "altcha_complexity";

  public static $option_expires = "altcha_expires";

  public static $option_blockspam = "altcha_blockspam";

  public static $option_send_ip = "altcha_send_ip";

  public static $option_auto = "altcha_auto";

  public static $option_floating = "altcha_floating";

  public static $option_delay = "altcha_delay";

  public static $option_hidefooter = "altcha_hidefooter";

  public static $option_hidelogo = "altcha_hidelogo";

  public static $option_integration_contact_form_7 = "altcha_integration_contact_form_7";

  public static $option_integration_custom = "altcha_integration_custom";

  public static $option_integration_elementor = "altcha_integration_elementor";

  public static $option_integration_forminator = "altcha_integration_forminator";

  public static $option_integration_gravityforms = "altcha_integration_gravityforms";

  public static $option_integration_woocommerce_login = "altcha_integration_woocommerce_login";

  public static $option_integration_woocommerce_register = "altcha_integration_woocommerce_register";

  public static $option_integration_woocommerce_reset_password = "altcha_integration_woocommerce_reset_password";

  public static $option_integration_html_forms = "altcha_integration_html_forms";

  public static $option_integration_wordpress_login = "altcha_integration_wordpress_login";

  public static $option_integration_wordpress_register = "altcha_integration_wordpress_register";

  public static $option_integration_wordpress_reset_password = "altcha_integration_wordpress_reset_password";

  public static $option_integration_wordpress_comments = "altcha_integration_wordpress_comments";

  public static $option_integration_wpdiscuz = "altcha_integration_wpdiscuz";

  public static $option_integration_wpforms = "altcha_integration_wpforms";

  public static $option_integration_enfold_theme = "altcha_integration_enfold_theme";

  public static $html_espace_allowed_tags = array(
    'altcha-widget' => array(
      'challengeurl' => array(),
      'strings' => array(),
      'auto' => array(),
      'floating' => array(),
      'delay' => array(),
      'hidelogo' => array(),
      'hidefooter' => array(),
      'blockspam' => array(),
      'spamfilter' => array(),
      'name' => array(),
    ),
    'div' => array(
      'class' => array(),
      'style' => array(),
    ),
    'input' => array(
      'class' => array(),
      'id' => array(),
      'name' => array(),
      'type' => array(),
      'value' => array(),
      'style' => array(),
    ),
    'noscript' => array(),
  );

  public static $hostname = null;

  public $spamfilter_result = null;

  public function init()
  {
    AltchaPlugin::$instance = $this;
    AltchaPlugin::$language = get_locale();
    if (defined('ALTCHA_VERSION')) {
      AltchaPlugin::$version = ALTCHA_VERSION;
    }
    if (defined('ALTCHA_WIDGET_VERSION')) {
      AltchaPlugin::$widget_version = ALTCHA_WIDGET_VERSION;
    }
    $url = wp_parse_url(get_site_url());
    AltchaPlugin::$hostname = $url['host'] . (isset($url['port']) ? ':' . $url['port'] : '');
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

  public function get_expires()
  {
    return get_option(AltchaPlugin::$option_expires);
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

  public function get_floating()
  {
    return trim(get_option(AltchaPlugin::$option_floating));
  }

  public function get_delay()
  {
    return trim(get_option(AltchaPlugin::$option_delay));
  }

  public function get_integration_contact_form_7()
  {
    return trim(get_option(AltchaPlugin::$option_integration_contact_form_7));
  }

  public function get_integration_custom()
  {
    return trim(get_option(AltchaPlugin::$option_integration_custom));
  }

  public function get_integration_elementor()
  {
    return trim(get_option(AltchaPlugin::$option_integration_elementor));
  }

  public function get_integration_enfold_theme() {
    return trim(get_option(AltchaPlugin::$option_integration_enfold_theme));
  }

  public function get_integration_forminator()
  {
    return trim(get_option(AltchaPlugin::$option_integration_forminator));
  }

  public function get_integration_gravityforms()
  {
    return trim(get_option(AltchaPlugin::$option_integration_gravityforms));
  }

  public function get_integration_woocommerce_register()
  {
    return trim(get_option(AltchaPlugin::$option_integration_woocommerce_register));
  }

  public function get_integration_woocommerce_reset_password()
  {
    return trim(get_option(AltchaPlugin::$option_integration_woocommerce_reset_password));
  }

  public function get_integration_woocommerce_login()
  {
    return trim(get_option(AltchaPlugin::$option_integration_woocommerce_login));
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

  public function get_integration_wpdiscuz()
  {
    return trim(get_option(AltchaPlugin::$option_integration_wpdiscuz));
  }

  public function get_integration_wpforms()
  {
    return trim(get_option(AltchaPlugin::$option_integration_wpforms));
  }

  function get_ip_address()
  {
    foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key) {
      if (array_key_exists($key, $_SERVER) === true) {
        $value = trim(sanitize_text_field($_SERVER[$key]));
        foreach (explode(',', $value) as $ip) {
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
      return get_rest_url(null, "/altcha/v1/challenge");
    }
    $api_key = $this->get_api_key();
    return "https://$api.altcha.org/api/v1/challenge?apiKey=$api_key";
  }

  public function get_translations($language = null)
  {
    $originalLanguage = null;

    if ($language !== null) {
      $originalLanguage = get_locale();
      switch_to_locale($language);
    }

    $ALTCHA_WEBSITE = constant('ALTCHA_WEBSITE');
    $translations = array(
      "error" => __('Verification failed. Try again later.', 'altcha-spam-protection'),
      "footer" => sprintf(
        /* translators: the placeholders contain opening and closing tags for a link (<a> tag) */
        __('Protected by %sALTCHA%s', 'altcha-spam-protection'),
        '<a href="' . $ALTCHA_WEBSITE . '" target="_blank">',
        "</a>",
      ),
      "label" => __('I\'m not a robot', 'altcha-spam-protection'),
      "verified" => __('Verified', 'altcha-spam-protection'),
      "verifying" => __('Verifying...', 'altcha-spam-protection'),
      "waitAlert" => __('Verifying... please wait.', 'altcha-spam-protection'),
    );

    if ($originalLanguage !== null) {
      switch_to_locale($originalLanguage);
    }

    return $translations;
  }


  public function has_active_integrations()
  {
    $integrations = array(
      $this->get_integration_contact_form_7(),
      $this->get_integration_custom(),
      $this->get_integration_elementor(),
      $this->get_integration_enfold_theme(),
      $this->get_integration_forminator(),
      $this->get_integration_gravityforms(),
      $this->get_integration_html_forms(),
      $this->get_integration_woocommerce_register(),
      $this->get_integration_woocommerce_login(),
      $this->get_integration_woocommerce_reset_password(),
      $this->get_integration_wordpress_register(),
      $this->get_integration_wordpress_login(),
      $this->get_integration_wordpress_reset_password(),
      $this->get_integration_wordpress_comments(),
      $this->get_integration_wpforms(),
    );
    return in_array("captcha", $integrations) || in_array("captcha_spamfilter", $integrations) || in_array("shortcode", $integrations);
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
    if (isset($data->verificationData)) {
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
      return $this->spamfilter_result['classification'] !== 'BAD';
    }
    return $verified;
  }

  public function verify_solution($payload, $hmac_key = null)
  {
    if ($hmac_key === null) {
      $hmac_key = $this->get_secret();
    }
    $data = json_decode(base64_decode($payload));
    $salt_url = wp_parse_url($data->salt);
    parse_str($salt_url['query'], $salt_params);
    if (!empty($salt_params['expires'])) {
      $expires = intval($salt_params['expires'], 10);
      if ($expires > 0 && $expires < time()) {
        return false;
      }
    }
    $alg_ok = ($data->algorithm === 'SHA-256');
    $calculated_challenge = hash('sha256', $data->salt . $data->number);
    $challenge_ok = ($data->challenge === $calculated_challenge);
    $calculated_signature = hash_hmac('sha256', $data->challenge, $hmac_key);
    $signature_ok = ($data->signature === $calculated_signature);
    $verified = ($alg_ok && $challenge_ok && $signature_ok);
    return $verified;
  }

  public function generate_challenge($hmac_key = null, $complexity = null, $expires = null)
  {
    if ($hmac_key === null) {
      $hmac_key = $this->get_secret();
    }
    if ($complexity === null) {
      $complexity = $this->get_complexity();
    }
    if ($expires === null) {
      $expires = intval($this->get_expires(), 10);
    }
    $salt = $this->random_secret();
    if ($expires > 0) {
      $salt = $salt . '?' . http_build_query(array(
        'expires' => time() + $expires
      ));
    }
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

  public function get_widget_attrs($mode, $language = null, $name = null)
  {
    $challengeurl = $this->get_challengeurl();
    $api = $this->get_api();
    $api_key = $this->get_api_key();
    $floating = $this->get_floating();
    $delay = $this->get_delay();
    $can_hide_branding = $api === 'selfhosted' || str_starts_with($api_key, 'key_');
    $hidelogo = $can_hide_branding && $this->get_hidelogo();
    $hidefooter = $can_hide_branding && $this->get_hidefooter();
    $blockspam = $this->get_blockspam();
    $auto = $this->get_auto();
    $strings = wp_json_encode($this->get_translations($language));
    $attrs = array(
      'challengeurl' => $challengeurl,
      'strings' => $strings,
    );
    if ($name) {
      $attrs['name'] = $name;
    }
    if ($auto) {
      $attrs['auto'] = $auto;
    }
    if ($floating) {
      $attrs['floating'] = 'auto';
    }
    if ($delay) {
      $attrs['delay'] = '1500';
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

  public function render_widget($mode, $wrap = false, $language = null, $name = null)
  {
    $attrs = $this->get_widget_attrs($mode, $language, $name);
    $attributes = join(' ', array_map(function ($key) use ($attrs) {
      if (is_bool($attrs[$key])) {
        return $attrs[$key] ? $key : '';
      }
      return esc_attr($key) . '="' . esc_attr($attrs[$key]) . '"';
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

  public function spam_filter_check($data, $ip = null, $ignore_fields = array())
  {
    if ($ip === null) {
      $ip = $this->get_ip_address();
    }
    return $this->spam_filter_call(array(
      'ipAddress' => $ip,
      'fields' => $this->remove_private_keys($data, $ignore_fields),
    ));
  }

  public function spam_filter_call($body)
  {
    $api = $this->get_api();
    $api_key = $this->get_api_key();
    $resp = wp_remote_post("https://$api.altcha.org/api/v1/classify", array(
      'body' => wp_json_encode($body),
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
    } else {
      error_log(sprintf("Spam Filter responsed with %s - %s", $status, $resp['body']));
    }
    return false;
  }

  function remove_private_keys($array, $ignore_fields = array())
  {
    $filtered = array();
    foreach ($array as $key => $value) {
      if (strpos($key, '_') !== 0 && !isset($ignore_fields[$key])) {
        $filtered[$key] = $value;
      }
    }
    return $filtered;
  }

  function sanitize_data($post)
  {
    $data = $this->flatten_post($post);
    foreach ($data as $key => $value) {
      $data[$key] = sanitize_text_field($value);
    }
    return $data;
  }

  function flatten_post($post_data, $prefix = '')
  {
    $result = array();
    foreach ($post_data as $key => $value) {
      if (is_array($value)) {
        if ($prefix == '') {
          $result = $result + $this->flatten_post($value, $prefix . $key);
        } else {
          $result = $result + $this->flatten_post($value, $prefix . '[' . $key . ']');
        }
      } else {
        if ($prefix == '') {
          $result[$prefix . $key . ''] = $value;
        } else {
          $result[$prefix . '[' . $key . ']' . ''] = $value;
        }
      }
    }
    return $result;
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
      'callback'  => 'altcha_generate_challenge_endpoint',
      'permission_callback' => '__return_true'
    ));
  }
);

function altcha_generate_challenge_endpoint()
{
  $resp = new WP_REST_Response(AltchaPlugin::$instance->generate_challenge());
  $resp->set_headers(array('Cache-Control' => 'no-cache, no-store, max-age=0'));
  return $resp;
}
