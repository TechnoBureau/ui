<?php

namespace TechnoBureau\UIPreset;

use Illuminate\Filesystem\Filesystem;
use Laravel\Ui\Presets\Preset;
use Illuminate\Console\Command;

class UIPreset extends Preset
{
    /**
     * The views that need to be exported.
     *
     * @var array
     */
    protected $views = [
        'home.blade.php' => 'home.blade.php',
        'welcome.blade.php' => 'welcome.blade.php',
        'conf-management.blade.php' => 'conf-management.blade.php',
        'layouts/app.blade.php' => 'layouts/app.blade.php',
        'includes/auth.blade.php' => 'includes/auth.blade.php',
        'includes/config-nav.blade.php' => 'includes/config-nav.blade.php',
        'includes/confirmation-modal.blade.php' => 'includes/confirmation-modal.blade.php',
        'includes/container.blade.php' => 'includes/container.blade.php',
        'includes/footer.blade.php' => 'includes/footer.blade.php',
        'includes/footer-scripts.blade.php' => 'includes/footer-scripts.blade.php',
        'includes/header.blade.php' => 'includes/header.blade.php',
        'includes/left_nav.blade.php' => 'includes/left_nav.blade.php',
        'includes/marketing-container.blade.php' => 'includes/marketing-container.blade.php',
        'includes/message.blade.php' => 'includes/message.blade.php',
        'includes/nav.blade.php' => 'includes/nav.blade.php',
        'includes/search.blade.php' => 'includes/search.blade.php',
        'includes/sw.blade.php' => 'includes/sw.blade.php',        
    ];
    protected $controllers = [];
    protected $migrations = [];

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
        ] + $packages;
    }

    /**
     * Update the Webpack configuration.
     *
     * @return void
     */
    protected static function updateWebpackConfiguration()
    {
        copy(__DIR__.'/../bootstrap-stubs/webpack.mix.js', base_path('webpack.mix.js'));
    }

    /**
     * Update the Sass files for the application.
     *
     * @return void
     */
    protected static function updateSass()
    {
        (new Filesystem)->ensureDirectoryExists(resource_path('scss'));        

        copy(__DIR__.'/../bootstrap-stubs/technobureau.scss', resource_path('scss/technobureau.scss'));
        
    }

    /**
     * Update the bootstrapping files.
     *
     * @return void
     */
    protected static function updateBootstrapping()
    {
        copy(__DIR__.'/../bootstrap-stubs/bootstrap.js', resource_path('js/bootstrap.js'));
        copy(__DIR__.'/../bootstrap-stubs/bootstrap-select.js', resource_path('js/bootstrap-select.js'));
        copy(__DIR__.'/../bootstrap-stubs/technobureau.js', resource_path('js/technobureau.js'));
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
        foreach ($this->views as $key => $value) {
            if (file_exists($view = $this->getViewPath($value)) && ! isset($this->option['force']) ) {
                if (! $this->command->confirm("The [{$value}] view already exists. Do you want to replace it?")) {
                    continue;
                }
            }

            copy(
                __DIR__.'/../Auth/bootstrap-stubs/'.$key,
                $view
            );
        }
    }

    protected function exportBackend()
    {
        
        foreach ($this->controllers as $value) {
            if (file_exists($controller = app_path($value)) && ! isset($this->option['force']) ) {
                if (! $this->command->confirm("The [{$value}] view already exists. Do you want to replace it?")) {
                    continue;
                }
            }
            
            file_put_contents($controller, $this->compileControllerStub($value));
        }

        file_put_contents(
            base_path('routes/web.php'),
            file_get_contents(__DIR__.'/../Auth/stubs/routes.php'),
            FILE_APPEND
        );

        foreach ($this->migrations as $value) {
            if (file_exists($migration = base_path($value)) && ! isset($this->option['force']) ) {
                if (! $this->command->confirm("The [{$value}] view already exists. Do you want to replace it?")) {
                    continue;
                }
            }

            copy(
                __DIR__.'/../Auth/stubs/migrations/'.$value,
                $migration
            );
        }
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
            file_get_contents(__DIR__.'/../Auth/stubs/'.$file)
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
