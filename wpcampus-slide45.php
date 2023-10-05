<?php
/**
 * Plugin Name:     wpcampus
 * Plugin URI:      https://gilzow.com/wpcampus
 * Description:     Greet WPCampus attendees
 * Author:          Paul Gilzow
 * Author URI:      https://gilzow.com/
 * Text Domain:     wpcampus
 * Domain Path:     /languages
 * Version:         0.1.0
 *
 * @package         WPCAMPUS
 */
if ( ! defined('WP_CLI') ) {
    return;
}

WP_CLI::add_command('wpcampus greet',function ($args, $assoc_args){
    printf("Welcome to WPCampus%s!!!" . PHP_EOL, (isset($args[0])) ? ", ${args[0]}" : '');
});

WP_CLI::add_command('wpcampus goodbye',function ($args, $assoc_args){
    printf("Thanks for being with us%s!!!" . PHP_EOL, (isset($args[0])) ? ", ${args[0]}" : '');
});
