use App\Http\Controllers\CoachController;
Route::get('/coaches', [CoachController::class, 'index']);
Route::post('/coaches', [CoachController::class, 'store']);
Route::patch('/coaches/{id}', [CoachController::class, 'update']);
Route::delete('/coaches/{id}', [CoachController::class, 'destroy']);
