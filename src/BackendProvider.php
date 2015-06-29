<?php

namespace Flo\Backend;

use Illuminate\Support\ServiceProvider;

class BackendProvider extends ServiceProvider
{
	public function boot()
	{
		$this->loadViewsFrom(__DIR__.'/flo5581/larabackend/Views', 'Backend');

		$this->publishes([
			__DIR__.'/Views' => base_path('resources/views/admin')
		]);
	}

	public function register()
	{
		
	}
}