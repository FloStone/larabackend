# larabackend

##Installation

###Add packages to composer.json:

"flo5581/larahelpers" : "1.0.x-dev"<br>
"flo5581/larabackend" : "dev-master"

Add to Kernel.php in App\Console:

`'\Flo\Backend\Commands\AdminInstallation'`

Laravel 5.1:

`\Flo\Backend\Commands\AdminInstallation::class`

###Register Service Provider:

`'Flo\Backend\BackendProvider'`
`'Flo5581\Larahelpers\BladeExtensions'`
`'Maatwebsite\Excel\ExcelServiceProvider'`

Laravel 5.1:

`Flo\Backend\BackendProvider::class`
`Flo5581\Larahelpers\BladeExtensions::class`
`Maatwebsite\Excel\ExcelServiceProvider::class`

###Add Facades

`'Excel' => 'Maatwebsite\Excel\Facades\Excel'`

Laravel 5.1:

`'Excel' => Maatwebsite\Excel\Facades\Excel::class`

Execute:

`php artisan admin:install`

Make sure your admin templates extend `Backend::master`

##Usage

Before you do anything:
Create a controller that extends

`Flo\Backend\Controllers\AdminController`

and add the controller to your `routes.php` using

`Route::controller('admin', 'YourController')`

Remember to protected the controller with a middleware

First you need to tell the Backend what controller methods should be displayed in the menu
A key indicates the name isplayed in the menu, the value tells the controller method

`public static $displayed_actions = ['Index' => 'getIndex']`

To create a view that displays a model you have to use the view method
of the parent controller. Don't use the laravel view method!
just pass through the model you wish to use.

`public function getIndex()`<br>
`{`<br>
	`$this->view(Model::class);`<br>
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

To define which columns of your model should be displayed inside the table
you have to add

`public static $displayed_columns = ['email', 'name']`

to your model and put in the fields that should be displayed
To define the columns the can be edited by an admin, you need to add

`public static $editable_columns = ['email' => []]`

Additionally you should can add properties to that field like setting a label that is shown
as headline in the table

`public static $editable_columns = ['email' => ['label' => 'E-Mail']]`

Keep in mind that not having this variable or having it empty will cause an error


Add an export field by using addExport as method
Pass through the filetype as first parameter

`$this->view(Model::class)->addTable($custom_data, true)->addExport('xls')->render()`
