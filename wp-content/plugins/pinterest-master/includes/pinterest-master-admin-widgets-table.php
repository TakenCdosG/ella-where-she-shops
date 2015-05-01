<?php
if(!class_exists('WP_List_Table')){
	require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}
class pinterest_master_admin_widgets_table extends WP_List_Table {
	/**
	 * Display the rows of records in the table
	 * @return string, echo the markup of the rows
	 */
	function display() {
?>
<table class="widefat fixed" cellspacing="0">
	<thead>
		<tr>
			<th id="columnname" class="manage-column column-columnname" scope="col" width="300"><legend><h3><img src="<?php echo plugins_url('../images/techgasp-minilogo-16.png', __FILE__); ?>" style="float:left; height:16px; vertical-align:middle;" /><?php _e('&nbsp;Screenshot', 'pinterest_master'); ?></h3></legend></th>
			<th id="columnname" class="manage-column column-columnname" scope="col"><h3><img src="<?php echo plugins_url('../images/techgasp-minilogo-16.png', __FILE__); ?>" style="float:left; height:16px; vertical-align:middle;" /><?php _e('&nbsp;Description', 'pinterest_master'); ?></h3></legend></th>
		</tr>
	</thead>

	<tfoot>
		<tr>
			<th class="manage-column column-columnname" scope="col" width="300"><a class="button-primary" href="/wp-admin/widgets.php" title="To Widgets Page" style="float:left;">To Widgets Page</a></p></th>
			<th class="manage-column column-columnname" scope="col"><a class="button-primary" href="/wp-admin/widgets.php" title="To Widgets Page" style="float:right;">To Widgets Page</a></p></th>
		</tr>
	</tfoot>

	<tbody>
		<tr class="alternate">
			<td class="column-columnname" width="300" style="vertical-align:middle"><img src="<?php echo plugins_url('../images/techgasp-pinterestmaster-admin-widget-buttons.png', __FILE__); ?>" alt="<?php echo get_option('pinterest_master_name'); ?>" align="left" width="300px" height="135px" style="padding:5px;"/></td>
			<td class="column-columnname"style="vertical-align:middle"><h3>Pinterest Advanced Buttons Widget</h3><p>Advanced <b>Follow me on Pinterest</b> button. <b>Pin It button</b> in red or grey variant. <b>Pin It Hover</b> button for your wordpress photos, in red or grey variant. <b>The Perfect Widget to go pinterest viral and increase your Google SEO.</b> This widget works great when published under any of the below widgets, just turn off the widget title.</p><p>Check all the advanced options. Navigate to your wordpress widgets page and start using it.</p></td>
		</tr>
		<tr>
			<td class="column-columnname" width="300" style="vertical-align:middle"><img src="<?php echo plugins_url('../images/techgasp-pinterestmaster-admin-widget-board.png', __FILE__); ?>" alt="<?php echo get_option('pinterest_master_name'); ?>" align="left" width="300px" height="135px" style="padding:5px;"/></td>
			<td class="column-columnname"style="vertical-align:middle"><h3>Pinterest Advanced Board Widget</h3><p>Fast clean html5 code Pinterest Boards for your wordpress website. Perfect Google SEO. Advanced Pinterest Board Widget adds your favourite boards to your wordpress website in a matter of seconds. As many as you want always with fast page load times.<p>Check all the advanced options. Navigate to your wordpress widgets page and start using it.</p></td>
		</tr>
		<tr class="alternate">
			<td class="column-columnname" width="300" style="vertical-align:middle"><img src="<?php echo plugins_url('../images/techgasp-pinterestmaster-admin-widget-profile.png', __FILE__); ?>" alt="<?php echo get_option('pinterest_master_name'); ?>" align="left" width="300px" height="135px" style="padding:5px;"/></td>
			<td class="column-columnname"style="vertical-align:middle"><h3>Pinterest Advanced Profile Widget</h3><p>This is the "top of the line Advanced Pinterest Profile Widget". The easy way to add any Pinterest Profile to your wordpress website and "show off" all your pinterest stuff. Fast Clean Code and increased Google SEO.</p><p>Check all the advanced options. Navigate to your wordpress widgets page and start using it.</p></td>
		</tr>
		<tr>
			<td class="column-columnname" width="300" style="vertical-align:middle"><img src="<?php echo plugins_url('../images/techgasp-pinterestmaster-admin-widget-top-pin.png', __FILE__); ?>" alt="<?php echo get_option('amazon_master_name'); ?>" align="left" width="300px" height="135px" style="padding:5px;"/></td>
			<td class="column-columnname"style="vertical-align:middle"><h3>Pinterest Advanced Top Pin Widget</h3><p>Ever wanted to show and boost a single pin, Pinterest Master Advanced Pinterest Top Pins adds any pin to your wordpress website. Gorgeous pin display.</p><p>Check all the advanced options. Navigate to your wordpress widgets page and start using it.</p></td>
		</tr>
		<tr class="alternate">
			<td class="column-columnname" width="300" style="vertical-align:middle"><img src="<?php echo plugins_url('../images/techgasp-pinterestmaster-admin-widget-system.png', __FILE__); ?>" alt="<?php echo get_option('amazon_master_name'); ?>" align="left" width="300px" height="135px" style="padding:5px;"/></td>
			<td class="column-columnname"style="vertical-align:middle"><h3>Pinterest Advanced System Widget</h3><p>Pinterest API only allows one instance to be loaded per page. Pinterest Master System Widget avoids just that and allows you to load all widgets, shortcodes and buttons into a single page.</p><p>Navigate to your wordpress widgets page and start using it.</p></td>
		</tr>
		<tr>
			<td class="column-columnname" width="300" style="vertical-align:middle"><img src="<?php echo plugins_url('../images/techgasp-admin-widget-blank.png', __FILE__); ?>" alt="<?php echo get_option('amazon_master_name'); ?>" align="left" width="300px" height="135px" style="padding:5px;"/></td>
			<td class="column-columnname"style="vertical-align:middle"><h3>Suggest a Widget</h3><p>Would you like to see your widget idea added to this plugin? Just drop us a line and we will make sure it gets included in the next release.</p><p>Get in touch with TechGasp.</p></td>
		</tr>
	</tbody>
</table>
<?php
		}
}