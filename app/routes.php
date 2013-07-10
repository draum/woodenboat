<?php

Route::controller('account', 'WBDB\Controllers\AccountController');

// Fun fact!  You can't typecast ID as an integer, it won't get matched properly.
// You can enforce typecast other variables as integer (:num), though.
Route::get('boat/{id}', 'WBDB\Controllers\BoatController@getBoat')->where('id', '[0-9]+');
Route::get('boat/add', 'WBDB\Controllers\BoatController@addBoat');
Route::get('boat/edit/{id}', 'WBDB\Controllers\BoatController@editBoat')->where('id', '[0-9]+');
Route::get('boat/delete/{id}', 'WBDB\Controllers\BoatController@deleteBoat')->where('id', '[0-9]+');
Route::controller('boat', 'WBDB\Controllers\BoatController');

Route::get('designer/{id}', 'WBDB\Controllers\DesignerController@getDesigner')->where('id', '[0-9]+');
Route::get('designer/add', 'WBDB\Controllers\DesignerController@addDesigner');
Route::get('designer/delete/{id}', 'WBDB\Controllers\DesignerController@deleteDesigner')->where('id', '[0-9]+');
Route::controller('designer', 'WBDB\Controllers\DesignerController');

// Our default route
Route::any('/', 'WBDB\Controllers\BoatController@getIndex');
