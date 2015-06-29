<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Participant;

class AdminController extends Controller
{
	public static $displayed_actions = [
		'Index'			=> 'getIndex',
		'Teilnehmer'	=> 'getParticipants'
	];

    public function getIndex()
    {
   		return view('admin.index');
    }

    public function getParticipants()
    {
   		return view('admin.participants');
    }
}
