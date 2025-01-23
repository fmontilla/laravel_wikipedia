<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CompanyController;

Route::post('/filter-companies', CompanyController::class);
