<?php

namespace TechnoBureau\UI\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Ui\UiCommand;
use TechnoBureau\UI\Presets\UIPreset;

class UIPresetServiceProvider extends ServiceProvider
{
    
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        UiCommand::macro('technobureau', function (UiCommand $command) {
            foreach ($command->option('option') as  $value)
                $command->addOption($value);
            
            $UiPreset = new UIPreset($command);
            $UiPreset->install();

            $command->info('TechnoBureau scaffolding installed successfully.');

            if ($command->option('auth')) {
                $UiPreset->installAuth();
                $command->info('TechnoBureau CSS auth scaffolding installed successfully.');
            }

            $command->comment('Please run "npm install && npm run prod" to compile your fresh scaffolding.');
        });
    }
}
