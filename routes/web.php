<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\SessionController;
use App\Http\Controllers\Admin\ExpensesController;
use App\Http\Controllers\Admin\IssueController;
use App\Http\Controllers\Admin\AttachmentController;
use App\Http\Controllers\Admin\CaseCategoryController;


use Illuminate\Support\Facades\Route;


//////////////////////////////////Admin Routes//////////////////////////////////


//public routes
Route::get('/', [AuthController::class, 'loadLoginPage'])->name('loginPage');
Route::post('/login-admin', [AuthController::class, 'loginUser'])->name('loginUser');

//protected routes
Route::middleware(['auth.admin'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout'); 
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/offices', [DashboardController::class, 'loadOffices'])->name('offices.index');
    Route::get('/offices/{id}', [DashboardController::class, 'loadOffice'])->name('offices.show');
    Route::delete('/offices/{id}', [DashboardController::class, 'deleteOffice'])->name('offices.delete');
    Route::post('/offices/approve/{id}', [DashboardController::class, 'approveUser'])->name('offices.approve');
    Route::delete('/offices/reject/{id}', [DashboardController::class, 'rejectUser'])->name('offices.reject');
    
    //Session
    Route::get('/session', [SessionController::class, 'session'])->name('offices.session');
    Route::get('/sessions/create', [SessionController::class, 'createSession'])->name('offices.session.create');
    Route::post('/sessions/store', [SessionController::class, 'storeSession'])->name('offices.session.store');
    Route::get('/sessions/{id}/edit', [SessionController::class, 'editSession'])->name('offices.session.edit');
    Route::post('/sessions/{id}/update', [SessionController::class, 'updateSession'])->name('offices.session.update');
    Route::delete('/sessions/{id}', [SessionController::class, 'deleteSession'])->name('offices.session.delete');
    Route::get('/sessions/{id}', [SessionController::class, 'showSession'])->name('offices.session.show');
    //Expenses

Route::get('/expenses', [ExpensesController::class, 'index'])->name('offices.expenses');               // عرض الكل
Route::get('/expenses/create', [ExpensesController::class, 'create'])->name('offices.expenses.create');   // صفحة إضافة
Route::post('/expenses/store', [ExpensesController::class, 'store'])->name('offices.expenses.store');    // حفظ جديد
Route::get('/expenses/{id}/edit', [ExpensesController::class, 'edit'])->name('offices.expenses.edit');   // تعديل
Route::post('/expenses/{id}/update', [ExpensesController::class, 'update'])->name('offices.expenses.update'); // تحديث
Route::delete('/expenses/{id}', [ExpensesController::class, 'destroy'])->name('offices.expenses.destroy');   // حذف
Route::get('/expenses/{id}', [ExpensesController::class, 'show'])->name('offices.expenses.show');


//Issue
Route::get('/issues', [IssueController::class, 'issue'])->name('offices.issue');
Route::get('/issues/create', [IssueController::class, 'create'])->name('offices.issue.create');
Route::post('/issues/store', [IssueController::class, 'store'])->name('offices.issue.store');
Route::get('/issues/{id}/edit', [IssueController::class, 'edit'])->name('offices.issue.edit');
Route::put('/issues/{id}/update', [IssueController::class, 'update'])->name('offices.issue.update');
Route::delete('/issues/{id}', [IssueController::class, 'delete'])->name('offices.issue.delete');
Route::get('/issues/{id}', [IssueController::class, 'show'])->name('offices.issue.show');
Route::get('/issues/category/{category}', [IssueController::class, 'showByCategory'])->name('offices.issue.byCategory');


    // Attachment
    Route::get('/attachments', [AttachmentController::class, 'attachment'])->name('offices.attachments');
    Route::get('/attachments/create', [AttachmentController::class, 'create'])->name('offices.attachments.create');
    Route::post('/attachments/store', [AttachmentController::class, 'store'])->name('offices.attachments.store');
    Route::delete('/attachments/{id}', [AttachmentController::class, 'destroy'])->name('offices.attachments.destroy');
    Route::get('/attachments/{id}/edit', [AttachmentController::class, 'edit'])->name('offices.attachments.edit');
    Route::put('/attachments/{id}/update', [AttachmentController::class, 'update'])->name('offices.attachments.update');
    Route::get('/attachments/{id}', [AttachmentController::class, 'show'])->name('offices.attachments.show');

});
