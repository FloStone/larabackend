<?php

namespace Flo\Backend\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;

class AdminController extends BaseController
{
  use DispatchesJobs, ValidatesRequests;
  
	public static $displayed_actions = [];

    public function getIndex()
    {
   		return view('admin.index');
    }

    public function getParticipants()
    {
   		return view('admin.participants');
    }
}
