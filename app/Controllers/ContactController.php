<?php

namespace App\Controllers;

class ContactController extends Controller
{
    public function index()
    {
        $this->sendPage('/contact');
    }
}