<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboardpemotongankurban', function () {
    return view('dashboards.pemotongan-kurban');
});

Route::get('/dashboardpemotongantercatat', function () {
    return view('dashboards.pemotongan-tercatat');
});
