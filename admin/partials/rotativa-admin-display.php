<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://rotativahq.com/
 * @since      1.0.0
 *
 * @package    Rotativa
 * @subpackage Rotativa/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<div id="wrap">
    <form method="post" action="options.php">
		<?php
			settings_fields( 'rotativa-settings' );
			do_settings_sections( 'rotativa-settings' );
			submit_button();
		?>
    </form>
</div>