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

/**
 * Welcomes a user to WPCampus 2023
 *
 * ## EXAMPLES
 *
 *      # Welcome a user
 *      $ wp wpcampus
 *      Welcome to WPCampus!!!
 */
WP_CLI::add_command('wpcampus',function ($args, $assoc_args){
    printf("Welcome to WPCampus%s!!!" . PHP_EOL, ($args[0]) ? ", ${args[0]}" : '');
});
