<?php

namespace Flo\Backend;

use Illuminate\Support\ServiceProvider;

class BackendProvider extends ServiceProvider
{
	public function boot()
	{
		$this->loadViewsFrom(__DIR__.'/Views', 'Backend');

		$this->publishes([
			__DIR__.'/Views/css' => public_path('/css'),
			__DIR__.'/Views/js' => public_path('/js'),
			__DIR__.'/Config'	=> base_path('config')
		]);
	}

	public function register()
	{

	}
}