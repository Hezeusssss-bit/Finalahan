<?php



use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProductController;

use App\Http\Controllers\ProgramController;

use App\Http\Controllers\ServiceController;

use App\Http\Controllers\ActivityLogController;

use App\Http\Controllers\SmsController;



/*

|--------------------------------------------------------------------------

| Web Routes

|--------------------------------------------------------------------------

|

| Here is where you can register web routes for your application. These

| routes are loaded by the RouteServiceProvider within a group which

| contains the "web" middleware group. Now create something great!

|

*/



Route::middleware('authCheck')->group(function () {
    // Resource routes for residents with resident.* names
    Route::resource('residents', App\Http\Controllers\ProductController::class)->names([
        'index' => 'resident.index',
        'create' => 'resident.create',
        'store' => 'resident.store',
        'show' => 'resident.show',
        'edit' => 'resident.edit',
        'update' => 'resident.update',
        'destroy' => 'resident.destroy',
    ]);

    // Officials page
    Route::get('/officials', function () {
        return view('Officials.officials');
    })->name('officials');

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

// Employee Management (temporarily outside auth for testing)
Route::get('/employee', [App\Http\Controllers\EmployeeController::class, 'index'])->name('employee.employee');
Route::get('/employee/dashboard', [App\Http\Controllers\EmployeeController::class, 'dashboard'])->name('employee.dashboard')->middleware('authCheck');
Route::get('/employee/history', [App\Http\Controllers\EmployeeController::class, 'history'])->name('employee.history')->middleware('authCheck');
Route::post('/employee', [App\Http\Controllers\EmployeeController::class, 'store'])->name('employee.store');
Route::put('/employee/{id}', [App\Http\Controllers\EmployeeController::class, 'update'])->name('employee.update');
Route::delete('/employee/{id}', [App\Http\Controllers\EmployeeController::class, 'destroy'])->name('employee.destroy');
Route::get('/employee/{id}/get', [App\Http\Controllers\EmployeeController::class, 'getEmployee'])->name('employee.get');

// Employee Assignment Management
Route::get('/employee-assignments', [App\Http\Controllers\EmployeeAssignmentController::class, 'index'])->name('employee-assignments.index');
Route::get('/employee-assignments/create', [App\Http\Controllers\EmployeeAssignmentController::class, 'create'])->name('employee-assignments.create');
Route::post('/employee-assignments', [App\Http\Controllers\EmployeeAssignmentController::class, 'store'])->name('employee-assignments.store');
Route::get('/employee-assignments/{assignment}/edit', [App\Http\Controllers\EmployeeAssignmentController::class, 'edit'])->name('employee-assignments.edit');
Route::put('/employee-assignments/{assignment}', [App\Http\Controllers\EmployeeAssignmentController::class, 'update'])->name('employee-assignments.update');
Route::delete('/employee-assignments/{assignment}', [App\Http\Controllers\EmployeeAssignmentController::class, 'destroy'])->name('employee-assignments.destroy');
Route::post('/employee-assignments/{assignment}/complete', [App\Http\Controllers\EmployeeAssignmentController::class, 'complete'])->name('employee-assignments.complete');
Route::get('/api/employee-assignments/date/{date}', [App\Http\Controllers\EmployeeAssignmentController::class, 'getAssignmentsForDate']);
Route::get('/api/employee-assignments/employee/{employeeId}', [App\Http\Controllers\EmployeeAssignmentController::class, 'getEmployeeAssignments']);



// Events page (public)

Route::get('/events', function () {

    return view('Events.event');

})->name('events');



// Activity Logs (public access) - Using controller to pass data
Route::get('/activity-logs', [ActivityLogController::class, 'index'])->name('activity-logs.index');



Route::get('/', function () {

    return redirect()->route('login'); // redirect root to login page

});



// Login routes

Route::get('/login', [ProductController::class, 'login'])->name('login');

Route::post('/login', [ProductController::class, 'loginPost'])->name('login.post');

Route::post('/logout', [ProductController::class, 'logout'])->name('logout');



Route::get('/home', [ProductController::class, 'home'])->name('home');

Route::get('/facilities', [ProductController::class, 'facilities'])->name('facilities');

Route::get('/facilities/community-center', [ProductController::class, 'communityCenter'])->name('community');

Route::get('/facilities/health-center', [ProductController::class, 'healthCenter'])->name('health');

Route::get('/facilities/emergency-shelter', [ProductController::class, 'emergencyShelter'])->name('shelter');

Route::get('/school', [ProductController::class, 'school'])->name('school');

Route::get('/try-all', [ProductController::class, 'tryAll'])->name('tryall');

Route::post('/try-all', [ProductController::class, 'tryAll'])->name('tryall.post');

Route::get('/try-all/recipients', [ProductController::class, 'getRecipients'])->name('tryall.recipients');



// Program Management Routes

Route::get('/program', [ProgramController::class, 'index'])->name('program.index');

Route::post('/program', [ProgramController::class, 'store'])->name('program.store');

Route::put('/program/{id}', [ProgramController::class, 'update'])->name('program.update');

Route::delete('/program/{id}', [ProgramController::class, 'destroy'])->name('program.destroy');

Route::post('/program/update-statuses', [ProgramController::class, 'updateAllStatuses'])->name('program.update-statuses');



Route::post('/send-evacuation-sms', [SmsController::class, 'sendEvacuationAlert'])->name('send.evacuation.sms');

Route::post('/sms/test', [SmsController::class, 'sendTestSms'])->name('sms.test');



// Direct view routes for newly moved Blade files

Route::view('/facility', 'Facility.facilities')->name('facility.facilities');

Route::view('/sms/tryall', 'SMS.tryall')->name('sms.tryall');



// Services Routes

Route::get('/services', [ServiceController::class, 'index'])->name('services');

Route::post('/services/officials', [ServiceController::class, 'storeOfficial'])->name('services.officials.store');



Route::get('/assign-venue', function () {

    return view('Services.assignvenue');

})->name('services.assignvenue');



Route::post('/assign-venue', function (\Illuminate\Http\Request $request) {

    // Here you would typically save the venue assignment to the database

    // For now, we'll just redirect back with a success message

    return redirect()->route('services.assignvenue')

        ->with('success', 'Venue assigned successfully!');

})->name('services.assignvenue.store');



// Additional Program Routes (moved outside auth for testing)

Route::get('/program/evacuee', [ProductController::class, 'evacueeProgram'])->name('program.evacuee');

Route::post('/program/evacuee', [ProductController::class, 'storeEvacuees'])->name('program.evacuee.store');

Route::get('/program/evacuee/export', [ProductController::class, 'exportEvacuees'])->name('program.evacuee.export');

Route::get('/api/evacuees/statistics', [ProductController::class, 'getEvacueesStatistics'])->name('evacuees.statistics');

Route::get('/api/residents/by-purok', [ProductController::class, 'getResidentsByPurok'])->name('residents.by-purok');

Route::view('/program/add', 'Program.AddProgram')->name('program.add');



// Officials Route

Route::get('/officials', function () {

    return view('Officials.officials');

})->name('officials');

