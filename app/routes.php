<?php

Route::controller('account','AccountController' );

// Fun fact!  You can't typecast ID as an integer, it won't get matched properly.
// You can enforce typecast other variables as integer (:num), though.


Route::get('boat/{id}',         'WBDB\Controller\Boat@getBoat')->where('id', '[0-9]+');
Route::get('boat/add',          'WBDB\Controller\Boat@addBoat');
Route::get('boat/delete/{id}',   'WBDB\Controller\Boat@deleteBoat')->where('id', '[0-9]+');
Route::controller('boat',       'WBDB\Controller\Boat');

Route::get('designer/{id}',     'WBDB\Controller\Designer@getDesigner')->where('id', '[0-9]+');
Route::get('designer/add',      'WBDB\Controller\Designer@addDesigner');
Route::get('designer/delete/{id}',   'WBDB\Controller\Designer@deleteDesigner')->where('id', '[0-9]+');
Route::controller('designer',   'WBDB\Controller\Designer');

// Our default route
Route::any('/', 'WBDB\Controller\Boat@getIndex');
