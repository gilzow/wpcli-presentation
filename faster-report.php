<?php
namespace wpcampus\wpcli\commands;
use WP_CLI;
use function WP_CLI\Utils\format_items;
/**
 * Plugin Name:     site-report2
 * Plugin URI:      https://gilzow.com/site-report2
 * Description:     Generates a custom multisite report
 * Author:          Paul Gilzow
 * Author URI:      https://gilzow.com/
 * Text Domain:     site-report2
 * Domain Path:     /languages
 * Version:         0.1.0
 *
 * @package         SITE_REPORT_2
 */
if (! defined('WP_CLI')) {
    return;
}

class SiteReporter
{
    /**
     * Generates a custom multiste report with selected metadata
     *
     * ## OPTIONS
     * [--metadata=<value>]
     * : a comma seperated list of meta_keys that we want included in the report
     *
     * [--format=<format>]
     * ___
     * default: table
     * options
     *  - table
     *  - json
     *  - csv
     *  - yaml
     * ---
     *
     * ## EXAMPLES
     *      # Generate a report
     *      $ wp site report --metadata=owner,division
     *
     * @param array $args
     * @param array $assoc_args
     * @return void
     */
    public function __invoke(array $args, array $assoc_args): void
    {
        $defaultKeys = array_fill_keys(['blog_id','domain','registered','last_updated'],'');
        $arySites = get_sites();
        $sites = [];
        foreach ($arySites as $siteid=>$site) {
            $site = array_intersect_key((array)$site,$defaultKeys);

            if (isset($assoc_args['metadata']) && !empty($assoc_args['metadata'])) {
                $baseKeys = array_fill_keys(explode(',',$assoc_args['metadata']),'');

                $siteMeta = array_merge($baseKeys,array_intersect_key(array_map(static function ($item){
                    return reset($item);
                },get_site_meta($site['blog_id'])),$baseKeys));

                $site += $siteMeta;
            }

            $sites[$siteid] = $site;
        }

        format_items($assoc_args['format'],$sites,array_keys($sites[0]));
        WP_CLI::success("Report Generated.");
    }
}

WP_CLI::add_command("site report2",SiteReporter::class, [
    'before_invoke' => function() {
        if (!is_multisite()) {
            WP_CLI::error("This is not a multisite!");
        }
    }
]);
