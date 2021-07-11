<?php

namespace TechnoBureau\Ui\Presets;

use Illuminate\Filesystem\Filesystem;

class Bootstrap extends Preset
{
    /**
     * Install the preset.
     *
     * @return void
     */
    public static function install()
    {
        static::updatePackages();
        static::updateWebpackConfiguration();
        static::updateSass();
        static::updateBootstrapping();
        static::removeNodeModules();
    }

    /**
     * Update the given package array.
     *
     * @param  array  $packages
     * @return array
     */
    protected static function updatePackageArray(array $packages)
    {
        return [
            'bootstrap' => '^5.0.2',
            'jquery' => '^3.6',
            'popper.js' => '^1.16.1',
            'sass' => '^1.32.11',
            'sass-loader' => '^11.0.1',
            'TechnoBureau' => '^1.14.0-beta2',
        ] + $packages;
    }

    /**
     * Update the Webpack configuration.
     *
     * @return void
     */
    protected static function updateWebpackConfiguration()
    {
        copy(__DIR__.'/bootstrap-stubs/webpack.mix.js', base_path('webpack.mix.js'));
    }

    /**
     * Update the Sass files for the application.
     *
     * @return void
     */
    protected static function updateSass()
    {
        (new Filesystem)->ensureDirectoryExists(resource_path('scss'));
        (new Filesystem)->ensureDirectoryExists(resource_path('scss/variables'));
        (new Filesystem)->ensureDirectoryExists(resource_path('scss/layout'));
        (new Filesystem)->ensureDirectoryExists(resource_path('scss/navigation'));
        (new Filesystem)->ensureDirectoryExists(resource_path('scss/navigation/sidenav'));

        copy(__DIR__.'/bootstrap-stubs/technobureau.scss', resource_path('scss/technobureau.scss'));
        copy(__DIR__.'/bootstrap-stubs/_variables.scss', resource_path('scss/_variables.scss'));
        copy(__DIR__.'/bootstrap-stubs/_global.scss', resource_path('scss/_global.scss'));
        copy(__DIR__.'/bootstrap-stubs/custom.scss', resource_path('scss/custom.scss'));
        copy(__DIR__.'/bootstrap-stubs/variables/_navigation.scss', resource_path('scss/variables/_navigation.scss'));
        copy(__DIR__.'/bootstrap-stubs/variables/_spacing.scss', resource_path('scss/variables/_spacing.scss'));
        copy(__DIR__.'/bootstrap-stubs/layout/_authentication.scss', resource_path('scss/layout/_authentication.scss'));
        copy(__DIR__.'/bootstrap-stubs/layout/_dashboard-default.scss', resource_path('scss/layout/_dashboard-default.scss'));
        copy(__DIR__.'/bootstrap-stubs/layout/_dashboard-fixed.scss', resource_path('scss/layout/_dashboard-fixed.scss'));
        copy(__DIR__.'/bootstrap-stubs/layout/_error.scss', resource_path('scss/layout/_error.scss'));
        copy(__DIR__.'/bootstrap-stubs/navigation/_nav.scss', resource_path('scss/navigation/_nav.scss'));
        copy(__DIR__.'/bootstrap-stubs/navigation/_topnav.scss', resource_path('scss/navigation/_topnav.scss'));
        copy(__DIR__.'/bootstrap-stubs/navigation/sidenav/_sidenav.scss', resource_path('scss/navigation/sidenav/_sidenav.scss'));
        copy(__DIR__.'/bootstrap-stubs/navigation/sidenav/_sidenav-dark.scss', resource_path('scss/navigation/sidenav/_sidenav-dark.scss'));
        
    }

    /**
     * Update the bootstrapping files.
     *
     * @return void
     */
    protected static function updateBootstrapping()
    {
        copy(__DIR__.'/bootstrap-stubs/bootstrap.js', resource_path('js/bootstrap.js'));
        copy(__DIR__.'/bootstrap-stubs/bootstrap-select.js', resource_path('js/bootstrap-select.js'));
        copy(__DIR__.'/bootstrap-stubs/technobureau.js', resource_path('js/technobureau.js'));
    }
}
