<?php
## initial command, slide 10
if ( ! class_exists(WP_CLI::class) ) {
    return;
}

WP_CLI::add_command('wpcampus',function (){
    echo "Welcome to WPCampus!!!",PHP_EOL;
});

## docs, slide 22
/**
 * Welcomes a user to WPCampus 2023
 *
 * ## EXAMPLES
 *
 *      # Welcome a user
 *      $ wp wpcampus
 *      Welcome to WPCampus!!!
 */


## adds our positional argument, slide 29
WP_CLI::add_command('wpcampus',function ($args, $assoc_args){
    printf("Welcome to WPCampus%s!!!" . PHP_EOL, ($args[0]) ? ", ${args[0]}" : '');
});

## adds our associative argument, slide 30
WP_CLI::add_command('wpcampus',function ($args, $assoc_args){
    printf("Welcome to WPCampus%s!!!" . PHP_EOL, ($args[0]) ? ", ${args[0]}" : '');
    if(isset($assoc_args['subject'])) {
        echo "You are interested in sessions on ${assoc_args['subject']}.", PHP_EOL;
    }
});

## Expanded docs for command above, slide 32
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

## optional arguments, slide 37
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

## more fun with PHPDocs, slide 40
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

## Subcommands two functions, slide 45
WP_CLI::add_command('wpcampus greet',function ($args, $assoc_args){
    printf("Welcome to WPCampus%s!!!" . PHP_EOL, ($args[0]) ? ", ${args[0]}" : '');
});

WP_CLI::add_command('wpcampus goodbye',function ($args, $assoc_args){
    printf("Thanks for being with us%s!!!" . PHP_EOL, ($args[0]) ? ", ${args[0]}" : '');
});

## Subcommands, class with public methods, slide 47
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


