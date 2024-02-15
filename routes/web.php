<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AnnouncementsController;
use App\Http\Controllers\AreaServantController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\AvatarController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\ChapterServantController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CouplesController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HandmaidsController;
use App\Http\Controllers\HouseholdServantController;
use App\Http\Controllers\KidsController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PermissionsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\ServantsController;
use App\Http\Controllers\SinglesController;
use App\Http\Controllers\TithesController;
use App\Http\Controllers\UnitServantController;
use App\Http\Controllers\WebhookController;
use App\Http\Controllers\YouthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
 */

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('activity.list');
    }
    return view('auth.login');
});

Route::redirect('/login', '/');

Auth::routes([
    'verify' => true,
]);

Route::get('/register', [RegisteredUserController::class, 'create'])
    ->middleware('guest')
    ->name('register');

Route::post('/register', [RegisteredUserController::class, 'store'])
    ->middleware('guest');

Route::get('/verify-email-message', function (Request $request) {
    return view('auth.verify-email');
})->middleware('guest')->name('verify');

Route::post('password', [PasswordController::class, 'update'])->middleware('guest')->name('password.update');

Route::middleware(['auth', 'verified', 'web'])->group(function () {
    // Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/dashboard/{id}', [DashboardController::class, 'bio'])->name('dashboard.bio');

    Route::resource('/announcements', AnnouncementsController::class);

    Route::resource('/kids', KidsController::class);
    Route::post('/kids/update{kid}', [KidsController::class, 'updatePassword'])->name('kids.updatePassword');
    Route::delete('/kids/delete', [KidsController::class, 'destroy'])->name('kids.delete');

    Route::resource('/youth', YouthController::class);
    Route::post('/youth/update{youth}', [YouthController::class, 'updatePassword'])->name('youth.updatePassword');
    Route::delete('/youth/delete', [YouthController::class, 'destroy'])->name('youth.delete');

    Route::resource('/singles', SinglesController::class);
    Route::post('/singles/update{single}', [SinglesController::class, 'updatePassword'])->name('singles.updatePassword');
    Route::delete('/singles/delete', [SinglesController::class, 'destroy'])->name('singles.delete');

    Route::resource('/servants', ServantsController::class);
    Route::post('/servants/update{servant}', [ServantsController::class, 'updatePassword'])->name('servants.updatePassword');
    Route::delete('/servants/delete', [ServantsController::class, 'destroy'])->name('servants.delete');

    Route::resource('/handmaids', HandmaidsController::class);
    Route::post('/handmaids/update{handmaid}', [HandmaidsController::class, 'updatePassword'])->name('handmaids.updatePassword');
    Route::delete('/handmaids/delete', [HandmaidsController::class, 'destroy'])->name('handmaids.delete');

    Route::resource('/couples', CouplesController::class);
    Route::post('/couples/update{couple}', [CouplesController::class, 'updatePassword'])->name('couples.updatePassword');
    Route::delete('/couples/delete', [CouplesController::class, 'destroy'])->name('couples.delete');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/{user}', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/update-password/{user}', [ProfileController::class, 'updatePassword'])->name('profile.updatePassword');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/profile/show/{id}', [ProfileController::class, 'show'])->name('profile.show');
    Route::group(['middleware' => 'web'], function () {
        Route::get('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
    });

    Route::post('calendar', [CalendarController::class, 'store'])->name('calendar.store');
    Route::put('calendar/{id}', [CalendarController::class, 'update'])->name('calendar.update');
    Route::put('calendar/drag/{id}', [CalendarController::class, 'dragEvent'])->name('calendar.dragEvent');
    Route::delete('calendar/destroy/{id}', [CalendarController::class, 'destroy'])->name('calendar.delete');
    Route::get('calendar/show/{id}', [CalendarController::class, 'show'])->name('calendar.show');
    Route::post('registration', [CalendarController::class, 'registration'])->name('calendar.registration');
    Route::get('attendees/{id}', [CalendarController::class, 'attendees'])->name('calendar.attendees');

    Route::get('redirect', [CalendarController::class, 'redirect'])->name('redirect');
    Route::get('activity/list', [CalendarController::class, 'index'])->name('activity.list');
    Route::get('calendar', [CalendarController::class, 'list'])->name('calendar.list');

    Route::get('tithes/list', [TithesController::class, 'index'])->name('tithes.list');
    Route::get('tithes/create', [TithesController::class, 'create'])->name('tithes.create');
    Route::post('tithes', [TithesController::class, 'store'])->name('tithes.store');

    Route::get('notifications', [NotificationController::class, 'index'])->name('notifications');
    Route::post('notification', [DashboardController::class, 'markNotification'])->name('mark.notification');
    Route::post('notification/unread', [DashboardController::class, 'unmarkNotification'])->name('unmark.notification');
    Route::get('send-email', [NotificationController::class, 'mail'])->name('notification.mail');

    Route::post('/upload', [AvatarController::class, 'upload'])->name('avatar.upload');

    Route::put('/permissions/{$permission}', [PermissionsController::class, 'update'])->name('permission.update');

    Route::resource('/roles', RolesController::class);
    Route::resource('/admin', AdminController::class);
    Route::resource('/area', AreaServantController::class);
    Route::resource('/chapter', ChapterServantController::class);
    Route::resource('/unit', UnitServantController::class);
    Route::resource('/household', HouseholdServantController::class);
    Route::resource('/permissions', PermissionsController::class);
    Route::resource('/attendance', AttendanceController::class);
    Route::resource('/registration', RegistrationController::class);

    Route::post('registration/payment', [RegistrationController::class, 'payment'])->name('registration.payment');


    Route::get('/paymaya/checkout/success', [CheckoutController::class, 'checkoutSuccess'])->name('checkout.success');
    Route::get('/paymaya/checkout/failure', [CheckoutController::class, 'checkoutFailure'])->name('checkout.failure');
    Route::get('/paymaya/checkout/cancel', [CheckoutController::class, 'checkoutCancel'])->name('checkout.cancel');

    Route::post('/webhook/paymaya', [WebhookController::class, 'handle'])->name('webhook.paymaya');


});

Route::post('/paymaya/checkout', [CheckoutController::class, 'initiateCheckout'])->name('paymaya.checkout');

require __DIR__ . '/auth.php';
