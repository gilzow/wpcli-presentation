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
 * Greet and say farewell to WPCampus attendees
 */
class wpcampus
{
    /**
     * Welcomes a user to WPCampus 2023
     *
     * ## OPTIONS
     * <name>
     * : Name of the person to greet
     *
     * --subject=<subject>
     * : What topic sessions interests this person
     *
     * ## EXAMPLES
     *
     *      # Welcome a user
     *      $ wp wpcampus Paul --subject=InfoSec
     *      Welcome to WPCampus, Paul!!!
     *      You are interested in sessions on InfoSec.
     */
    public function greet($args, $assoc_args) {
        printf("Welcome to WPCampus%s!!!" . PHP_EOL, ($args[0]) ? ", ${args[0]}" : '');
        if(isset($assoc_args['subject'])) {
            echo "You are interested in sessions on ${assoc_args['subject']}.", PHP_EOL;
        }
    }


    /**
     * Say farewell to our participants, and thank our speakers
     *
     * ## OPTIONS
     * [--speaker]
     * : was the user a speaker
     *
     * ## EXAMPLES
     *
     *      # Say farewell
     *      $ wp wpcampus goodbye --speaker
     *      Thanks for joining us this year at WPCampus!
     *      Your contribution as a speaker was truly appreciated!
     *
     */
    public function goodbye($args, $assoc_args) {
        echo "Thanks for joining us this year at WPCampus!", PHP_EOL;
        if (isset($assoc_args['speaker']) && $assoc_args['speaker']) {
            echo "Your contribution as a speaker was truly appreciated!", PHP_EOL;
        }
    }
}

WP_CLI::add_command('wpcampus',wpcampus::class);
