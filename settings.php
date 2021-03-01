<link rel="stylesheet" href="<?php echo plugin_dir_url( __FILE__ ) . 'static/css/cookiewow.css'; ?>">
<div class="cookiewow-wrap">
    <img class="cookiewow-logo" src="<?php echo plugin_dir_url( __FILE__ ) . 'static/images/logo-cookiewow.svg'; ?>" />
	<form action="options.php" method="post" class="cookiewow-form">
		<?php
		settings_fields( 'cookiewow_settings_fields' );
		do_settings_sections( 'cookiewow-settings' );
		submit_button();
		?>
	</form>
    <!-- <hr />
    <section class="cookiewow-howto">
        <h1>How to...</h1>
        <ol>
            <li>Coffee</li>
            <li>Tea</li>
            <li>Milk</li>
        </ol>
    </section> -->
</div>
