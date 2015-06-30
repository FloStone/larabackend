<?php

namespace Flo\Backend;

use Illuminate\Support\ServiceProvider;

class BackendProvider extends ServiceProvider
{
	public function boot()
	{
		$this->loadViewsFrom(__DIR__.'/Views', 'Backend');

		$this->publishes([
			__DIR__.'/Views' => base_path('resources/views/admin'),
			__DIR__.'/Views/css' => public_path('/css')
		]);
	}

	public function register()
	{
		
	}
}