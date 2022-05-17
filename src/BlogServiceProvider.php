<?php

namespace Timedoor\Blog;

use Illuminate\Support\ServiceProvider;
use Timedoor\Blog\Console\InstallCommand;

class BlogServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/config/laravellocalization.php' => config_path('laravellocalization.php'),
            __DIR__ . '/config/lfm.php' => config_path('lfm.php'),
            __DIR__ . '/config/translatable.php' => config_path('translatable.php'),
            __DIR__ . '/database/migrations/2021_12_22_073333_create_blog_categories_table.php' => database_path('migrations/' . date('Y_m_d_His', time()) . '01_create_blog_categories_table.php'),
            __DIR__ . '/database/migrations/2021_12_22_073334_create_blog_category_translations_table.php' => database_path('migrations/' . date('Y_m_d_His', time()) . '02_create_blog_category_translations_table.php'),
            __DIR__ . '/database/migrations/2021_12_22_073335_create_blog_tags_table.php' => database_path('migrations/' . date('Y_m_d_His', time()) . '03_create_blog_tags_table.php'),
            __DIR__ . '/database/migrations/2021_12_22_073336_create_blog_tag_translations_table.php' => database_path('migrations/' . date('Y_m_d_His', time()) . '04_create_blog_tag_translations_table.php'),
            __DIR__ . '/database/migrations/2021_12_22_073352_create_blogs_table.php' => database_path('migrations/' . date('Y_m_d_His', time()) . '05_create_blogs_table.php'),
            __DIR__ . '/database/migrations/2021_12_22_073423_create_blog_translations_table.php' => database_path('migrations/' . date('Y_m_d_His', time()) . '06_create_blog_translations_table.php'),
            __DIR__ . '/database/migrations/2021_12_22_081139_pivot_blogs_tags_table.php' => database_path('migrations/' . date('Y_m_d_His', time()) . '07_pivot_blogs_tags_table.php'),
            __DIR__ . '/database/migrations/2022_01_28_012317_create_multilanguage_settings_table.php' => database_path('migrations/' . date('Y_m_d_His', time()) . '08_create_multilanguage_settings_table.php'),
            __DIR__ . '/database/migrations/2022_01_28_013640_create_multilanguage_setting_details_table.php' => database_path('migrations/' . date('Y_m_d_His', time()) . '09_create_multilanguage_setting_details_table.php'),
            __DIR__ . '/database/migrations/2022_01_28_064622_create_blog_images_table.php' => database_path('migrations/' . date('Y_m_d_His', time()) . '10_create_blog_images_table.php'),
            __DIR__ . '/database/migrations/2022_05_11_025040_create_blog_featureds_table.php' => database_path('migrations/' . date('Y_m_d_His', time()) . '11_create_blog_featureds_table.php'),
        ], 'blog');

        $this->commands([
            InstallCommand::class
        ]);
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register(): void
    {
        // $this->mergeConfigFrom(__DIR__.'/config/blog.php', 'blog');
    }
}
