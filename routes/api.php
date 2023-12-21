<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\VerifyEmailController;
use Illuminate\Support\Facades\Password;
use App\Http\Controllers\IncidentController;



/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::controller(AuthController::class)->group(function () {
    // USER 

    Route::post('/login', 'login');
    Route::post('/register','register');

    // ADMIN AUTH
    Route::post('/admin-login', 'adminLogin');
    Route::post('/admin-register','adminRegister');
});

Route::post('/reset-pass', [ResetPasswordController::class, 'request_reset']);
Route::post('/reset-code', [ResetPasswordController::class, 'find_code']);
Route::post('/reset-submit', [ResetPasswordController::class, 'submit_reset']);




// Verify email
Route::get('/email/verify/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
    ->middleware(['signed', 'throttle:6,1'])
    ->name('verification.verify');

// Resend link to verify email
Route::get('/email/verify/resend', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return ['message'=> 'Verification link sent!'];
})->middleware(['auth:sanctum', 'throttle:6,1'])->name('verification.send');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    $user =  $request->user();
    $user->info = json_decode($user->info);
    return $user;
});
// TBD USER MIDDLEWARE
Route::group(['middleware' => ['auth:sanctum']], function(){
    Route::get('/logout',[AuthController::class, 'logout']);
    Route::post('/update-user',[AuthController::class, 'updateUser']);
    Route::post('/report-incident',[IncidentController::class, 'create']);
    Route::get('/my-incidents',[IncidentController::class, 'my_report_incident']);
});
// TBD ADMIN MIDDLEWARE
Route::group(['middleware' => ['auth:sanctum']], function(){
   
    Route::get('/reported-incidents',[IncidentController::class, 'reportedIncidents']);
    Route::post('/incident-update-status',[IncidentController::class, 'updateStatus']);
    Route::post('/incident-delete',[IncidentController::class, 'deleteIncidenet']);


});
