<?php

namespace App\Http\Controllers;

use App\Helpers\Helpers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class DashboardController extends Controller
{
    private $title = "Dashboard";

    public function index()
    {
        $data['title'] = $this->title;

        return view('index', $data);
    }
}
