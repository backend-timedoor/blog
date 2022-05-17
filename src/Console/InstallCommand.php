<?php

namespace Timedoor\Blog\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'blog:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install Blog';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $modules = [
            'model'      => 1,
            'controller' => [
                'Blog' => 'Http/Controllers/Blog',
                'Api'  => 'Http/Controllers/Api'
            ],
            'request'    => 1,
            'filter'     => 1,
            'middleware' => 1,
            'resource'   => 1,
            'util'       => 1,
            'helper'     => 1,
            'database'   => ['factories', 'seeders'],
            'route'      => ['blog-admin', 'blog-api'],
            'asset'      => ['blog', 'stisla', 'vendor'],
            'view'       => ['admin-blog'],
        ];

        foreach ($modules as $module => $params) {
            $bar = $this->output->createProgressBar(is_array($params) ? count($params) : 1);
            $bar->start();

            $this->{$module . 'Export'}($bar, $params);
            $this->info("Export {$module}s...");

            $bar->finish();
        }

         $this->newLine();
        $this->info('Membership installed successfully.');
        // $this->comment('Please execute the "npm install && npm run dev" command to build your assets.');
    }

    private function modelExport($bar)
    {
        (new Filesystem)->ensureDirectoryExists(app_path('Models'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/app/Models', app_path('Models'));
        $bar->advance();
    }


    private function controllerExport($bar, $controllers)
    {
        foreach ($controllers as $controller => $path) {
            usleep(200000);
            (new Filesystem)->ensureDirectoryExists(app_path($path));

            $dir = __DIR__.'/../../stubs/app/Controllers/';
            (new Filesystem)->copyDirectory($dir . $controller, app_path($path));
            $bar->advance();
        }
    }

    private function requestExport($bar)
    {
        (new Filesystem)->ensureDirectoryExists(app_path('Http/Requests'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/app/Requests', app_path('Http/Requests'));
        $bar->advance();
    }

    private function filterExport($bar)
    {
        (new Filesystem)->ensureDirectoryExists(app_path('Http/Filter'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/app/Filter', app_path('Http/Filter'));
        $bar->advance();
    }

    private function middlewareExport($bar)
    {
        (new Filesystem)->ensureDirectoryExists(app_path('Http/Middleware'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/app/Middleware', app_path('Http/Middleware'));
        $bar->advance();
    }

    private function resourceExport($bar)
    {
        (new Filesystem)->ensureDirectoryExists(app_path('Http/Resources'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/app/Resources', app_path('Http/Resources'));
        $bar->advance();
    }

    private function utilExport($bar)
    {
        (new Filesystem)->ensureDirectoryExists(app_path('Util'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/app/Util', app_path('Util'));
        $bar->advance();
    }

    private function helperExport($bar)
    {
        (new Filesystem)->ensureDirectoryExists(app_path('Helpers'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/app/Helpers', app_path('Helpers'));
        $bar->advance();
    }

    private function databaseExport($bar, array $databases)
    {
        foreach ($databases as $database) {
            usleep(200000);
            (new Filesystem)->ensureDirectoryExists(database_path($database));
            (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/database/' . $database, database_path($database));
            $bar->advance();
        }
    }
    
    private function routeExport($bar, $routes)
    {
        foreach ($routes as $route) {
            usleep(200000);
            copy(__DIR__.'/../../stubs/routes/' . $route . '.php', base_path('routes/' . $route . '.php'));
            $bar->advance();
        }
    }

    private function assetExport($bar, array $assets)
    {
        foreach ($assets as $asset) {
            usleep(200000);
            (new Filesystem)->ensureDirectoryExists(public_path($asset));
            (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/public/' . $asset, public_path($asset));
            $bar->advance();
        }
    }

    private function viewExport($bar, array $views)
    {
        foreach ($views as $view) {
            usleep(200000);
            (new Filesystem)->ensureDirectoryExists(resource_path('views/' . $view));
            (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/resources/views/' . $view, resource_path('views/' . $view));
            $bar->advance();
        }
    }
}