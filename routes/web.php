<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Payment\PaymentController;
use App\Http\Controllers\ProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/auth/redirect', [AuthController::class, 'redirectToGoogle']);
//handle by google
Route::get('/auth/callback', [AuthController::class, 'createUserViaGoogle']);

Route::get('/success', [PaymentController::class, 'successPayment'])->name('success');

Route::get('/checkout', [PaymentController::class, 'checkOutForm']);

Route::get('/cancel', function () {
    dd('payment cancel hellloooooo !!!!');
})->name('cancel');

// Route::get('/login', function () {
//     return response()->json([
//         'message' => 'Not authenticated',
//         'status' => 401,
//     ], 404);
// })->name('login');

Route::get('/auth/redirect', [AuthController::class, 'redirectToGoogle']);
//handle by google
Route::get('/auth/callback', [AuthController::class, 'createUserViaGoogle']);
Route::get('/callback', function (Request $request) {
    $state = $request->session()->pull('state');

    $codeVerifier = $request->session()->pull('code_verifier');

    throw_unless(
        strlen($state) > 0 && $state === $request->state,
        InvalidArgumentException::class
    );

    return redirect('https://vue-budget-app.onrender.com/token?code_verifier='.$codeVerifier);
});

require __DIR__.'/auth.php';
