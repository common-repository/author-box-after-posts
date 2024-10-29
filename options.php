<div class="wrap">
	
    <?php screen_icon(); ?>
    
	<form action="options.php" method="post" id="<?php echo $plugin_id; ?>_options_form" name="<?php echo $plugin_id; ?>_options_form">
    
	<?php settings_fields($plugin_id.'_options'); ?>
    
    <h2>Author Box After Posts &raquo; Settings</h2>
    <table class="widefat">
		<thead>
		   <tr>
			 <th>
			 <a target="_blank" href="https://www.pandasilk.com/wordpress-author-box-after-posts-plugin/">FAQs</a> <br>
			 <a target="_blank" href="https://wordpress.org/support/plugin/author-box-after-posts">Support Forum</a>  </th>
		   </tr>
		</thead>

		<tbody>
		   <tr>
			 <td style="padding:25px;font-family:Verdana, Geneva, sans-serif;color:#666;">	 
<label>Show Email ?</label><input type="checkbox" name="enable_abap_email" value="1" <?php checked(1,get_option('enable_abap_email'));?> />
             </td>
		   </tr>
		</tbody>
		

		<tfoot>
		   <tr>
			 <th><input type="submit" name="submit" value="Save Settings" class="button button-primary" /></th>
		   </tr>
		</tfoot>
	</table>
    
	</form>
    
</div>