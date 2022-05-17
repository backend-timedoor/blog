# Query Filter 

## Installation

```
$ composer require timedoor/blog
```

## Setup
#### 1. Install asset
```
$ php artisan blog:install
$ php artisan vendor:publish --tag=blog
$ php artisan storage:link
```
#### 2. Setup env
```
APP_URL={your_project_domain} 

// example: http://timedoor-blog.test
```
#### 3. Setup config and composer json

Add this code inside filesystems config
```
// app/config/filesystems.php

'disks' => [
	...
	'public_upload' => [
		'driver' => 'local',
		'root' => public_path() . '/upload',
		'url' => '/upload'
	]
]
```
Add this code inside composer json
```
// composer.json
"autoload-dev": {
	...
	"files": [
		"app/Helpers/blog.php"
	]
},
```
After that don't forget to reload autoload
```
$ composer dump-autoload
```
#### 4. Setup database
```
$ php artisan migrate
$ php artisan db:seed --class=MultilanguageSettingTableSeeder
```
#### 5. Finishing setup
You need to register localize middleware inside your kernel
```
// app/Http/Kernel.php

protected $routeMiddleware = [
	...
	'localize.api' => \App\Http\Middleware\LocalizeApiRequest::class,
	'localize' => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRoutes::class,
	'localizationRedirect' => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRedirectFilter::class,
	'localeSessionRedirect' => \Mcamara\LaravelLocalization\Middleware\LocaleSessionRedirect::class,
	'localeCookieRedirect' => \Mcamara\LaravelLocalization\Middleware\LocaleCookieRedirect::class,
	'localeViewPath' => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationViewPath::class,
]
```
After that you need to add some code in AppServiceProvider inside boot method
```
// app/Providers/AppServiceProvider.php

use Illuminate\Support\Facades\Config;

public function boot()
{
	...
	$multilanguages  =  getMultilanguageSetting();
	
	Config::set('translatable.locales', $multilanguages->pluck('locale')->toArray());
	Config::set('laravellocalization.supportedLocales', $multilanguages->pluck('detail', 'locale')->toArray());
}
```
Last thing you need to register route inside RouteServiceProvider
```
Route::prefix('api/v1')
	->middleware(['api', 'localize.api'])
	->namespace($this->namespace)
	->group(base_path('routes/blog-api.php'));

Route::prefix('admin-blog')
	->name('admin-blog.')
	->middleware('web')
	->namespace($this->namespace)
	->group(base_path('routes/blog-admin.php'));
``` 
All is set, now you can use the package, here is the url of blog admin and blog api
```
{your_domain}/admin-blog/blogs
{your_domain}/api/v1
```

## Thank you