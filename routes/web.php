<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\Admin\Login\LoginController;
use App\Http\Controllers\Admin\Login\ForgotPasswordController;
use App\Http\Controllers\Admin\Dashboard\DashboardController;
use App\Http\Controllers\Admin\Petparent\PetparentController;
use App\Http\Controllers\Admin\Pet\PetController;
use App\Http\Controllers\Admin\Appointments\AppointmentsController;
use App\Http\Controllers\Admin\Barcode\BarcodeController;
use App\Http\Controllers\Admin\Branch\BranchController;
use App\Http\Controllers\Admin\Departments\DepartmentController;
use App\Http\Controllers\Admin\Testcase\TestcaseController;
use App\Http\Controllers\Admin\Report\ReportController;
use App\Http\Controllers\Admin\Revenu\RevenuController;
use App\Http\Controllers\Admin\RefereeDoctor\RefereeDoctorController;
use App\Http\Controllers\Admin\InternalDoctor\InternalDoctorController;
use App\Http\Controllers\Admin\Invoice\InvoiceController;
use App\Http\Controllers\Admin\Notification\NotificationController;
use App\Http\Controllers\Admin\Location\LocationController;
use App\Http\Controllers\Admin\Settings\GeneralSettings;
use App\Http\Controllers\Admin\Settings\VisualSettings;
use App\Http\Controllers\Admin\SystemUsers\RolesPrivilegesController;
use App\Http\Controllers\Admin\SystemUsers\SystemUserController;
use App\Http\Controllers\Admin\NotFoundController\NotFoundController;
use App\Http\Controllers\Admin\TestProfile\TestProfileController;
use App\Http\Controllers\BaseController;
use App\Http\Controllers\Branch\Appointment\BranchAppointmentController;
use App\Http\Controllers\Branch\BaseController\BranchBaseController;
use App\Http\Controllers\Branch\Dashboard\BranchDashboardController;
use App\Http\Controllers\Doctor\Login\DoctorLoginController;
use App\Http\Controllers\Branch\Login\BranchLoginController;
use App\Http\Controllers\Branch\Notification\BranchNotificationController;
use App\Http\Controllers\Branch\Pet\BranchPetController;
use App\Http\Controllers\Branch\Petparent\BranchPetParentController;
use App\Http\Controllers\Branch\RefereeDoctor\BranchRefereeDoctorController;
use App\Http\Controllers\Branch\Report\BranchReportController;
use App\Http\Controllers\Branch\SystemUsers\BranchRolesPrivilegesController;
use App\Http\Controllers\Branch\SystemUsers\BranchSystemUserController;
use App\Http\Controllers\Doctor\Dashboard\DoctorDashboardController;
use App\Http\Controllers\Admin\Sample\SampleController;
use App\Http\Controllers\Branch\Sample\BranchSampleController;
use App\Http\Controllers\Doctor\Notification\DoctorNotificationController;
use App\Http\Controllers\Doctor\Report\DoctorReportController;
use App\Http\Controllers\Front\Auth\RegisterController;
use App\Http\Controllers\Front\Auth\UserLoginController;
use App\Http\Controllers\Front\TestController;

// Utility Routes
Route::get('/linkstorage', function () {
    Artisan::call('storage:link');
    return 'storage linked';
})->name('link.storage');

Route::get('/clear', function () {
    Artisan::call('route:clear');
    Artisan::call('cache:clear');
    Artisan::call('view:clear');
    Artisan::call('config:clear');
    return 'clear';
})->name('clear');



//Front End Routes

Route::get('/', function (){
    return view('Front.home');
});


Route::prefix('front')->group(function () {
    Route::post('/register', [RegisterController::class, 'register'])->name('front.register');
});

Route::post('/front/send-otp', [UserLoginController::class, 'sendOtp'])->name('front.sendOtp');
Route::post('/front/verify-otp', [UserLoginController::class, 'verifyOtp'])->name('front.verifyOtp');
Route::post('/front/resend-otp', [UserLoginController::class, 'resendOtp'])->name('front.resendOtp');
Route::get('/front/userlog-out', [UserLoginController::class, 'logout'])->name('front.userlogout');

