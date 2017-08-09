<div class="wrap">

  <h2 class="nav-tab-wrapper">
    <a href="<?php echo admin_url('themes.php?page=sassy-system&tab=tools')?>" class="nav-tab <?php echo ($active_tab == 'tools' ? 'nav-tab-active': '')?>"><?php _e('Tools', 'sassy')?></a>
    <a href="<?php echo admin_url('themes.php?page=sassy-system&tab=importexport')?>" class="nav-tab <?php echo ($active_tab == 'importexport' ? 'nav-tab-active': '')?>"><?php _e('Import/Export', 'sassy')?></a>
    <a href="<?php echo admin_url('themes.php?page=sassy-system&tab=sassvars')?>" class="nav-tab <?php echo ($active_tab == 'sassvars' ? 'nav-tab-active': '')?>"><?php _e('Sass variables', 'sassy')?></a>
    <a href="<?php echo admin_url('themes.php?page=sassy-system&tab=uninstall')?>" class="nav-tab <?php echo ($active_tab == 'uninstall' ? 'nav-tab-active': '')?>"><?php _e('Uninstall', 'sassy')?></a>
  </h2>

  <?php if (!empty($messages)):?>
    <?php foreach ($messages as $message):?>
    <div id="message" class="updated below-h2">
      <p>
        <?php echo $message?>
      </p>
    </div>
    <?php endforeach?>
  <?php endif?>

  <?php
  /**
   * General tools tab
   */
  if ($active_tab == 'tools'):
    $count_layouts = wp_count_posts('sassy-layouts');
    ?>
    <p></p>
    <form method="post">

      <?php wp_nonce_field('sassy-system-action')?>

      <table class="wc_status_table widefat">
        <?php if (!defined('SITEORIGIN_PANELS_VERSION')):?>
          <tr>
            <td>
              <?php if (array_key_exists('siteorigin-panels/siteorigin-panels.php', get_plugins())):?>
                <a href="<?php echo wp_nonce_url(self_admin_url('plugins.php?action=activate&plugin=siteorigin-panels/siteorigin-panels.php&plugin_status=all'), 'activate-plugin_siteorigin-panels/siteorigin-panels.php')?>" class="button button-primary">
                  <?php printf(__('Enable %s', 'sassy'), 'SiteOrigin Panels Page Builder')?>
                </a>
              <?php else:?>
                <a href="<?php echo wp_nonce_url(self_admin_url('update.php?action=install-plugin&plugin=siteorigin-panels'), 'install-plugin_siteorigin-panels')?>" class="button button-primary">
                  <?php printf(__('Install %s', 'sassy'), 'SiteOrigin Panels Page Builder')?>
                </a>
              <?php endif?>
            </td>
            <td>
              <p>
                <?php _e('The theme is aimed to work in cooperate with SiteOrigin\'s Page Builder. To see the full power of the theme, please enable/install the plugin.', 'sassy')?>
              </p>
            </td>
          </tr>
        <?php elseif (!$count_layouts || empty($count_layouts->publish)):?>
          <tr>
            <td>
              <button name="action" value="install-example-content" class="button" onclick="return confirm('<?php esc_attr_e('Are sure?', 'sassy')?>');">
                <?php _e('Install example layouts', 'sassy')?>
              </button>
            </td>
          </tr>
        <?php endif?>

        <tr>
          <td>
            <button name="action" value="clear-cache" class="button">
              <?php _e('Clear CSS cache', 'sassy')?>
            </button>
          </td>
        </tr>
      </table>

    </form>

  <?php endif?>

  <?php
  /**
   * General tools tab
   */
  if ($active_tab == 'uninstall'):
  ?>
  <p></p>
  <form method="post">
    <?php wp_nonce_field('sassy-system-action')?>
    <table class="wc_status_table widefat">
      <tr>
        <td>
          <button name="action" value="delete-sassy-settings" class="button" onclick="return confirm('<?php esc_attr_e('Are sure?', 'sassy')?>');">
            <?php _e('Delete all theme content and settings', 'sassy')?>
          </button>
        </td>
        <td>
          <p>
            <?php _e('This will delete all theme settings and layouts', 'sassy')?>
          </p>
        </td>
      </tr>
    </table>
  </form>
  <?php endif?>

  <?php
  /**
   * Import/Export tab
   */
  if ($active_tab == 'importexport'):?>
  <h3>
    <?php _e('Export theme settings', 'sassy')?>
  </h3>

  <p>
    <a href="<?php echo home_url()?>?sassy-ajax=settings-export&r=<?php echo microtime(1)?>" class="button">
      <?php _e('Download current snapshot of Sassy theme configuration', 'sassy')?>
    </a>
    <a href="<?php echo home_url()?>?sassy-ajax=settings-export&settings-only=true&r=<?php echo microtime(1)?>" class="button">
      <?php _e('Download settings only', 'sassy')?>
    </a>
  </p>

  <hr />

  <form method="post" enctype="multipart/form-data">
    <?php wp_nonce_field('sassy-system-action')?>
    <input type="hidden" name="action" value="import" />
    <h3>
      <?php _e('Import Sassy settings from file', 'sassy')?>
    </h3>
    <p class="description">
      <?php _e('All current settings will be overriden', 'sassy')?>
    </p>
    <p>
      <input type="file" name="import_file" accept=".sassy" />
      <?php submit_button(__('Import', 'sassy'), 'secondary', 'submit', FALSE)?>
    </p>
    <p>
      <label>
        <input type="checkbox" name="delete_current_layouts" value="1" />
        <?php _e('Delete all current existing layouts.', 'sassy')?>
      </label>
    </p>
  </form>
  <?php endif?>

  <?php
  /**
   * Sass variables tab
   */
  if ($active_tab == 'sassvars'):

    $settings = SassySettings::options();
    $_variables = array(
      'theme_assets' => '"' . get_template_directory_uri() . '/assets"',
    );
    foreach ($settings as $setting_id => $setting_info) {
      if (!empty($setting_info['export_scss'])) {
        if ($setting_info['value'] === NULL || $setting_info['value'] == '') {
          $val = 'null';
        }
        else {
          $val = $setting_info['value'];
        }
        $_variables[$setting_id] = $val;
      }
    }
    $_variables = apply_filters('sassy_scss_settings', $_variables);
    $_variables_code = '// Sass variables';
    foreach ($_variables as $key => $val) {
      $_variables_code .= "<br />\${$key}: {$val};";
    }

    echo '<p></p><code>' . $_variables_code . '</code>';

  endif?>

</div>
