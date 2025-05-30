<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Admin\AdminsAuthController;
use App\Http\Controllers\API\Admin\AttachmentController as AdminAttachmentController;
use App\Http\Controllers\API\Admin\DashboardController;
use App\Http\Controllers\API\Admin\IssueController as AdminIssueController;
use App\Http\Controllers\API\Admin\ExpensesController as AdminExpensesController;
use App\Http\Controllers\API\Admin\SessionController as AdminSessionController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CaseCategryController;
use App\Http\Controllers\API\CaseController;
use App\Http\Controllers\API\CustomerCategryController;
use App\Http\Controllers\API\CustomerController;
use App\Http\Controllers\API\AttachmentController;
use App\Http\Controllers\API\CaseExpenseController;
use App\Http\Controllers\API\ExpenseCategoryController;
use App\Http\Controllers\API\ExpenseController;
use App\Http\Controllers\API\SessionController;
use App\Http\Controllers\API\PaymentController;
use App\Http\Controllers\API\GettingController;
use App\Http\Controllers\API\HomeController;


//////////////////////////  User Public Routes  //////////////////////////
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('/reset-password', [AuthController::class, 'resetPassword']);

//////////////////////////  User Private Routes  //////////////////////////
Route::group(['middleware' => 'auth:sanctum'], function ()
    {
        Route::post('/logout', [AuthController::class, 'logout']);

        //Customer category routes
        Route::get('/categories', [CustomerCategryController::class, 'index']);
        Route::post('/category', [CustomerCategryController::class, 'store']);
        Route::delete('/category/{category}', [CustomerCategryController::class, 'destroy']);

        //Customer routes
        Route::get('/customers', [CustomerController::class, 'index']);
        Route::get('/customer/{customer}', [CustomerController::class, 'show']);
        Route::post('/store-customer', [CustomerController::class, 'store']);
        Route::post('/update-customer/{customer}', [CustomerController::class, 'update']);
        Route::delete('/customer/{customer}', [CustomerController::class, 'destroy']);

        //Case category routes
        Route::get('/case-categories', [CaseCategryController::class, 'index']);
        Route::post('/case-category', [CaseCategryController::class, 'store']);
        Route::delete('/case-category/{category}', [CaseCategryController::class, 'destroy']);

        //Case routes
        Route::prefix('/customer/{customer}')->group(function () {
            Route::get('/cases', [CaseController::class, 'index']);
            Route::get('/case/{case}', [CaseController::class, 'show']);
            Route::post('/store-case', [CaseController::class, 'store']);
            Route::post('/update-case/{case}', [CaseController::class, 'update']);
            Route::delete('/case/{case}', [CaseController::class, 'destroy']);
            
            // Attachment routes
            Route::prefix('/case/{case}')->group(function () {
                Route::get('/attachments', [AttachmentController::class, 'index']);
                Route::get('/attachment/{attachment}', [AttachmentController::class, 'show']);
                Route::post('/store-attachment', [AttachmentController::class, 'store']);
                Route::post('/update-attachment/{attachment}', [AttachmentController::class, 'update']);
                Route::delete('/attachment/{attachment}', [AttachmentController::class, 'destroy']);
                // Session routes
                Route::get('/sessions', [SessionController::class, 'index']);
                Route::get('/session/{session}', [SessionController::class, 'show']);
                Route::post('/store-session', [SessionController::class, 'store']);
                Route::post('/update-session/{session}', [SessionController::class, 'update']);
                Route::delete('/session/{session}', [SessionController::class, 'destroy']);

                // Payment routes
                Route::get('/payments', [PaymentController::class, 'index']);
                Route::get('/payment/{payment}', [PaymentController::class, 'show']);
                Route::post('/store-payment', [PaymentController::class, 'store']);
                Route::post('/update-payment/{payment}', [PaymentController::class, 'update']);
                Route::delete('/payment/{payment}', [PaymentController::class, 'destroy']);

                // case expenses routes
                Route::get('/case-expenses', [CaseExpenseController::class, 'index']);
                Route::get('/case-expenses/{expense}', [CaseExpenseController::class, 'show']);
                Route::post('/store-expense', [CaseExpenseController::class, 'store']);
                Route::post('/update-expense/{expense}', [CaseExpenseController::class, 'update']);
                Route::delete('/expense/{expense}', [CaseExpenseController::class, 'destroy']);

            });
      });


        //getting routes
        Route::get('/sessions', [GettingController::class, 'getAllSessions']);
        Route::get('/payments', [GettingController::class, 'getAllPayments']);
        Route::get('/cases', [GettingController::class, 'getAllCases']);
        Route::get('/attachments', [GettingController::class, 'getAllAttachments']);

        //Expenses category routes
        Route::get('/expense-categories', [ExpenseCategoryController::class, 'index']);
        Route::post('/expense-category', [ExpenseCategoryController::class, 'store']);
        Route::delete('/expense-category/{category}', [ExpenseCategoryController::class, 'destroy']);

        //Expenses routes
        Route::get('/expenses', [ExpenseController::class, 'index']);
        Route::get('/expense/{expense}', [ExpenseController::class, 'show']);
        Route::post('/store-expense', [ExpenseController::class, 'store']);
        Route::post('/update-expense/{expense}', [ExpenseController::class, 'update']);
        Route::delete('/expense/{expense}', [ExpenseController::class, 'destroy']);

        //Home routes
        Route::get('/home', [HomeController::class, 'index']);
        Route::get('/session-dates', [HomeController::class, 'sessionDates']);

  });
