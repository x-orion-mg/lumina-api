<?php
namespace Lumina\ApiV2\WooCommerce\Services;

class EmailService
{
    public static function loginUrl(): string
    {
        return (string) get_field('login_page_url', 'option');
    }

    public static function resetPasswordUrl(): string
    {
        return (string) get_field('password_reset_url', 'option');
    }
}