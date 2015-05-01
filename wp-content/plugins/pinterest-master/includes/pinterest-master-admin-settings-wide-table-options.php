<?php
if(!class_exists('WP_List_Table')){
	require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}
class pinterest_master_admin_settings_wide_table_options extends WP_List_Table {
	/**
	 * Display the rows of records in the table
	 * @return string, echo the markup of the rows
	 */
	function display() {
//Set Activate TechGasp Pinterest System and ON
add_option ( 'pinterest_master_system_wide', "true" );
//Set Buttons Size
$pinterest_master_system_wide_size_small = "pinterest_master_system_wide_size_small";
update_option ('pinterest_master_system_wide_size_small', $pinterest_master_system_wide_size_small);
$pinterest_master_system_wide_size_large = "pinterest_master_system_wide_size_large";
update_option ('pinterest_master_system_wide_size_large', $pinterest_master_system_wide_size_large);
//Set Buttons Shape
$pinterest_master_system_wide_shape_rectangular = "pinterest_master_system_wide_shape_rectangular";
update_option ('pinterest_master_system_wide_shape_rectangular', $pinterest_master_system_wide_shape_rectangular);
$pinterest_master_system_wide_shape_circular = "pinterest_master_system_wide_shape_circular";
update_option ('pinterest_master_system_wide_shape_circular', $pinterest_master_system_wide_shape_circular);
//Set Buttons Colour
$pinterest_master_system_wide_color_gray = "pinterest_master_system_wide_color_gray";
update_option ('pinterest_master_system_wide_color_gray', $pinterest_master_system_wide_color_gray);
$pinterest_master_system_wide_color_red = "pinterest_master_system_wide_color_red";
update_option ('pinterest_master_system_wide_color_red', $pinterest_master_system_wide_color_red);
$pinterest_master_system_wide_color_white = "pinterest_master_system_wide_color_white";
update_option ('pinterest_master_system_wide_color_white', $pinterest_master_system_wide_color_white);
//Save Options
if ( $_POST) {
if ( isset($_POST['pinterest_master_system_wide']) )
update_option('pinterest_master_system_wide', $_POST['pinterest_master_system_wide'] );
else
update_option('pinterest_master_system_wide', 'false' );

if ( isset($_POST['pinterest_master_system_wide_size']) )
update_option('pinterest_master_system_wide_size', $_POST['pinterest_master_system_wide_size'] );
else
update_option('pinterest_master_system_wide_size', 'false' );

if ( isset($_POST['pinterest_master_system_wide_shape']) )
update_option('pinterest_master_system_wide_shape', $_POST['pinterest_master_system_wide_shape'] );
else
update_option('pinterest_master_system_wide_shape', 'false' );

if ( isset($_POST['pinterest_master_system_wide_color']) )
update_option('pinterest_master_system_wide_color', $_POST['pinterest_master_system_wide_color'] );
else
update_option('pinterest_master_system_wide_color', 'false' );

if ( isset($_POST['pinterest_master_system_wide_hover']) )
update_option('pinterest_master_system_wide_hover', $_POST['pinterest_master_system_wide_hover'] );
else
update_option('pinterest_master_system_wide_hover', 'false' );

//Update Other buttons with these settings
if (get_option('pinterest_master_system_wide_size') == "pinterest_master_system_wide_size_small"){
update_option('pinterest_master_system_wide_size_b', "20.png");
}
if (get_option('pinterest_master_system_wide_size') == "pinterest_master_system_wide_size_large"){
update_option('pinterest_master_system_wide_size_b', "28.png");
}
if (get_option('pinterest_master_system_wide_shape') == "pinterest_master_system_wide_shape_rectangular"){
update_option('pinterest_master_system_wide_shape_b', "rect_");
}
if (get_option('pinterest_master_system_wide_shape') == "pinterest_master_system_wide_shape_circular"){
update_option('pinterest_master_system_wide_shape_b', "round_");
}
if (get_option('pinterest_master_system_wide_color') == "pinterest_master_system_wide_color_gray"){
update_option('pinterest_master_system_wide_color_b', "gray_");
}
if (get_option('pinterest_master_system_wide_color') == "pinterest_master_system_wide_color_red"){
update_option('pinterest_master_system_wide_color_b', "red_");
}
if (get_option('pinterest_master_system_wide_color') == "pinterest_master_system_wide_color_white"){
update_option('pinterest_master_system_wide_color_b', "white_");
}

?>
<div id="message" class="updated fade">
<p><strong><?php _e('Settings Saved!', 'pinterest_master'); ?></strong></p>
</div>
<?php
}
?>
<form method="post" width='1'>
<fieldset class="options">

<table class="widefat fixed" cellspacing="0">
	<thead>
		<tr>
			<th id="cb" class="manage-column column-cb check-column" scope="col" style="vertical-align:middle"><input type="checkbox"></th>
			<th id="columnname" class="manage-column column-columnname" scope="col" width="250"><legend><h3><img src="<?php echo plugins_url('../images/techgasp-minilogo-16.png', __FILE__); ?>" style="float:left; height:16px; vertical-align:middle;" /><?php _e('&nbsp;System Wide Settings', 'pinterest_master'); ?></h3></legend></th>
			<th id="columnname" class="manage-column column-columnname" scope="col"></th>
		</tr>
	</thead>

	<tfoot>
		<tr>
			<th class="manage-column column-cb check-column" scope="col"></th>
			<th class="manage-column column-columnname" scope="col" width="250"></th>
			<th class="manage-column column-columnname" scope="col"></th>
		</tr>
	</tfoot>

	<tbody>
		<tr class="alternate">
			<th class="check-column" scope="row">
<input name="pinterest_master_system_wide" id="pinterest_master_system_wide" value="true" type="checkbox" <?php echo get_option('pinterest_master_system_wide') == 'true' ? 'checked="checked"':''; ?> />
			</th>
			<td class="column-columnname" width="250">
<label for="pinterest_master_system_wide"><b><?php _e('Activate TechGasp Pinterest System', 'pinterest_master'); ?></b></label>
			</td>
			<td class="column-columnname" style="vertical-align:middle">Default is <b>On</b>, if off no shortcodes or widgets will be loaded.</td>
		</tr>
		<tr>
			<th class="check-column" scope="row"></th>
			<td class="column-columnname" width="250">
<label for="pinterest_master_system_wide_size"><b><?php _e('Select Pin-it Button Size:', 'pinterest_master'); ?></b></label>
			</td>
			<td class="column-columnname" style="vertical-align:middle">
<select id="pinterest_master_system_wide_size" name="pinterest_master_system_wide_size" style="width:165px">
<option>Select Pint-it Size</option>
<option value="<?php echo get_option('pinterest_master_system_wide_size_small'); ?>" <?php echo get_option('pinterest_master_system_wide_size') == 'pinterest_master_system_wide_size_small' ? 'selected="selected"':''; ?>>Small</option>
<option value="<?php echo get_option('pinterest_master_system_wide_size_large'); ?>" <?php echo get_option('pinterest_master_system_wide_size') == 'pinterest_master_system_wide_size_large' ? 'selected="selected"':''; ?>>Large</option>
</select>
			</td>
		</tr>
		<tr class="alternate">
			<th class="check-column" scope="row"></th>
			<td class="column-columnname" width="250">
<label for="pinterest_master_system_wide_shape"><b><?php _e('Select Pin-it Button Shape:', 'pinterest_master'); ?></b></label>
			</td>
			<td class="column-columnname">
<select id="pinterest_master_system_wide_shape" name="pinterest_master_system_wide_shape" style="width:165px">
<option>Select Pint-it Shape</option>
<option value="<?php echo get_option('pinterest_master_system_wide_shape_rectangular'); ?>" <?php echo get_option('pinterest_master_system_wide_shape') == 'pinterest_master_system_wide_shape_rectangular' ? 'selected="selected"':''; ?>>Rectangular</option>
<option value="<?php echo get_option('pinterest_master_system_wide_shape_circular'); ?>" <?php echo get_option('pinterest_master_system_wide_shape') == 'pinterest_master_system_wide_shape_circular' ? 'selected="selected"':''; ?>>Circular</option>
</select>
		</td>
		</tr>
		<tr>
			<th class="check-column" scope="row"></th>
			<td class="column-columnname" width="250">
<label for="pinterest_master_system_wide_color"><b><?php _e('Select Pin-it Button Colour:', 'pinterest_master'); ?></b></label>
			</td>
			<td class="column-columnname">
<select id="pinterest_master_system_wide_color" name="pinterest_master_system_wide_color" style="width:165px">
<option>Select Pint-it Colour</option>
<option value="<?php echo get_option('pinterest_master_system_wide_color_gray'); ?>" <?php echo get_option('pinterest_master_system_wide_color') == 'pinterest_master_system_wide_color_gray' ? 'selected="selected"':''; ?>>Gray</option>
<option value="<?php echo get_option('pinterest_master_system_wide_color_red'); ?>" <?php echo get_option('pinterest_master_system_wide_color') == 'pinterest_master_system_wide_color_red' ? 'selected="selected"':''; ?>>Red</option>
<option value="<?php echo get_option('pinterest_master_system_wide_color_white'); ?>" <?php echo get_option('pinterest_master_system_wide_color') == 'pinterest_master_system_wide_color_white' ? 'selected="selected"':''; ?>>White</option>
</select>
			</td>
		</tr>
		<tr class="alternate">
			<th class="check-column" scope="row">
<input name="pinterest_master_system_wide_hover" id="pinterest_master_system_wide_hover" value="true" type="checkbox" <?php echo get_option('pinterest_master_system_wide_hover') == 'true' ? 'checked="checked"':''; ?> />
			</th>
			<td class="column-columnname" width="250">
<label for="pinterest_master_system_wide_hover"><b><?php _e('Activate Pin It Hover Button', 'pinterest_master'); ?></b></label>
			</td>
			<td class="column-columnname"><b>TechGasp Pinterest System must be On</b>. Automatically displays the pin-it button the on mouse-over your wordpress photos.</td>
		</tr>
	</tbody>
</table>
<p class="submit"><input class='button-primary' type='submit' name='update' value='<?php _e("Save Settings", 'pinterest_master'); ?>' id='submitbutton' /></p>
</fieldset>
</form>
<?php
	}
//CLASS ENDS
}