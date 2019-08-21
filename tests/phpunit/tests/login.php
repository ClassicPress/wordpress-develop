<?php
/**
 * @group login
 * @group login
 */
class Tests_Login extends WP_UnitTestCase {
	function setUp() {
		parent::setUp();
		reset_phpmailer_instance();
	}

	function tearDown() {
		reset_phpmailer_instance();
		parent::tearDown();
	}

	/**
     * @runInSeparateProcess
     */
     public function test_reset_password() {
     	ob_start();
		include_once( ABSPATH . '/wp-login.php' );
		$_POST['user_login'] = 'admin';
		retrieve_password();

		$mailer = tests_retrieve_phpmailer_instance();
		ob_end_clean();

		$regex = '/[^<]http:\/\/example.org\/wp-login\.php\?action=rp\&key=[a-zA-Z0-9]{20}\&login=admin[^>]$/i';

		$test = preg_match( $regex, $mailer->get_sent()->body );

		$this->assertEquals( $test, 1 );
	}
}
