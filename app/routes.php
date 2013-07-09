<?php

Route::controller('account','WBDB\Controllers\AccountController' );

// Fun fact!  You can't typecast ID as an integer, it won't get matched properly.
// You can enforce typecast other variables as integer (:num), though.
Route::get('boat/{id}',         'WBDB\Controllers\Boat@getBoat')->where('id', '[0-9]+');
Route::get('boat/add',          'WBDB\Controllers\Boat@addBoat');
Route::get('boat/edit/{id}',   'WBDB\Controllers\Boat@editBoat')->where('id', '[0-9]+');
Route::get('boat/delete/{id}',   'WBDB\Controllers\Boat@deleteBoat')->where('id', '[0-9]+');
Route::controller('boat',       'WBDB\Controllers\Boat');

Route::get('designer/{id}',     'WBDB\Controllers\Designer@getDesigner')->where('id', '[0-9]+');
Route::get('designer/add',      'WBDB\Controllers\Designer@addDesigner');
Route::get('designer/delete/{id}',   'WBDB\Controllers\Designer@deleteDesigner')->where('id', '[0-9]+');
Route::controller('designer',   'WBDB\Controllers\Designer');

// Our default route
Route::any('/', 'WBDB\Controllers\Boat@getIndex');
