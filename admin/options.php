<?php

function altcha_options_page_html()
{
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
      <div class="altcha-title">ALTCHA</div>
      <div class="altcha-subtitle">A Privacy-Friendly Captcha Alternative.</div>
    </div>

    <div>
      <div style="margin-bottom: 0.3rem;"><b>Do you like ALTCHA?</b></div>
      <div>
        <a href="https://github.com/altcha-org/altcha" target="_blank" style="display: inline-flex; gap: 0.3rem;">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#FFCC00" width="18" height="18"><path d="M12.0006 18.26L4.94715 22.2082L6.52248 14.2799L0.587891 8.7918L8.61493 7.84006L12.0006 0.5L15.3862 7.84006L23.4132 8.7918L17.4787 14.2799L19.054 22.2082L12.0006 18.26Z"></path></svg>
          <span>Star it on GitHub!</span>
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
      <p>ALTCHA Spam Protection for WordPress, plugin version <?php echo AltchaPlugin::$version ?>, widget version <?php echo AltchaPlugin::$widget_version ?></p>
    </div>

    <script>
      (() => {
        document.addEventListener('DOMContentLoaded', () => {
          function onApiChange(api) {
            [...document.querySelectorAll('[data-spamfilter]')].forEach((el) => {
              el.disabled = api === 'selfhosted';
            });
          }
          const apiEl = document.querySelector('#altcha_api');
          if (apiEl) {
            apiEl.addEventListener('change', (ev) => onApiChange(ev.target.value));
            onApiChange(apiEl.value);
          }
        });
      })();
    </script>
  </div>

  <style>
    .altcha-head {
      display: flex;
      align-items: center;
      gap: 1rem;
      padding: 1rem 2rem 0 0;
      margin-bottom: 1rem;
    }
    .altcha-logo {
      border-radius: 5px;
    }
    .altcha-title {
      font-weight: 600;
      font-size: 180%;
      margin-bottom: 0.5rem;
    }
  </style>
<?php
}

function altcha_general_section_callback()
{
  ?>
    <p>The <b>Self-hosted</b> mode does not require an API Key and runs fully within your WordPress installation, without any external services.</p>

    <p>To access the ALTCHA's cloud API, you need an API Key. Visit <a href="https://altcha.org" target="_blank">altcha.org</a> for more information.</p>

    <div>
      <a href="https://altcha.org/docs/api/api_keys/" target="_blank" class="button button-primary">Create a Free API Key &rarr;</a>
    </div>
  <?php
}

function altcha_spam_filter_section_callback()
{
  ?>

    <p>The <a href="https://altcha.org/docs/api/spam-filter-api" target="_blank">Spam Filter</a> is <b>available only in the API mode</b> with a valid API Key.</p>

  <?php
}

function altcha_widget_section_callback()
{
  ?>

    <p>Customize the widget to fit your needs.</p>

  <?php
}

function altcha_integrations_section_callback()
{
  ?>

    <p>Activate ALTCHA for these integrations:</p>

  <?php
}

function altcha_wordpress_section_callback()
{
  ?>

    <p>Activate ALTCHA for the core Wordpress functionality:</p>

  <?php
}

function altcha_settings_field_callback(array $args)
{
  $type = $args['type'];
  $name = $args['name'];
  $hint = $args['hint'];
  $attrs = isset($args['attrs']) ? $args['attrs'] : '';
  $description = $args['description'];
  $setting = get_option($name);
  $value = isset($setting) ? esc_attr($setting) : '';
  $checked = "";
  if ($type == "checkbox") {
    $value = 1;
    $checked = checked(1, $setting, false);
  }
?>
  <input autcomplete="none" class="regular-text" <?php echo $attrs; ?> type="<?php echo $type; ?>" name="<?php echo $name; ?>" id="<?php echo $name; ?>" value="<?php echo $value ?>" <?php echo $checked ?>>
  <label class="description" for="<?php echo $name; ?>"><?php echo $description ?></label>
  <?php if ($hint) { ?>
  <div style="opacity:0.7;font-size:85%;margin-top:3px"><?php echo $hint; ?></div>
  <?php } ?>
<?php
}

function altcha_settings_select_callback(array $args)
{
  $name = $args['name'];
  $hint = $args['hint'];
  $disabled = $args['disabled'];
  $description = $args['description'];
  $options = $args['options'];
  $spamfilter_options = $args['spamfilter_options'] ?: [];
  $setting = get_option($name);
  $value = isset($setting) ? esc_attr($setting) : '';
?>
  <select name="<?php echo $name; ?>" id="<?php echo $name; ?>" <?php echo $disabled === true ? ' disabled' : ''; ?>>
  <?php
    foreach ( $options as $opt_key => $opt_value ) {
      echo '<option value="' . esc_attr( $opt_key ) . '" '
        . (in_array($opt_key, $spamfilter_options) ? ' data-spamfilter ' : '')
        . selected($value, $opt_key, false )
        . '>' . esc_html__($opt_value) . '</option>';
    }
  ?>
  </select>
  <label class="description" for="<?php echo $name; ?>"><?php echo $description ?></label>
  <?php if ($hint) { ?>
  <div style="opacity:0.7;font-size:85%;margin-top:3px"><?php echo $hint; ?></div>
  <?php } ?>
<?php
}
