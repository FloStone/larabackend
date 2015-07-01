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

Make sure your admin templates extend `Backend::master`

##Usage

Before you do anything:
Create a controller that extends

`Flo\Backend\Controllers\AdminController`

and add the controller to your `routes.php` using `admin` as URI

`Route::controller('admin', 'YourController')`

Remember to protected the controller with a middleware

First you need to tell the Backend what controller methods should be displayed in the menu
A key indicates the name isplayed in the menu, the value tells the controller method
`public static $displayed_actions = ['Index' => 'getIndex']`

To create a view that displays a model you have to use the view method
of the parent controller. Don't use the laravel view method!
just pass through the model you wish to use.
`public function getIndex()`
`{`
	`$this->view(Model::class);`
`}`
Remember that in Laravel 5.1 you can use `::class` to indicate the class you want
to pass through. You can also use a string if you wish

`$this->view('App\Models\MyModel')`

To add parts to the view like a table where the content should be displayed
you need to use the addTable method

`$this->view(Model::class)->addTable()`

This will automatically print out the data of the model in the table.
Additionally you can provide a Collection of custom data to the table as the
first parameter and you can decide if the content should be editable using 
the second parameter, the default value is true

`$this->view(Model::class)->addTable($custom_data, true)`

Finally call the render method to make everything work

`$this->view(Model::class)->addTable($custom_data, true)->render()`

