<?php

namespace App\Http\Controllers;

use App\Events\DashboardEvent;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $event = new DashboardEvent();
        event($event);

        return view('dashboard', compact('event'));
    }
}