Route::get('/front/tests', [TestController::class, 'index'])->name('front.tests');
Route::get('/front/check-login', function () {
    return response()->json(['loggedIn' => auth()->check()]);
});
Route::get('/cart', function (){
    return view('Front.cart');
});

Route::get('/edit-profile', function (){
    return view('Front.edit_profile');
});

Route::get('/billing-summary', function (){
    return view('Front.billing_summary');
});


Route::get('/manage-address', function (){
    return view('Front.manage_address');
});



Route::get('/privacypolicy', function (){
    return view('Front.privacypolicy');
});


Route::get('/profile', function (){
    return view('Front.profile');
});


Route::get('/refundpolicy', function (){
    return view('Front.refundpolicy');
});


Route::get('/termsandcondition', function (){
    return view('Front.termsandcondition');
});

//Front end Routes











Route::get('/login', function (){
    return view('select-login');
})->name('home');




//========================================================================Admin Routes=================================================== 

// Authentication Routes
Route::group(['middleware' => 'prevent-back-history'], function () {
    Route::get('/admin', [LoginController::class, 'index'])->name('admin.login');
});

Route::post('/login-action', [LoginController::class, 'admin_login'])->name('login');

Route::get('/forget-password', [ForgotPasswordController::class, 'showForgetPasswordForm'])->name('forget.password.get');
Route::post('/forget-password', [ForgotPasswordController::class, 'submitForgetPasswordForm'])->name('forget.password.post');
Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('reset.password.get');
Route::post('/reset-password', [ForgotPasswordController::class, 'submitResetPasswordForm'])->name('reset.password.post');
Route::get('/reset-password', function () {
    return abort(404);
});


