# larabackend

##Installation

###Add packages to composer.json:

"flo5581/larahelpers" : "1.0.*"

Add to Kernel.php in App\Console:

`\Flo\Backend\Commands\AdminInstallation::class`

###Register Service Provider:

`Flo\Backend\BackendProvider::class`<br>
`Flo5581\Larahelpers\BladeExtensions::class`<br>
`Maatwebsite\Excel\ExcelServiceProvider::class`<br>

###Add Facades

`'Excel' => Maatwebsite\Excel\Facades\Excel::class`

Execute:

`php artisan admin:install`

This will work with Laravel 5.0.* however you need to use strings instead of ::class<br>
Example:<br>
`'\Flo\Backend\Commands\AdminInstallation'`

##Basic Usage

Before you do anything:
Create a controller that extends

`Flo\Backend\Controllers\AdminController`

and add the controller to your `routes.php` using

`Route::controller('admin', 'YourController')`

or

`controller('admin', 'YourController')`

Remember to protected the controller with a middleware but when you do that
You need to call the parent constructor as well

`public function __constrcut() {`<br>
`parent::__construct();`<br>
``$this->middleware('admin);`<br>
`}`

First you need to tell the Backend what controller methods should be displayed in the menu
A key indicates the name displayed in the menu, the value tells the controller method

`public static $displayed_actions = ['Index' => 'getIndex']`

To create a view that displays a model you have to use the view method
of the parent controller. Don't use the laravel view method!
just pass through the model you wish to use.

`public function getIndex()`<br>
`{`<br>
	`$this->view(Model::class);`<br>
`}`

To add parts to the view like a table where the content should be displayed
you need to use the addTable method

`$this->view(Model::class)->addTable()`

This will automatically print out the data of the model in the table.
Additionally you can provide a Collection of custom data to the table as the
first parameter and you can decide if the content should be editable using 
the second parameter, the default value is true

`$this->view(Model::class)->addTable($custom_data, true)`

Finally call the render method to make everything work

`$this->view(Model::class)->addTable()->render()`

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

`$this->view(Model::class)->addTable()->addExport('xls')->render()`

##Model Definitions

Here is a list of all Model definitions and what they do:

###1

`public static $display_columns = ['column' => [(options)]]`<br>
Field MUST be set!<br>
An array of all displayed columns in the backend table<br>
Options:<br>
`'label' => 'Name of Column'`<br>
`'relation' => [(properties)]`<br>
Relation Properties:<br>
`'method' => 'nameofrelationmethod'`<br>
`'display' => 'displayedfieldofrelatedobject'`

###2

`public static $editable_columns = ['column' => [(options)]]`<br>
Field MUST be set!<br>
An array of columns that should be editable<br>
Options:<br>
`'label' => 'Name of Column'`<br>
`'type' => 'Type of Field'`<br>
List of field types:<br>
`'string'`<br>
`'text'`<br>
`'textarea'`<br>
`'integer'`<br>
`'int'`<br>
`'password'`<br>
`'pass'`<br>
`'checkbox'`<br>
`'boolean'`<br>
`'select'`<br>
`'selectbox'`<br>
`'enum'`<br>
`'file'`<br>
`'image'`<br>

###3

`public static $export_fields = ['column' => [(options)]]`<br>
Field CAN be set<br>
An array of fields that should be exported, exports all columns AND relations by default<br>
Options:<br>
`'label' => 'Name of Column'`<br>
`'relation' => [(properties)]`<br>
Relation Properties:<br>
`'method' => 'nameofrelationmethod'`<br>
`'display' => 'displayedfieldofrelatedobject'`