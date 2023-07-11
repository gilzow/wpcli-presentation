<?php
namespace gilzow\wpcli\commands;
use \WP_CLI, \JsonException;
use function WP_CLI\Utils\make_progress_bar;
use function WP_CLI\Utils\format_items;

if (! defined('WP_CLI')) {
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
    protected array $sites;

    /**
     * Returns a multisite report with extended data via metadata
     * ## OPTIONS
     *
     * [--metadata=<values>]
     * : Comma-separated list of meta field values to include in the report
     *
     * [--format=<format>]
     * : format to use for output
     * ---
     * default: table
     * options
     *  - table
     *  - json
     *  - csv
     *  - yaml
     * ---
     *
     * ## EXAMPLES
     *
     *        # Display a multisite report
     *        $ wp site report --metadata=owner,ticketnumber,division
     *
     * @param array $args
     * @param array $assoc_args
     * @return void
     */
    public function __invoke(array $args, array $assoc_args) : void {
        //@todo should we support the --fields argument and pass to our command to get sites?
        $jsonSites = WP_CLI::runcommand('site list --format=json', ['return'=>true]);

        try {
            $this->sites = json_decode($jsonSites, true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $exception) {
            WP_CLI::error_multi_line(["Unable to retrieve list of sites!",$exception->getMessage()]);
        }

        $progress = make_progress_bar( 'Generating report...', count($this->sites) );

        if(isset($assoc_args['metadata']) && !empty($assoc_args['metadata'])) {
            // let's get the list of meta_keys we need to retrieve
            $baseKeys = array_fill_keys(explode(',',$assoc_args['metadata']),'');
            foreach ($this->sites as $key=>$site) {
                $command = sprintf('site meta list %d --keys=%s --fields=meta_key,meta_value --format=json',$site['blog_id'],$assoc_args['metadata']);
                $jsonSiteMeta = WP_CLI::runcommand($command,['return'=>true]);
                try {
                    $siteMeta = json_decode($jsonSiteMeta,true,512, JSON_THROW_ON_ERROR);
                } catch (JsonException $exception) {
                    WP_CLI::error_multi_line(["Unable to retrieve meta data for site ${site['blog_id']}!",$exception->getMessage()]);
                }
                //now we need to merge the returned metadata with the base set to make sure all sites have an entry
                $reformatted = array_merge($baseKeys,array_column($siteMeta,'meta_value','meta_key'));

                //combine the metadata back with our existing data
                $this->sites[$key] = $site + $reformatted;
                $progress->tick();
            }
        }

        $progress->finish();
        //check if --format is given to use here for format
        format_items($assoc_args['format'],$this->sites,array_keys($this->sites[0]));
    }
}

WP_CLI::add_command('site report',SiteReport::class,array(
    'before_invoke' => static function(){
        if ( ! is_multisite() ) {
            WP_CLI::error( 'This is not a multisite installation.' );
        }
    },
));