Route::prefix('/admin')->group(function () {
    Route::post('/register', [AdminsAuthController::class, 'register']);
    Route::post('/login', [AdminsAuthController::class, 'login']);
});

Route::prefix('/admin')->middleware('auth.admin')->group(function () {



    Route::post('/assignRole', [AdminsAuthController::class, 'assignRole']);

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/offices', [DashboardController::class, 'loadOffices'])->name('offices.index');
    Route::get('/offices/{id}', [DashboardController::class, 'loadOffice'])->name('offices.show');
    Route::delete('/offices/{id}', [DashboardController::class, 'deleteOffice'])->name('offices.delete');
    Route::post('/offices/approve/{id}', [DashboardController::class, 'approveUser'])->name('offices.approve');
    Route::delete('/offices/reject/{id}', [DashboardController::class, 'rejectUser'])->name('offices.reject');



    #Attachments
    Route::get('/attachments', [AdminAttachmentController::class, 'attachment'])->name('offices.attachments');
    Route::post('/attachments/store', [AdminAttachmentController::class, 'store'])->name('offices.attachments.store');
    Route::get('/attachments/{id}', [AdminAttachmentController::class, 'show'])->name('offices.attachments.show');  
    Route::post('/attachments/{id}', [AdminAttachmentController::class, 'update'])->name('offices.attachments.update');
    Route::delete('/attachments/{id}', [AdminAttachmentController::class, 'destroy'])->name('offices.attachments.destroy');

    #Issues
    Route::get('/issue', [AdminIssueController::class, 'issue'])->name('offices.issue');
    Route::post('/issue/store', [AdminIssueController::class, 'store'])->name('offices.issue.store');
    Route::get('/issue/{id}', [AdminIssueController::class, 'show'])->name('offices.issue.show');
    Route::post('/issue/{id}', [AdminIssueController::class, 'update'])->name('offices.issue.update');
    Route::delete('/issue/{id}', [AdminIssueController::class, 'delete'])->name('offices.issue.destroy');

    #Expenses
    Route::get('/expenses', [AdminExpensesController::class, 'index'])->name('offices.expenses');
    Route::post('/expenses/store', [AdminExpensesController::class, 'store'])->name('offices.expenses.store');
    Route::get('/expenses/{id}', [AdminExpensesController::class, 'show'])->name('offices.expenses.show');
    Route::post('/expenses/{id}', [AdminExpensesController::class, 'update'])->name('offices.expenses.update');
    Route::delete('/expenses/{id}', [AdminExpensesController::class, 'destroy'])->name('offices.expenses.destroy');

    #sessions
    Route::get('/sessions', [AdminSessionController::class, 'session'])->name('offices.sessions');
    Route::post('/sessions/store', [AdminSessionController::class, 'storeSession'])->name('offices.sessions.store');
    Route::get('/sessions/{id}', [AdminSessionController::class, 'showSession'])->name('offices.sessions.show');
    Route::post('/sessions/{id}', [AdminSessionController::class, 'updateSession'])->name('offices.sessions.update');
    Route::delete('/sessions/{id}', [AdminSessionController::class, 'deleteSession'])->name('offices.sessions.destroy');
    Route::post('/logout', [AdminsAuthController::class, 'logout']);

});

// Admin routes
    Route::prefix('/admin')->middleware('sub.admin')->group(function () {
    Route::post('/expenses/store', [AdminExpensesController::class, 'store']);
    Route::post('/attachments/store', [AdminAttachmentController::class, 'store']);
    Route::post('/sessions/store', [AdminSessionController::class, 'storeSession']);
    Route::post('/issue/store', [AdminIssueController::class, 'store']);
});

// Route::prefix('/admin')->middleware(['sub.admin','auth.admin'])->group(function () {
//     Route::post('/expenses/store', [AdminExpensesController::class, 'store']);
//     Route::post('/attachments/store', [AdminAttachmentController::class, 'store']);
//     Route::post('/sessions/store', [AdminSessionController::class, 'storeSession']);
//     Route::post('/issue/store', [AdminIssueController::class, 'store']);

// });


