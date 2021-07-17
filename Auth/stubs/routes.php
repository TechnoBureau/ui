
Route::get('/home', [TechnoBureau\UI\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => ['auth']], function() {
    Route::resource('users', TechnoBureau\UI\Http\Controllers\UserController::class);
    Route::resource('groups', TechnoBureau\UI\Http\Controllers\GroupController::class);
    Route::resource('permissions', TechnoBureau\UI\Http\Controllers\PermissionController::class);
});
