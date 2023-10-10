<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    /**
     * Display the home page.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {
        return view(config('app.interface').'front.index');
    }
}