// Admin Backend Routes
Route::group(['prefix' => 'admin', 'middleware' => ['prevent-back-history', 'auth:master_admins', 'role:master_admins']], function () {
    
    // Dashboard Routes
    Route::controller(DashboardController::class)->group(function () {
        Route::get('/dashboard', 'index')->name('admin.dashboard');
        Route::get('/doctor/dashboard', 'doctorDashboard')->name('doctor.dashboard');
    });

    // Appointment Routes
    Route::controller(AppointmentsController::class)->group(function () {
        Route::get('/appointments', 'index')->name('appointments.index');
        Route::get('/appointments/add', 'add')->name('appointments.add');
        Route::get('/appointments/reciept/{id}', 'viewReciept')->name('appointments.receipt');
        Route::post('/appointments/store', 'store')->name('appointments.store');
        Route::get('/get-pet-details/{pet_id}', 'getPetDetails')->name('get.pet.details');
        Route::get('/get-pet-details-by-code/{pet_code}', 'getPetDetailsByCode')->name('get.pet.details.by.code');
        Route::get('/apointment/test/data-table', 'add_data_table')->name('appointments.test.data_table');
        Route::post('/appointments/pet-and-petparent/store', 'petAndPetparentStore')->name('pet-and-parent.store');
        Route::get('/apointment/data-table', 'data_table')->name('appointments.data_table');
        Route::get('/appointment/edit/{id}', 'edit')->name('appointments.edit');
    });

    // Barcode Routes
    Route::controller(BarcodeController::class)->group(function () {
        Route::get('/barcode/{appointment_id}', 'show')->name('barcode.show');
        Route::post('/barcode-save', 'save')->name('barcode.save');
    });

    // Invoice Routes
    Route::controller(InvoiceController::class)->group(function () {
        Route::get('/invoice/{id}', 'generateInvoice')->name('invoice.print');
    });

    // Branch Routes
    Route::controller(BranchController::class)->group(function () {
        Route::get('/branches', 'index')->name('branches.index');
        Route::get('/branches/add', 'add')->name('branches.add');
        Route::post('/branches/store', 'store')->name('branch.store');
        Route::get('/branches/data-table', 'data_table')->name('branches.data_table');
        Route::get('/branches/edit/{id}', 'edit')->name('branches.edit');
        Route::get('/branches/view/{id}', 'view')->name('branches.view');
        Route::get('/get-states/{countryId}', 'getStates')->name('branches.get_states');
        Route::get('/get-cities/{stateId}', 'getCities')->name('branches.get_cities');
    });

    // Department Routes
    Route::controller(DepartmentController::class)->group(function () {
        Route::get('/departments', 'index')->name('department.index');
        Route::get('/departments/add', 'add')->name('departments.add');
        Route::post('/departments/store', 'store')->name('department.store');
        Route::get('/departments/edit/{id}', 'edit')->name('departments.edit');
        Route::get('/departments/view/{id}', 'view')->name('departments.view');
        Route::get('/departments/data-table', 'data_table')->name('departments.data_table');
    });

    // Pet Parent Routes
    Route::controller(PetparentController::class)->group(function () {
        Route::get('/parent', 'index')->name('petparent.index');
        Route::get('/parent/add', 'add')->name('petparent.add');
        Route::post('/parent/store', 'store')->name('petparent.store');
        Route::get('/parent/data-table', 'data_table')->name('petparent.data_table');
        Route::get('/parent/edit/{id}', 'edit')->name('petparent.edit');
        Route::get('/get-owner-pets-by-phone/{phone}', 'getOwnerPetsByPhone')->name('get.owner.pets.by.phone');
    });

    // Pet Routes
    Route::controller(PetController::class)->group(function () {
        Route::get('/pet', 'index')->name('pet.index');
        Route::get('/pet/add', 'add')->name('pet.add');
        Route::get('/pet/edit/{id}', 'edit')->name('pet.edit');
        Route::post('/pet/store', 'store')->name('pet.store');
        Route::get('/pet/data-table', 'data_table')->name('pet.data_table');
        Route::get('/pet/view/{id}', 'view')->name('pet.view');
    });

    // Internal Doctor Routes
    Route::controller(InternalDoctorController::class)->group(function () {
        Route::get('/internal-doctors', 'index')->name('internaldoctors.index');
        Route::get('/internal-doctors/add', 'add')->name('internaldoctors.add');
        Route::post('/internal-doctor/store', 'store')->name('internaldoctor.store');
        Route::get('/internal-doctor/data-table', 'data_table')->name('internaldoctors.data_table');
        Route::get('/internal-doctor/edit/{id}', 'edit')->name('internaldoctors.edit');
        Route::get('/internal-doctor/view/{id}', 'view')->name('internaldoctors.view');
        Route::get('/internal-doctor/delete/{id}', 'delete')->name('internaldoctors.delete');
    });

    // Referee Doctor Routes
    Route::controller(RefereeDoctorController::class)->group(function () {
        Route::get('/referee-doctors', 'index')->name('refereedoctors.index');
        Route::get('/referee-doctors/add', 'add')->name('refereedoctors.add');
        Route::post('/referee-doctor/store', 'store')->name('refereedoctor.store');
        Route::get('/referee-doctor/data-table', 'data_table')->name('refereedoctors.data_table');
        Route::get('/referee-doctor/edit/{id}', 'edit')->name('refereedoctors.edit');
        Route::post('/refereedoctor/store-ajax', 'storeAjax')->name('refereedoctor.store-ajax');
    });

    // Test Case Routes
    Route::controller(TestcaseController::class)->group(function () {
        Route::get('/test-case', 'index')->name('admin.testcases');
        Route::get('/test-case/add', 'add')->name('testcases.add');
        Route::get('/test-case/edit/{id}', 'edit')->name('testcases.edit');
        Route::get('/test-case/view/{id}', 'view')->name('testcases.view');
        Route::post('/tests/store', 'store')->name('admin.test_case.store');
        Route::get('/test/data-table', 'data_table')->name('testcases.data_table');
        Route::get('/tests/search', 'search')->name('tests.search');
        Route::get('/profiles/{id}/tests','getProfileTests')->name('profiles.tests');
    });

    // Test Profile Routes
    Route::controller(TestProfileController::class)->group(function () {
        Route::get('/test-profile', 'index')->name('testprofile.index'); 
        Route::get('/testprofile/edit/{id}', 'edit')->name('testprofile.edit');
        Route::post('/test-profile/store', 'store')->name('testprofile.store');
        Route::get('/test-profile/data-table', 'data_table')->name('testprofile.data_table');
        
    });

    // Report Routes
    Route::controller(ReportController::class)->group(function () {
        Route::get('/report', 'index')->name('reports.index');
        Route::get('/generate-reports/{id}', 'getGenerateReport')->name('reports.generate');
        Route::get('/reports/view/{id}', 'viewReport')->name('reports.view');
        Route::get('/report/data-table', 'data_table')->name('reports.data_table');
        Route::post('/reports/store', 'store')->name('reports.store');
        Route::post('/reports/pdf', 'reportPdf')->name('reports.pdf');

        Route::post('reports/assign-doctor/{code}', 'assignDoctor')->name('reports.assignDoctor');
        Route::post('/reports/sign/{code}', 'signReport')->name('reports.sign');
        Route::post('/reports/approve/{code}','approveReport')->name('reports.approve');
        Route::post('/reports/reject/{code}','rejectReport')->name('reports.reject');


        
    });



    // Sample Routes
    Route::controller(SampleController::class)->group(function () {
        Route::get('/sample', 'index')->name('sample.index');
        Route::get('/sample-collections/add', 'create')->name('create.sample');
        Route::post('/sample-collection/store', 'store')->name('sample-collection.store');
        Route::get('/sample/data-table', 'data_table')->name('sample.data_table'); 

        // Missing CRUD Routes
        Route::get('/sample-collections/{id}/view', 'view')->name('sample.view');
        Route::get('/sample-collections/{id}/edit', 'edit')->name('sample.edit');
        Route::put('/sample-collections/{id}/update', 'update')->name('sample.update'); 
        Route::delete('/sample-collections/{id}/delete', 'delete')->name('sample.delete');
    });




    // Revenue Routes
    Route::controller(RevenuController::class)->group(function () {
        Route::get('/revenu', 'index')->name('revenue.index');
        Route::get('/revenu/view', 'view')->name('revenue.view');
    });

    // Notification Routes
    Route::controller(NotificationController::class)->group(function () {
        Route::get('/notification', 'index')->name('notification.index');
    });

    // Location Routes
    Route::controller(LocationController::class)->group(function () {
        Route::get('/get-states/{country_id}', 'getStates')->name('get.states');
        Route::get('/get-cities/{state_id}', 'getCities')->name('get.cities');
    });

    // Settings Routes
    Route::controller(GeneralSettings::class)->group(function () {
        Route::get('/general-setting', 'index')->name('general.settings.index');
        Route::post('/general-settings-store', 'store')->name('geraral.settings.store');
    });

    Route::controller(VisualSettings::class)->group(function () {
        Route::get('/visual-setting', 'index')->name('visual.settings.index');
        Route::post('/visual-settings-store', 'store')->name('visual.settings.store');
    });

    // System User and Role Routes
    Route::controller(RolesPrivilegesController::class)->group(function () {
        Route::get('/roles-privileges', 'index')->name('roles-privileges.index');
        Route::get('/roles-privileges/add', 'create')->name('roles-privileges.add');
        Route::post('/roles-privileges/store', 'store')->name('roles-privileges.store');
        Route::get('/roles-privileges/data-table', 'data_table')->name('roles-privileges.data_table');
        Route::get('/roles-privileges/edit/{id}', 'edit')->name('roles-privileges.edit');
        Route::get('/roles-privileges/check-role-exist', 'check_role_exist')->name('roles-privileges.check_role_exist');
    });

    Route::controller(SystemUserController::class)->group(function () {
        Route::get('/system-user', 'index')->name('system-user.index');
        Route::get('/system-user/add', 'create')->name('system-user.add');
        Route::post('/system-user/store', 'store')->name('system-user.store');
        Route::get('/system-user/data-table', 'data_table')->name('system-user.data_table');
        Route::get('/system-user/edit/{id}', 'edit')->name('system-user.edit');
        Route::get('/system-user/check-user-exist', 'check_user_exist')->name('system-user.check_user_exist');
    });

    // Authentication Management Routes
    // Route::controller(LoginController::class)->group(function () {
    //     Route::get('/change-password', 'change_password')->name('change.password');
    //     Route::post('/change-password', 'update')->name('change.password.post');
    //     Route::get('/logout', 'logout')->name('logout');
    // });

    // Authentication Management Routes
    Route::controller(LoginController::class)->group(function () {
        Route::get('/change-password', 'change_password')->name('change.password');
        Route::post('/change-password', 'update')->name('change.password.post');
        Route::get('/logout', 'logout')->name('logout');
    });

    // Base Controller Routes
    Route::controller(BaseController::class)->group(function () {
        Route::get('/sub-category-list', 'subCategoryList')->name('subcategory.list');
        Route::get('/common-delete', 'delete')->name('common.delete');
        Route::post('/change-status', 'status')->name('change-status');
    });

    // 404 Route
    Route::get('/404', [NotFoundController::class, 'index'])->name('notfound');
});


