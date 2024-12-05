<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\EventController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\OrganizerController;


use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\ShareAdminData;
use App\Http\Middleware\OrganizerMiddleware;
use App\Http\Middleware\ShareOrganizerData;
use App\Http\Middleware\ShareUserData;

use App\Http\Controllers\AuthController;

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// HOMEPAGE AREA
Route::get('/', [EventController::class, 'index'])->name('homepage');
Route::get('/eventDetails', [EventController::class, 'homepage'])->name('eventDetails');
Route::get('/eventCatalog', [EventController::class, 'catalog'])->name('eventCatalog');

Route::get('/events/{id}', [EventController::class, 'show'])->name('events.show');
Route::get('/about', fn() => view('about'))->name('about');
Route::get('/contact', fn() => view('contact'))->name('contact');


// USER AREA
Route::middleware(['auth', ShareUserData::class])->group(function() {
    // Rute untuk halaman dashboard pengguna
    Route::get('/user/dashboard', [ProfileController::class, 'dashboard'])->name('user.dashboard');
    
    // Rute untuk mengedit profil pengguna
    Route::get('/user/edit-profile', [ProfileController::class, 'edit'])->name('user.profile.edit');
    
    // Rute untuk memperbarui profil pengguna
    Route::patch('/user/update-profile', [ProfileController::class, 'update'])->name('user.profile.update');
    
    // Rute untuk menghapus pengguna
    Route::delete('/user/delete', [ProfileController::class, 'destroy'])->name('user.profile.destroy');
    
    // Rute untuk mengubah password
    Route::get('/user/change-password', [ProfileController::class, 'showPasswordForm'])->name('user.password.change');
    Route::patch('/update-password', [ProfileController::class, 'updatePassword'])->name('user.password.update');

    // Rute untuk menampilkan profile di sidebar
    Route::get('/user/profile', [ProfileController::class, 'showProfile'])->name('user.profile.show');
    Route::get('/user/ticket', [ProfileController::class, 'bookHistory'])->name('user.ticket');
    // Rute untuk menampilkan daftar favorites pengguna
    Route::get('/user/favorites', [FavoriteController::class, 'index'])->name('user.favorites');
    Route::post('/logout', [UserController::class, 'logout'])->name('logout');

});


//BOOKING
Route::post('/book/{event}', [BookingController::class, 'store'])->name('book.store');


//FAVORITES
Route::post('/favorites', [FavoriteController::class, 'store'])->name('favorites.store')->middleware('auth');



// ORGANIZER AREA
Route::prefix('organizer')->name('organizer.')->middleware(['auth', OrganizerMiddleware::class, ShareOrganizerData::class])->group(function() {
// });
// Route::prefix('organizer')->name('organizer.')->group(function() {
    Route::get('dashboard', [OrganizerController::class, 'dashboardAdmin'])->name('dashboard');
    Route::post('/logout', [OrganizerController::class, 'logout'])->name('logout');
    Route::get('organizer/create', [OrganizerController::class, 'create'])->name('createEvent');
    Route::post('organizer/store', [OrganizerController::class, 'store'])->name('storeEvent');
    Route::get('organizer/{id}/edit', [OrganizerController::class, 'edit'])->name('editEvent');
    Route::put('organizer/{id}', [OrganizerController::class, 'update'])->name('updateEvent');
    Route::get('manage-tickets', [OrganizerController::class, 'manageTickets'])->name('manageTickets');
    Route::patch('bookings/{id}/update-status', [OrganizerController::class, 'updateBookingStatus'])->name('updateBookingStatus');
    

    Route::get('manage-events', [OrganizerController::class, 'organizerIndex'])->name('manageEvents');
});

// ADMIN AREA
Route::prefix('admin')->name('admin.')->middleware(['auth', AdminMiddleware::class, ShareAdminData::class])->group(function() {
    // Dashboard
    Route::get('dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/admin/search', [AdminController::class, 'search'])->name('admin.search');

    // Manage Users
    Route::get('manage-users', [UserController::class, 'count'])->name('manageUsers'); // View Users
    Route::get('manage-users/create', [UserController::class, 'create'])->name('createUser'); // Create User Form
    Route::post('manage-users', [UserController::class, 'store'])->name('storeUser'); // Store User
    Route::get('manage-users/{user}/edit', [UserController::class, 'edit'])->name('editUser'); // Edit User Form
    Route::put('manage-users/{user}', [UserController::class, 'update'])->name('updateUser'); // Update User
    Route::delete('manage-users/{user}', [UserController::class, 'destroy'])->name('destroyUser'); // Delete User

    // Manage Event
    Route::get('manage-events', [EventController::class, 'adminIndex'])->name('manageEvents');
    Route::get('events/{id}/edit', [EventController::class, 'edit'])->name('editEvent');
    Route::put('events/{id}', [EventController::class, 'update'])->name('updateEvent');
    Route::get('events/create', [EventController::class, 'create'])->name('createEvent');
    Route::post('events/store', [EventController::class, 'store'])->name('storeEvent');
    Route::delete('events/{id}', [EventController::class, 'destroy'])->name('deleteEvent');

    // Manage Ticket
    Route::get('manage-tickets', [AdminController::class, 'manageTickets'])->name('manageTickets');
    Route::patch('bookings/{id}/update-status', [AdminController::class, 'updateBookingStatus'])->name('updateBookingStatus');


    Route::get('manage-events/{event}', [EventController::class, 'show'])->name('manageEvents.show');  // Nama route yang benar

    // Reports
    Route::get('reports', [ReportController::class, 'reports'])->name('reports');

    // Dashboard
    Route::get('dashboard', [ReportController::class, 'reportsDashboard'])->name('dashboard');

    Route::post('/logout', [AdminController::class, 'logout'])->name('logout');

});

require __DIR__.'/auth.php';
