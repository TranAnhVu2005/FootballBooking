<?php

namespace App\Controllers;

class AboutUsController extends Controller
{
    public function index()
    {
        $this->sendPage('/aboutus');
    }
}
