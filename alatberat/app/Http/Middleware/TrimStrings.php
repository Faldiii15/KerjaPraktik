<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\TrimStrings as Middleware;

class TrimStrings extends Middleware
{
    /**
     * Nama atribut yang tidak akan di-trim.
     *
     * @var array<int, string>
     */
    protected $except = [
        //
    ];
}