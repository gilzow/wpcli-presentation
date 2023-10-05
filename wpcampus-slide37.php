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
 * ## OPTIONS
 * [<name>]
 * : Name of the person to greet
 *
 * [--subject=<subject>]
 * : What topic sessions interests this person
 *
 * ## EXAMPLES
 *
 *      # Welcome a user
 *      $ wp wpcampus Paul --subject=InfoSec
 *      Welcome to WPCampus, Paul!!!
 *      You are interested in sessions on InfoSec.
 */
WP_CLI::add_command('wpcampus',function ($args, $assoc_args){
    printf("Welcome to WPCampus%s!!!" . PHP_EOL, (isset($args[0])) ? ", ${args[0]}" : '');
    if(isset($assoc_args['subject'])) {
        echo "You are interested in sessions on ${assoc_args['subject']}.", PHP_EOL;
    }
});
