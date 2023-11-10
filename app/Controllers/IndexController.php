<?php

namespace App\Controllers;

use App\Api;
use App\Response;



class IndexController
{
    private Api $api;

    public function __construct()
    {
        $this->api = new Api();
    }

    public function index(): Response
    {
        return new Response(
            "article\\top-articles", [
                "articles" => $this->api->fetchTopNewsDefault()
            ]
        );
    }



}