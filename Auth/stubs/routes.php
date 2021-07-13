

Route::get('/home', 'HomeController@index')->name('home');
Route::group(['middleware' => ['auth']], function() {
    Route::resource('users', UserController::class);
    Route::resource('groups', GroupController::class);
    Route::resource('permissions', PermissionController::class);
});
