# larabackend

##Installation

Add package to composer.json:

"flo5581/larabackend" : "dev-master"

Add to Kernel.php in App\Console:

`'\Flo\Backend\Commands\AdminInstallation'`

Laravel 5.1:

`\Flo\Backend\Commands\AdminInstallation::class`

Register Service Provider:

`'Flo\Backend\BackendProvider'`

Laravel 5.1:

`Flo\Backend\BackendProvider::class`

Execute:

`php artisan admin:install`

Make sure your admin templates extend `admin.master`
