<?php

if ( ! defined( 'ABSPATH' ) ) exit;

function altcha_options_page_html()
{
  wp_enqueue_script(
    'altcha-admin-js',
    AltchaPlugin::$admin_script_src,
    array(),
    ALTCHA_VERSION,
    true
  );
  wp_enqueue_style(
    'altcha-admin-styles',
    AltchaPlugin::$admin_css_src,
    array(),
    ALTCHA_VERSION,
    'all'
  );
?>
  <div class="altcha-head">
    <div class="altcha-logo">
      <svg width="60" height="60" viewBox="0 0 249 249" fill="none" xmlns="http://www.w3.org/2000/svg">
        <rect width="249" height="249" fill="#1D1DC9"/>
        <path d="M59.159 180.1C89.7447 216.695 144.089 221.468 180.54 190.761C198.133 175.94 208.343 155.563 210.758 134.33L193.987 128.202C192.998 146.665 184.685 164.686 169.464 177.509C140.303 202.075 96.8279 198.256 72.359 168.98C47.8902 139.704 51.6938 96.0565 80.8546 71.4909C110.015 46.9252 153.491 50.7439 177.959 80.0201C185.269 88.7652 190.055 98.7926 192.396 109.211L210.905 115.974C209.267 99.2198 202.752 82.7697 191.159 68.9001C160.573 32.3049 106.229 27.5319 69.7784 58.2386C33.3275 88.9456 28.573 143.505 59.159 180.1Z" fill="white"/>
        <path d="M69.7784 58.2386C53.283 72.1347 43.2788 90.9154 40.1033 110.706L56.6331 117.058C58.4776 99.92 66.6633 83.4459 80.8546 71.4909C110.015 46.9252 153.491 50.7439 177.959 80.0201L158.159 96.7001L211 117.006C209.532 99.8961 202.989 83.0542 191.159 68.9001C160.573 32.3049 106.229 27.5319 69.7784 58.2386Z" fill="white"/>
        <path d="M99.3121 124.5H82.0806C82.0806 148.386 101.368 167.749 125.159 167.749C148.951 167.749 168.238 148.386 168.238 124.5H151.006C151.006 138.832 139.435 150.449 125.159 150.449C110.884 150.449 99.3121 138.832 99.3121 124.5Z" fill="white"/>
      </svg>
    </div>

    <div style="flex-grow: 1;">
      <div class="altcha-title"><?php echo esc_html__('ALTCHA', 'altcha-spam-protection'); ?></div>
      <div class="altcha-subtitle"><?php echo esc_html__('A Privacy-Friendly Captcha Alternative.', 'altcha-spam-protection'); ?></div>
    </div>

    <div>
      <div style="margin-bottom: 0.3rem;"><b><?php echo esc_html__('Do you like ALTCHA?', 'altcha-spam-protection'); ?></b></div>
      <div style="display:flex;gap: 0.5rem;">
        <a href="https://wordpress.org/support/plugin/altcha-spam-protection/reviews/?filter=5#new-post" target="_blank" style="display: inline-flex; gap: 0.5rem;">
          <span style="display: inline-flex; gap: 0.1rem;">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#FFCC00" width="18" height="18"><path d="M12.0006 18.26L4.94715 22.2082L6.52248 14.2799L0.587891 8.7918L8.61493 7.84006L12.0006 0.5L15.3862 7.84006L23.4132 8.7918L17.4787 14.2799L19.054 22.2082L12.0006 18.26Z"></path></svg>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#FFCC00" width="18" height="18"><path d="M12.0006 18.26L4.94715 22.2082L6.52248 14.2799L0.587891 8.7918L8.61493 7.84006L12.0006 0.5L15.3862 7.84006L23.4132 8.7918L17.4787 14.2799L19.054 22.2082L12.0006 18.26Z"></path></svg>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#FFCC00" width="18" height="18"><path d="M12.0006 18.26L4.94715 22.2082L6.52248 14.2799L0.587891 8.7918L8.61493 7.84006L12.0006 0.5L15.3862 7.84006L23.4132 8.7918L17.4787 14.2799L19.054 22.2082L12.0006 18.26Z"></path></svg>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#FFCC00" width="18" height="18"><path d="M12.0006 18.26L4.94715 22.2082L6.52248 14.2799L0.587891 8.7918L8.61493 7.84006L12.0006 0.5L15.3862 7.84006L23.4132 8.7918L17.4787 14.2799L19.054 22.2082L12.0006 18.26Z"></path></svg>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#FFCC00" width="18" height="18"><path d="M12.0006 18.26L4.94715 22.2082L6.52248 14.2799L0.587891 8.7918L8.61493 7.84006L12.0006 0.5L15.3862 7.84006L23.4132 8.7918L17.4787 14.2799L19.054 22.2082L12.0006 18.26Z"></path></svg>
          </span>
          <span><?php echo esc_html__('Review it!', 'altcha-spam-protection'); ?></span>
        </a>
      </div>
    </div>
  </div>

  <div class="wrap">

    <hr>

    <form action="options.php" method="post">
      <?php
      settings_errors();
      settings_fields('altcha_options');
      do_settings_sections('altcha_admin');
      submit_button();
      ?>
    </form>

    <div style="opacity: 0.8;">
      <p><?php
        echo sprintf(
          esc_html__(
              /* translators: %1$s is the plugin version, and %2$s is the widget version */
              'ALTCHA Spam Protection for WordPress, plugin version %1$s, widget version %2$s',
              'altcha-spam-protection',
          ),
          AltchaPlugin::$version,
          AltchaPlugin::$widget_version,
        );
      ?></p>
      <p>
        <?php
        echo sprintf(
          esc_html__(
            /* translators: the placeholders are opening and closing tags for a link (<a> tag) */
            'Please give ALTCHA a %s★★★★★ rating%s on WordPress.org to help us get the word out.',
            'altcha-spam-protection',
          ),
          '<a href="https://wordpress.org/support/plugin/altcha-spam-protection/reviews/?filter=5#new-post" target="_blank">',
          '</a>',
        ); ?>
      </p>
      <p>
        <a href="https://github.com/altcha-org/altcha" target="_blank" style="display: inline-flex; gap: 0.3rem;">
          <span><?php echo esc_html__('Star ALTCHA on GitHub!', 'altcha-spam-protection'); ?></span>
        </a>
      </p>
    </div>
  </div>
<?php
}

