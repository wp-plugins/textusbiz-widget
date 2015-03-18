<?php
/*
Plugin Name: TextUs.Biz Widget
Version: 0.1
Plugin URI: 
Description: 
Author: Rage Digital
Author URI: http://ragedigital.com
*/

/*  Copyright 2015  Erich Sparks for Rage Digital (email : contact@erichsparks.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/


add_action('admin_menu', 'textus_admin_actions');
add_action('admin_init', 'textus_build_fields');

/* Add admin menu link */
function textus_admin_actions() {
	add_options_page("TextUs.Biz Widget", "TextUs.Biz Widget", 'administrator', "textus_widget", "options_page_fn");
}

/* Register and build fields */
function textus_build_fields() {
   register_setting('plugin_options', 'plugin_options', '');

   add_settings_section('main_section', 'Main Settings', 'section_cb', __FILE__);

   add_settings_field('key', 'Copy and paste user ID here:', 'key_setting', __FILE__, 'main_section');
   add_settings_field('color_scheme', 'Color Scheme:', 'color_scheme_setting', __FILE__, 'main_section');
   add_settings_field('button_type', 'Button Type:', 'button_type_setting', __FILE__, 'main_section');
}

/* Add admin page settings */
function options_page_fn() {
?>
   <div class="wrap">
      <h2>Textus.Biz Widget Options</h2>

      <form method="post" action="options.php" enctype="multipart/form-data">
         <?php settings_fields('plugin_options'); ?>
         <?php do_settings_sections(__FILE__); ?>
         <p class="submit">
            <input name="Submit" type="submit" value="<?php esc_attr_e('Update Options'); ?>" />
         </p>
       </form>
    </div>
<?php
}

// Key
function key_setting() {
   $options = get_option('plugin_options');
   echo "<input name='plugin_options[key]' type='text' value='{$options['key']}' />";
}

// Color Scheme
function color_scheme_setting() {
   $options = get_option('plugin_options');
   $names = array("Tab Dark", "Tab Light", "Square Button", "Small Button", "Large Button");
   $items = array("tab-dark", "tab-light", "square-button", "small-button", "large-button"); 

   echo "<select name='plugin_options[color_scheme]'>";
   foreach (array_combine($names, $items) as $name => $item) {
      $selected = ( $options['color_scheme'] === $item ) ? 'selected = "selected"' : '';
      echo "<option value='$item' $selected>$name</option>";
   }
   echo "</select>";
}

// Button Type
function button_type_setting() {
   $options = get_option('plugin_options');
   $names = array("Tab", "Button");
   $items = array("tab", "button"); 

   echo "<select name='plugin_options[button_type]'>";
   foreach (array_combine($names, $items) as $name => $item) {
      $selected = ( $options['button_type'] === $item ) ? 'selected = "selected"' : '';
      echo "<option value='$item' $selected>$name</option>";
   }
   echo "</select>";
}


add_action('wp_head', 'textus_script_function');
function textus_script_function() { 
	
	$options = get_option('plugin_options');
	
	echo '<script src="http://app.textus.biz/widget/1/' . $options['key'] . '/embedded.js?textus-image=' . $options['color_scheme'] . '&textus-type=' . $options['button_type'] . '"></script>';
    
	?>
    <script>
		jQuery(document).ready( function($) {
			$('body').prepend('<div id="text-us-placeholder"></div>');
		} );
	</script>
	<?php 
}

function section_cb() {}

?>