//========================================================================Doctor Routes=================================================== 


// Doctor Login Routes Start


    Route::get('/doctor-login', [DoctorLoginController::class, 'index'])->name('doctor.login');
    Route::post('/doctor/login-action', [DoctorLoginController::class, 'login'])->name('doctor.login.post');


    Route::group(['prefix' => 'doctor', 'middleware' => ['auth:doctor', 'role:doctor']], function () {  


        Route::get('/dashboard', [DoctorDashboardController::class, 'index'])->name('doctor.dashboard');


        Route::get('/logout', [DoctorLoginController::class, 'logout'])->name('doctor.logout');

        Route::controller(DoctorLoginController::class)->group(function () {
            Route::get('/change-password', 'change_password')->name('doctor.change.password');
            Route::post('/change-password', 'update')->name('doctor.change.password.post');
        });



    // Updated Routes (add these to your routes file under the Doctor\Report routes group)
    Route::controller(DoctorReportController::class)->group(function () {
        Route::get('/report', 'index')->name('doctor.reports.index');
        Route::get('/generate-reports/{id}', 'getGenerateReport')->name('doctor.reports.generate');
        Route::get('/reports/view/{id}', 'viewReport')->name('doctor.reports.view');
        Route::post('/reports/store', 'store')->name('doctor.reports.store');
        Route::post('/reports/pdf', 'reportPdf')->name('doctor.reports.pdf');
        Route::get('/report/data-table', 'data_table')->name('doctor.reports.data_table');
        Route::post('/reports/assign-doctor/{code}', 'assignDoctor')->name('doctor.reports.assignDoctor');

        Route::post('/reports/approve/{code}', 'approveReport')->name('doctor.reports.approve');
        Route::post('/reports/reject/{code}', 'rejectReport')->name('doctor.reports.reject');
        Route::post('/reports/sign/{code}', 'signReport')->name('doctor.reports.sign');
        // Route::post('/reports/reopen/{code}', 'reopenReport')->name('doctor.reports.reopen');
    });


    // Notification Routes
    Route::controller(DoctorNotificationController::class)->group(function () {
        Route::get('/notifications', 'index')->name('branch.notification.index');
    });


    });

