<?php

namespace TechnoBureau\UI\Presets;

use Illuminate\Filesystem\Filesystem;
use Laravel\Ui\Presets\Preset;
use Illuminate\Console\Command;
use Symfony\Component\Finder\SplFileInfo;

class UIPreset extends Preset
{
        

    protected $command;
    protected $option;

    public function __construct(Command $command)
    {
        $this->command = $command;
        $this->option = $this->command->options();
    }
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
            '@popperjs/core' => '^2.9.2',
            'sass' => '^1.32.11',
            'resolve-url-loader' => '^4.0.0',
            'sass-loader' => '^11.0.1',
            'bootstrap-select' => '^1.14.0-beta2',
            'tb-admin' => '^1.0.0',
            'webpack' => '5.45.1', //5.45.0 have bug with js query token error
        ] + $packages;
    }

    /**
     * Update the Webpack configuration.
     *
     * @return void
     */
    protected static function updateWebpackConfiguration()
    {
        copy(__DIR__.'/../../bootstrap-stubs/webpack.mix.js', base_path('webpack.mix.js'));
    }

    /**
     * Update the Sass files for the application.
     *
     * @return void
     */
    protected static function updateSass()
    {
        (new Filesystem)->ensureDirectoryExists(resource_path('scss'));        

        copy(__DIR__.'/../../bootstrap-stubs/technobureau.scss', resource_path('scss/technobureau.scss'));
        
    }

    /**
     * Update the bootstrapping files.
     *
     * @return void
     */
    protected static function updateBootstrapping()
    {
        copy(__DIR__.'/../../bootstrap-stubs/bootstrap.js', resource_path('js/bootstrap.js'));
        copy(__DIR__.'/../../bootstrap-stubs/bootstrap-select.js', resource_path('js/bootstrap-select.js'));
        copy(__DIR__.'/../../bootstrap-stubs/technobureau.js', resource_path('js/technobureau.js'));
    }
    public function installAuth()
    {

        $this->ensureDirectoriesExist();
        $this->exportViews();

        if ( ! isset($this->option['views']) ) {
            $this->exportBackend();
        }
        
    }
    /**
     * Export the authentication views.
     *
     * @return void
     */
    protected function exportViews()
    {
        $filesystem = new Filesystem();
        collect($filesystem->allFiles(__DIR__.'/../../Auth/bootstrap-stubs'))
            ->each(function (SplFileInfo $file) use ($filesystem) {
                //if($file->getrelativePath()!='') //Avoid skipping welcome blade overwritten.
                    $filesystem->copy(
                        $file->getPathname(),
                        base_path('resources/views/'.$file->getrelativePathname())
                    );
            });
    }

    protected function exportBackend()
    {
        
        file_put_contents(
            base_path('routes/web.php'),
            file_get_contents(__DIR__.'/../../Auth/stubs/routes.php'),
            FILE_APPEND
        );

        (new Filesystem)->ensureDirectoryExists(app_path('Models'));

        copy(__DIR__.'/../../Auth/stubs/User.php', app_path('Models/User.php'));

        $filesystem = new Filesystem();

        collect($filesystem->allFiles(__DIR__.'/../../database'))
            ->each(function (SplFileInfo $file) use ($filesystem) {
                if($file->getrelativePath()!='')
                    $filesystem->copy(
                        $file->getPathname(),
                        base_path('database/'.$file->getrelativePathname())
                    );
            });
    }

    /**
     * Compiles the "HomeController" stub.
     *
     * @return string
     */
    protected function compileControllerStub($file)
    {
        return str_replace(
            '{{namespace}}',
            $this->command->laravel->getNamespace(),
            file_get_contents(__DIR__.'/../../Auth/stubs/'.$file)
        );
    }

    /**
     * Get full view path relative to the application's configured view path.
     *
     * @param  string  $path
     * @return string
    */
    protected function getViewPath($path)
    {
        return implode(DIRECTORY_SEPARATOR, [
            config('view.paths')[0] ?? resource_path('views'), $path,
        ]);
    }

        /**
     * Create the directories for the files.
     *
     * @return void
     */
    protected function ensureDirectoriesExist()
    {
        if (! is_dir($directory = $this->getViewPath('layouts'))) {
            mkdir($directory, 0755, true);
        }

        if (! is_dir($directory = $this->getViewPath('includes'))) {
            mkdir($directory, 0755, true);
        }
    }


    
}
