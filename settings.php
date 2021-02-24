<div class="wrap">
	<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
	<form action="options.php" method="post">
		<?php
            settings_fields( 'cookiewow_settings_fields' );
            do_settings_sections( 'cookiewow-settings' );
            submit_button();
		?>
	</form>
</div>
