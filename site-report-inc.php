<?php
namespace gilzow\wpcli\commands;
use \WP_CLI, \JsonException;
use function WP_CLI\Utils\format_items;

if ( ! defined('WP_CLI') ) {
    return;
}

/**
 * Plugin Name:     site-report
 * Plugin URI:      https://gilzow.com/site-report
 * Description:
 * Author:          Paul Gilzow
 * Author URI:      https://gilzow.com/
 * Text Domain:     site-report
 * Domain Path:     /languages
 * Version:         0.1.0
 *
 * @package         SITE_REPORT
 */

class SiteReport
{

    /**
     * Returns a multisite report with extended data via metadata
     * ## OPTIONS
     *
     * [--metadata=<values>]
     * : Comma-separated list of meta field values to include in the report
     *
     * ## EXAMPLES
     *
     * 		# Display a multisite report
     * 		$ wp site report --metadata=owner,ticketnumber,division
     *
     * @param $args
     * @param $assoc_args
     * @return void
     */
    public function __invoke(array $args, array $assoc_args) : void {




        if(isset($assoc_args['metadata']) && !empty($assoc_args['metadata'])) {
            $baseKeys = array_fill_keys(explode(',',$assoc_args['metadata']),'');
//            foreach ($sites as $key=>$site) {
//                $command = sprintf('site meta list %d --keys=%s --fields=meta_key,meta_value --format=json',$site['blog_id'],$assoc_args['metadata']);
//
//
//                //now we need to merge the returned metadata with the base set to make sure all sites have an entry
//                $reformatted = array_merge($baseKeys,array_column($siteMeta,'meta_value','meta_key'));
//            }
        }

    }
}

WP_CLI::add_command('site report',SiteReport::class,array(
    'before_invoke' => static function(){
        if ( ! is_multisite() ) {
            WP_CLI::error( 'This is not a multisite installation.' );
        }
    },
));