function altcha_general_section_callback()
{
  ?>
    <p><?php
      echo sprintf(
        esc_html__(
          /* translators: the placeholders are opening and closing tags for bold */
          'The %sSelf-hosted%s mode does not require an API Key and runs fully within your WordPress installation, without any external services.',
          'altcha-spam-protection',
        ),
        '<b>',
        '</b>',
      );
    ?></p>

    <p><?php
      echo sprintf(
        esc_html__(
          /* translators: the placeholder is a clickable link to altcha.org */
          'To access the ALTCHA\'s cloud API, you need an API Key. Visit %s for more information.',
          'altcha-spam-protection',
        ),
        '<a href="https://altcha.org" target="_blank">altcha.org</a>',
      );
    ?></p>

    <div>
      <a href="https://altcha.org/docs/api/api_keys/" target="_blank" class="button button-primary"><?php echo esc_html__('Create an API Key →', 'altcha-spam-protection'); ?></a>
    </div>

    <p><?php
      echo sprintf(
        esc_html__(
          /* translators: the placeholder will be replaced with the domain name */
          'Your domain name for the API Key: %s',
          'altcha_spam_protection',
        ),
        '<b>' . esc_html(AltchaPlugin::$hostname) . '</b>',
      );
    ?></p>
  <?php
}

function altcha_spam_filter_section_callback()
{
  ?>

    <p><?php
      echo sprintf(
        esc_html__(
          /* translators: the first two placeholders will be replaced with opening and closing tags for a link (<a> tag), the other two with opening and closing tags for bold (<b> tag). The two pairs may be swapped with each other, but the two tags within pairs may not. */
          'The %1$sSpam Filter%2$s is %3$savailable only in the API mode%4$s with a valid API Key.',
          'altcha-spam-protection',
        ),
        '<a href="https://altcha.org/docs/api/spam-filter-api" target="_blank">',
        '</a>',
        '<b>',
        '</b>',
      );
    ?></p>

  <?php
}

function altcha_widget_section_callback()
{
  ?>

    <p><?php echo esc_html__('Customize the widget to fit your needs.', 'altcha-spam-protection'); ?></p>

  <?php
}

function altcha_integrations_section_callback()
{
  ?>

    <p><?php echo esc_html__('Activate ALTCHA for these integrations:', 'altcha-spam-protection'); ?></p>

  <?php
}

function altcha_wordpress_section_callback()
{
  ?>

    <p><?php echo esc_html__('Activate ALTCHA for the core Wordpress functionality:', 'altcha-spam-protection'); ?></p>

  <?php
}

function altcha_settings_field_callback(array $args)
{
  $type = $args['type'];
  $name = $args['name'];
  $hint = isset($args['hint']) ? $args['hint'] : null;
  $spamfilter = isset($args['spamfilter']) ? $args['spamfilter'] : '';
  $description = isset($args['description']) ? $args['description'] : null;
  $setting = get_option($name);
  $value = isset($setting) ? esc_attr($setting) : '';
  if ($type == "checkbox") {
    $value = 1;
  }
?>
  <input autcomplete="none" class="regular-text" <?php echo $spamfilter === true ? ' data-spamfilter' : ''; ?> type="<?php echo esc_attr($type); ?>" name="<?php echo esc_attr($name); ?>" id="<?php echo esc_attr($name); ?>" value="<?php echo esc_attr($value) ?>" <?php $type == "checkbox" ? checked(1, $setting, true) : "" ?>>
  <label class="description" for="<?php echo esc_attr($name); ?>"><?php echo esc_html($description); ?></label>
  <?php if ($hint) { ?>
  <div style="opacity:0.7;font-size:85%;margin-top:3px"><?php echo esc_html($hint); ?></div>
  <?php } ?>
<?php
}

function altcha_settings_select_callback(array $args)
{
  $name = $args['name'];
  $hint = isset($args['hint']) ? $args['hint'] : null;
  $disabled = isset($args['disabled']) ? $args['disabled'] : false;
  $description = isset($args['description']) ? $args['description'] : null;
  $options = isset($args['options']) ? $args['options'] : array();
  $spamfilter_options = isset($args['spamfilter_options']) ? $args['spamfilter_options'] : array();
  $setting = get_option($name);
  $value = isset($setting) ? esc_attr($setting) : '';
?>
  <select name="<?php echo esc_attr($name); ?>" id="<?php echo esc_attr($name); ?>" <?php echo $disabled === true ? ' disabled' : ''; ?>>
  <?php
    foreach ( $options as $opt_key => $opt_value ) {
      echo '<option value="' . esc_attr( $opt_key ) . '" '
        . (in_array($opt_key, $spamfilter_options) ? ' data-spamfilter ' : '')
        . selected($value, $opt_key, false )
        . '>' . esc_html($opt_value) . '</option>';
    }
  ?>
  </select>
  <label class="description" for="<?php echo esc_attr($name); ?>"><?php echo esc_html($description) ?></label>
  <?php if ($hint) { ?>
  <div style="opacity:0.7;font-size:85%;margin-top:3px"><?php echo esc_html($hint); ?></div>
  <?php } ?>
<?php
}
