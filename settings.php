<?php
/**
 * Cookie Wow WordPress
 *
 * @package cookiewow-wordpress
 */

?>
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
    <hr />
    <section class="cookiewow-howto-container">
        <article class="cookiewow-howto">
            <h3>
                Sign in to
                <a
                    href="https://cookiewow.com/"
                    target="_blank"
                    rel="norefferer"
                >Cookie Wow</a>
                (Or sign up
                    <a
                        href="https://app.cookiewow.com/users/sign_up"
                        target="_blank"
                        rel="norefferer"
                    >here</a>
                )
            </h3>
            <ol>
                <li>Add your wordpress domain</li>
                <li>Go to your domain dashboard and click Customize</li>
                <li>Copy Banner ID from “Get script” button</li>
                <li>Paste Banner ID on Wordpress plug-in and click “Save Changes”</li>
            </ol>
            <p>Read full instruction
                <a
                    href="https://cookiewow.crisp.help/th/article/cookie-wow-wordpress-16sumbv/"
                    target="_blank"
                    rel="norefferer"
                >
                    here
                </a>
            </p>
            <hr />
        </article>
        <article class="cookiewow-howto">
            <h3>
                เข้าสู่ระบบ
                <a
                    href="https://cookiewow.com/"
                    target="_blank"
                    rel="norefferer"
                >Cookie Wow</a>
                (หรือลงชื่อเข้าใช้
                    <a
                        href="https://app.cookiewow.com/users/sign_up"
                        target="_blank"
                        rel="norefferer"
                    >ที่นี่</a>
                )
            </h3>
            <ol>
                <li>เพิ่มโดเมนของเว็บไซต์ WordPress ของคุณ</li>
                <li>ไปที่แดชบอร์ดของ Cookie Wow แล้วคลิกที่เมนู Customize</li>
                <li>คลิกที่ปุ่ม “Get Script” แล้วคัดลอก Banner ID</li>
                <li>วาง Banner ID บน Plugin ของ WordPress แล้วคลิก “Save Changes”</li>
            </ol>
            <p>อ่านวิธีการติดตั้งฉบับเต็ม
                <a
                    href="https://cookiewow.crisp.help/th/article/cookie-wow-wordpress-16sumbv/"
                    target="_blank"
                    rel="norefferer"
                >
                    ที่นี่
                </a>
            </p>
        </article>
    </section>
</div>
