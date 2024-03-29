<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $user;
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if(auth('api')->check()) {
                $this->user = auth('api')->user();
            }
            return $next($request);
        });

    }
}
