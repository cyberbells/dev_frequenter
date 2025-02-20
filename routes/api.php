<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\CustomerController;
use App\Http\Controllers\API\BusinessController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\TransactionController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\RewardController;
use App\Http\Controllers\API\CustomerProfileController;
// use App\Http\Controllers\CityController;
use App\Http\Controllers\CheckInController;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Admin\CityController;

// Public Routes
Route::middleware(['api', EnsureFrontendRequestsAreStateful::class])->group(function () {
    Route::post('/register/customer', [AuthController::class, 'registerCustomer']);
    Route::post('/register/business', [AuthController::class, 'registerBusiness']);
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLink']);
    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');

    // Get all cities
    Route::get('/cities', [CityController::class, 'getCityDetails']);

    // Get unique states
    Route::get('/states', [CityController::class, 'getStates']);

    // Get unique countries
    Route::get('/countries', [CityController::class, 'getCountries']);

    // Get cities by state or country (Optional for dependent dropdowns)
    Route::get('/cities/filter', [CityController::class, 'getCitiesByStateOrCountry']);
});
// Route::post('/reset-password', [ResetPasswordController::class, 'reset']);

// Route::middleware(['auth:api'])->group(function () {
//     Route::put('/customer/profile', [CustomerProfileController::class, 'updateProfile']);
// });

// Customer API's
Route::middleware(['auth:api'])->prefix('customer')->group(function () {
    //API User profile Update
    Route::post('/profile', [CustomerProfileController::class, 'updateProfile']);
    //API Change User Status
    Route::put('/update-status/{user_id}', [CustomerProfileController::class, 'updateStatus']);
    //API Change Password
    Route::post('/change-password', [AuthController::class, 'changePassword']);
    //API Update Push Notifications
    Route::put('/push-notifications', [CustomerProfileController::class, 'pushNotificationUpdate']);
    //API Update Location
    Route::put('/location', [CustomerProfileController::class, 'updateLocation']);
    //API Update Language
    Route::put('/language-update', [CustomerProfileController::class, 'updateCustomerLanguage']);
});


// Protected Routes (Require Authentication)
Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::get('/customer/dashboard', [CustomerController::class, 'dashboard']);
    Route::get('/protected', function (Request $request) {
        return response()->json(['message' => 'You are authenticated!', 'user' => $request->user()]);
    });
});

// Resource Routes (Public/General APIs)
Route::apiResource('customers', CustomerController::class);
Route::apiResource('users', UserController::class);
Route::apiResource('businesses', BusinessController::class);
Route::apiResource('transactions', TransactionController::class);

// Additional Utility Routes
// Route::get('/cities-by-zip/{zip}', [CityController::class, 'getCitiesByZip']);

// QR code generation
Route::post('/checkin/customer', [CheckInController::class, 'customerCheckIn']);
Route::post('/checkin/business', [CheckInController::class, 'businessCheckIn']);
Route::post('/checkin/text-code', [CheckInController::class, 'checkInWithTextCode']);

// Generate Customer QR Code
Route::get('/customer/qr-code', [CustomerController::class, 'generateEncryptedQrCode'])
    ->middleware('auth'); // Only logged-in customers can access

// Generate Business QR Code
Route::get('/business/qr-code', [BusinessController::class, 'generateBusinessQrCode'])
    ->middleware('auth'); // Only logged-in business admins can access

// Group QR code generation endpoints under /api/generate-qr
Route::prefix('generate-qr')->middleware('auth:sanctum')->group(function () {
    Route::get('/customer', [CustomerController::class, 'generateEncryptedQrCodeApi'])
        ->name('api.qr.customer');
    Route::get('/business', [BusinessController::class, 'generateBusinessQrCodeApi'])
        ->name('api.qr.business');
});

// Grant reward points to businesses manually or automatically
Route::post('/business/{businessId}/grant-checkin-points', [BusinessController::class, 'grantCheckinPoints'])
    ->middleware('auth:sanctum')
    ->name('api.business.grantCheckinPoints');

// for businesses to add rewards
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/business/rewards', [BusinessController::class, 'storeRewardApi'])->name('api.business.storeReward');
});

// for businesses to view reward point summary
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/business/points-summary', [BusinessController::class, 'pointsSummaryApi'])->name('api.business.pointsSummary');
});

// for business to modify points per check-in
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/business/checkin-points', [BusinessController::class, 'updateCheckinPointsApi'])->name('api.business.updateCheckinPoints');
    Route::get('/business/checkin-points', [BusinessController::class, 'getCheckinPointsApi'])->name('api.business.getCheckinPoints');
});

// for check-in
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/business/checkin', [CheckinController::class, 'checkIn'])->name('api.business.checkin');
});

// Redeem reward
Route::middleware('auth:sanctum')->get('/rewards/{reward_id}/redeem-qr', [RewardController::class, 'generateRedemptionQrCode'])->name('api.rewards.generateQr');

// Generate QR code for redeeming a reward
Route::middleware('auth:sanctum')->post('/rewards/generate-qr', [RewardController::class, 'generateRedemptionQrCodeApi'])->name('api.rewards.generateQr');

// Get information for Customer Dashboard on customer_app
Route::middleware(['auth:sanctum'])->get('/customer/api-dashboard', [CustomerController::class, 'apiDashboard']);
