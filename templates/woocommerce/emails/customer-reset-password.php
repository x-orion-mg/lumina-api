<?php
/**
 * Customer Reset Password email
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/customer-reset-password.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates\Emails
 * @version 10.9.0
 */

use Automattic\WooCommerce\Utilities\FeaturesUtil;
use Lumina\ApiV2\WooCommerce\Services\EmailService;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$email_improvements_enabled = FeaturesUtil::feature_is_enabled( 'email_improvements' );

$user_email = '';
$login_url = EmailService::loginUrl();
$reset_password_url = EmailService::resetPasswordUrl();
if ( isset( $email->object ) && $email->object instanceof WP_User ) {
    $user_email = $email->object->user_email;
} else {
    $user_email = (string) $user_email;
}
if ( ! empty( $reset_password_url ) && ! empty( $set_password_url ) ) {

    $query = wp_parse_url( $set_password_url, PHP_URL_QUERY );

    if ( $query ) {
        $set_password_url = add_query_arg(
                wp_parse_args( $query ),
                $reset_password_url
        );
    } else {
        $set_password_url = $reset_password_url;
    }
}
?>

<?php do_action( 'woocommerce_email_header', $email_heading, $email ); ?>

<?php echo $email_improvements_enabled ? '<div class="email-introduction">' : ''; ?>
<?php /* translators: %s: Customer first name, or username if name is not available */ ?>
<p><?php printf( esc_html__( 'Hi %s,', 'woocommerce' ), esc_html( $user_display_name ) ); ?></p>
<?php /* translators: %s: Store name */ ?>
<p><?php printf( esc_html__( 'Someone has requested a new password for the following account on %s:', 'woocommerce' ), esc_html( $blogname ) ); ?></p>
<?php if ( $email_improvements_enabled ) : ?>
	<div class="hr hr-top"></div>
	<?php /* translators: %s: Username */ ?>
	<p><?php echo wp_kses( sprintf( __( 'Username: <b>%s</b>', 'woocommerce' ), esc_html( $user_email ) ), array( 'b' => array() ) ); ?></p>
	<div class="hr hr-bottom"></div>
	<p><?php esc_html_e( 'If you didn’t make this request, just ignore this email. If you’d like to proceed, reset your password via the link below:', 'woocommerce' ); ?></p>
<?php else : ?>
	<?php /* translators: %s: Customer username */ ?>
	<p><?php printf( esc_html__( 'Username: %s', 'woocommerce' ), esc_html( $user_email ) ); ?></p>
	<p><?php esc_html_e( 'If you didn\'t make this request, just ignore this email. If you\'d like to proceed:', 'woocommerce' ); ?></p>
<?php endif; ?>
<p>
	<a
            class="link"
            href="<?php
            $resetUrl = add_query_arg(
                    [
                            'key'    => $reset_key,
                            'login'  => rawurlencode($user_login),
                    ],
                    EmailService::resetPasswordUrl()
            );
            echo esc_url( $resetUrl ); ?>"
    >
        <?php // phpcs:ignore WordPress.Arrays.ArrayDeclarationSpacing.AssociativeArrayFound ?>
		<?php
		if ( $email_improvements_enabled ) {
			esc_html_e( 'Reset your password', 'woocommerce' );
		} else {
			esc_html_e( 'Click here to reset your password', 'woocommerce' );
		}
		?>
	</a>
</p>
<?php echo $email_improvements_enabled ? '</div>' : ''; ?>

<?php
/**
 * Show user-defined additional content - this is set in each email's settings.
 */
if ( $additional_content ) {
	echo $email_improvements_enabled ? '<table border="0" cellpadding="0" cellspacing="0" width="100%" role="presentation"><tr><td class="email-additional-content email-additional-content-aligned">' : '';
	echo wp_kses_post( wpautop( wptexturize( $additional_content ) ) );
	echo $email_improvements_enabled ? '</td></tr></table>' : '';
}

do_action( 'woocommerce_email_footer', $email );
