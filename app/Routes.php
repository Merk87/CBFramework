<?php

use Merkury\Url\Route;

Route::get('/', 'CoolBlueTest\Controllers\IndexController', 'indexAction');
Route::get('/address/{id}', 'CoolBlueTest\Controllers\IndexController', 'getAddressAction');
Route::get('/add-address', 'CoolBlueTest\Controllers\IndexController', 'addAddressAction');
Route::post('/add-address', 'CoolBlueTest\Controllers\IndexController', 'addAddressAction');
Route::get('/edit-address/{id}', 'CoolBlueTest\Controllers\IndexController', 'editAddressAction');
Route::post('/edit-address/{id}', 'CoolBlueTest\Controllers\IndexController', 'editAddressAction');
Route::get('/remove-address/{id}', 'CoolBlueTest\Controllers\IndexController', 'removeAddressAction');


