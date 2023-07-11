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
 * [<name>...]
 * : Name of the persons to greet
 * ---
 * default: John
 * options:
 *  - John
 *  - Paul
 *  - George
 *  - Ringo
 * ---
 *
 * [--subject=<subject>]
 * : What topic sessions interests this person
 *
 * ## EXAMPLES
 *
 *      # Welcome a user
 *      $ wp wpcampus --subject=InfoSec
 *      Welcome to WPCampus, John!!!
 *      You are interested in sessions on InfoSec.
 *
 *      # Welcome several users
 *      $ wp wpcampus Paul Ringo George
 *      Welcome to WPCampus, Paul, Ringo, George!!!
 */
WP_CLI::add_command('wpcampus',function ($args, $assoc_args){
    $msg = "Welcome to WPCampus";
    $last = array_key_last($args);
    foreach ($args as $index => $name) {
        $msg .= ', ';
        if ($index === $last && 1 !== count($args)) {
            $msg .= 'and ';
        }
        $msg .= $name;
    }
    echo $msg,'!!!',PHP_EOL;
    if(isset($assoc_args['subject'])) {
        echo "You are interested in sessions on ${assoc_args['subject']}", PHP_EOL;
    }
});