// Doctor Login Routes End


//========================================================================Branch Routes=================================================== 


// Branch Login Routes (No middleware)
Route::group(['middleware' => 'prevent-back-history'], function () {
    Route::get('/branch-login', [BranchLoginController::class, 'index'])->name('branch.login');
});

Route::post('/branch/login-action', [BranchLoginController::class, 'branch_login'])->name('branch.login.post');


Route::group(['prefix' => 'branch', 'middleware' => ['auth:branch', 'role:branch']], function () {
 
    // Dashboard and core routes
    Route::get('/dashboard', [BranchDashboardController::class, 'index'])->name('branch.dashboard');
    Route::get('/logout', [BranchLoginController::class, 'logout'])->name('branch.logout');

    // Change password
    Route::controller(BranchLoginController::class)->group(function () {
        Route::get('/change-password', 'change_password')->name('branch.change.password');
        Route::post('/change-password', 'update')->name('branch.change.password.post');
    });

    // Appointment Routes (consolidated)
    Route::controller(BranchAppointmentController::class)->group(function () {
        Route::get('/appointments', 'index')->name('branch.appointments.index');
        Route::get('/appointments/add', 'add')->name('branch.appointments.add');
        Route::get('/appointments/reciept/{id}', 'viewReciept')->name('branch.appointments.receipt');
        Route::post('/appointments/store', 'store')->name('branch.appointments.store');
        Route::get('/get-pet-details/{pet_id}', 'getPetDetails')->name('branch.get.pet.details');
        Route::get('/get-pet-details-by-code/{pet_code}', 'getPetDetailsByCode')->name('branch.get.pet.details.by.code');
        Route::post('/appointments/pet-and-petparent/store', 'petAndPetparentStore')->name('branch.pet-and-parent.store');
        Route::get('/apointment/data-table', 'data_table')->name('branch.appointments.data_table');
        Route::get('/appointment/edit/{id}', 'edit')->name('branch.appointments.edit');
        Route::get('/apointment/test/data-table', 'add_data_table')->name('branch.appointments.test.data_table');
        Route::get('/get-owner-pets-by-phone/{phone}', 'getOwnerPetsByPhone')->name('branch.get.owner.pets.by.phone');
        Route::get('/tests/search', 'search')->name('branch.tests.search');
        Route::post('/refereedoctor/store-ajax', 'storeAjax')->name('branch.refereedoctor.store-ajax');
        Route::get('/profiles/{id}/tests','getProfileTests')->name('branch.profiles.tests');
    });

    // Report Routes
    Route::controller(BranchReportController::class)->group(function () {
        Route::get('/report', 'index')->name('branch.reports.index');
        Route::get('/generate-reports/{id}', 'getGenerateReport')->name('branch.reports.generate');
        Route::get('/reports/view/{id}', 'viewReport')->name('branch.reports.view');
        Route::post('/reports/store', 'store')->name('branch.reports.store');
        Route::post('/reports/pdf', 'reportPdf')->name('branch.reports.pdf');
        Route::get('/report/data-table', 'data_table')->name('branch.reports.data_table');
         Route::post('/reports/assign-doctor/{code}', 'assignDoctor')->name('branch.reports.assignDoctor');
    });

    // Pet Parent Routes
    Route::controller(BranchPetParentController::class)->group(function () {
        Route::get('/parent', 'index')->name('branch.petparent.index');
        Route::get('/parent/add', 'add')->name('branch.petparent.add');
        Route::post('/parent/store', 'store')->name('branch.petparent.store');
        Route::get('/parent/data-table', 'data_table')->name('branch.petparent.data_table');
        Route::get('/parent/edit/{id}', 'edit')->name('branch.petparent.edit');
        Route::get('/get-owner-pets-by-phone/{phone}', 'getOwnerPetsByPhone')->name('branch.get.owner.pets.by.phone');
    });

    // Pet Routes
    Route::controller(BranchPetController::class)->group(function () {
        Route::get('/pet', 'index')->name('branch.pet.index');
        Route::get('/pet/add', 'add')->name('branch.pet.add');
        Route::get('/pet/edit/{id}', 'edit')->name('branch.pet.edit');
        Route::post('/pet/store', 'store')->name('branch.pet.store');
        Route::get('/pet/data-table', 'data_table')->name('branch.pet.data_table');
        Route::get('/pet/view/{id}', 'view')->name('branch.pet.view');
    });

    // Barcode Routes (moved inside for auth)
    Route::controller(BarcodeController::class)->group(function (){
        Route::get('/barcode/{appointment_id}', 'show')->name('branch.barcode.show');
        Route::post('/barcode-save', 'save')->name('branch.barcode.save');
    });

    // Invoice Routes (moved inside for auth)
    Route::controller(InvoiceController::class)->group(function () {
        Route::get('/invoice/{id}', 'generateInvoice')->name('branch.invoice.print');
    });

    // Base Controller Routes
    Route::controller(BranchBaseController::class)->group(function () {
        Route::get('/sub-category-list', 'subCategoryList')->name('branch.subcategory.list');
        Route::get('/common-delete', 'delete')->name('branch.common.delete');
        Route::post('/change-status', 'status')->name('branch.change-status');
    });


    // Referee Doctor Routes
    Route::controller(BranchRefereeDoctorController::class)->group(function () {
        Route::get('/referee-doctors', 'index')->name('branch.refereedoctors.index');
        Route::get('/referee-doctors/add', 'add')->name('branch.refereedoctors.add');
        Route::post('/referee-doctor/store', 'store')->name('branch.refereedoctor.store');
        Route::get('/referee-doctor/data-table', 'data_table')->name('branch.refereedoctors.data_table');
        Route::get('/referee-doctor/edit/{id}', 'edit')->name('branch.refereedoctors.edit');
        Route::post('/refereedoctor/store-ajax', 'storeAjax')->name('branch.refereedoctor.store-ajax');
    });



     // System User and Role Routes
    Route::controller(BranchRolesPrivilegesController::class)->group(function () {
        Route::get('/roles-privileges', 'index')->name('branch.roles-privileges.index');
        Route::get('/roles-privileges/add', 'create')->name('branch.roles-privileges.add');
        Route::post('/roles-privileges/store', 'store')->name('branch.roles-privileges.store');
        Route::get('/roles-privileges/data-table', 'data_table')->name('branch.roles-privileges.data_table');
        Route::get('/roles-privileges/edit/{id}', 'edit')->name('branch.roles-privileges.edit');
        Route::get('/roles-privileges/check-role-exist', 'check_role_exist')->name('branch.roles-privileges.check_role_exist');
    });

    Route::controller(BranchSystemUserController::class)->group(function () {
        Route::get('/system-user', 'index')->name('branch.system-user.index');
        Route::get('/system-user/add', 'create')->name('branch.system-user.add');
        Route::post('/system-user/store', 'store')->name('branch.system-user.store');
        Route::get('/system-user/data-table', 'data_table')->name('branch.system-user.data_table');
        Route::get('/system-user/edit/{id}', 'edit')->name('branch.system-user.edit');
        Route::get('/system-user/check-user-exist', 'check_user_exist')->name('branch.system-user.check_user_exist');
    });



    // Branch Sample Routes
        Route::controller(BranchSampleController::class)->group(function () {
            Route::get('/sample', 'index')->name('branch.sample.index');
            Route::get('/sample-collections/add', 'create')->name('branch.create.sample');
            Route::post('/sample-collection/store', 'store')->name('branch.sample-collection.store');
            Route::get('/sample/data-table', 'data_table')->name('branch.sample.data_table'); 
            // CRUD Routes
            Route::get('/sample-collections/{id}/view', 'view')->name('branch.sample.view');
            Route::get('/sample-collections/{id}/edit', 'edit')->name('branch.sample.edit');
            Route::put('/sample-collections/{id}/update', 'update')->name('branch.sample.update'); 
            Route::delete('/sample-collections/{id}/delete', 'delete')->name('branch.sample.delete');
            // Additional AJAX Route
            Route::get('/sample/get-appointment/{id}', 'getAppointment')->name('branch.sample.getAppointment');
        });



    // Notification Routes
    Route::controller(BranchNotificationController::class)->group(function () {
        Route::get('/notifications', 'index')->name('branch.notification.index');
    });
});

// Branch Login Routes End






// Fallback Route
Route::fallback(function () {
    return redirect('/admin/404');
})->name('fallback');