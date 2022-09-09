<?php

use App\DTO\OrderData;
use App\Http\Controllers\Admin\UserProfileController;
use App\Http\Controllers\AdminCompanyController;
use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Company\AdjustOfferController;
use App\Http\Controllers\Company\InsightsController;
use App\Http\Controllers\Company\OrderController;
use App\Http\Livewire\Admin\CompanyEdit;
use App\Http\Livewire\Admin\Dashboard as AdminDashboard;
use App\Http\Livewire\Admin\Plans;
use App\Http\Livewire\Auth\Login;
use App\Http\Livewire\Auth\Verify;
use App\Http\Livewire\Auth\Register;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Auth\Passwords\Email;
use App\Http\Livewire\Auth\Passwords\Reset;
use App\Http\Livewire\Auth\Passwords\Confirm;
use App\Http\Livewire\Company\Dashboard as CompanyDashboard;
use App\Http\Livewire\CompanyOffers;
use App\Http\Livewire\Company\Order as CompanyOrder;
use App\Imports\SubscriptionsImport;
use App\Mail\Admin\Company\OrderConfirmed;
use App\Mail\Admin\UpdateCompanyAgreement;
use App\Mail\Admin\UploadCompanyAgreement;
use App\Models\Company;
use App\Notifications\Company\OfferExpiredNotification;
use App\Notifications\Company\WelcomeNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

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

Route::redirect('/', '/login')->name('home');



Route::group([
    'prefix' => 'cta',
    'as' => 'cta.',
    'middleware' => ['signed', 'throttle:60,1']
], function () {
    Route::get('/update-agreement/{company}', function (Company $company) {
        Mail::to('ticket@telekomkollen.se')->send(new UpdateCompanyAgreement($company));
        return redirect()->intended(route('home'));
    })->name('update-agreement');
    Route::get('/upload-agreement/{company}', function (Company $company) {
        Mail::to('ticket@telekomkollen.se')->send(new UploadCompanyAgreement($company));
        return redirect()->intended(route('home'));
    })->name('upload-agreement');
});


Route::middleware(['auth', 'verified', 'can:view-company,manage-company'])
    ->as('company.')
    ->group(function () {
        Route::get('/dashboard', CompanyDashboard::class)->name('dashboard');
        Route::get('/insikter', InsightsController::class)->name('insikter');
        Route::view('/prisforslag', 'company/offers')->name('offers');
        Route::get('/bestall', CompanyOrder::class)->name('order');
        // Route::post('/order', OrderController::class)->name('order.store');
        Route::get('status', [OrderController::class, 'view'])->name('order.summary');
        Route::view('/faktura', 'company/order-review')->name('order-complete');
        Route::get('/anpassa/{operator}', AdjustOfferController::class)->name('adjust');
    });

Route::middleware('auth', 'can:create-companies')
    ->prefix('admin')
    ->as('admin.')
    ->group(function ($adminRouter) {
        // $adminRouter->redirect('/', '/admin/dashboard');
        // $adminRouter->prefix('dashboard')->group(function ($adminDashRouter) {
        // $adminDashRouter->redirect('/', 'admin/companies');
        // $adminDashRouter->get('/', AdminDashboard::class)->name('.dashboard');
        // });

        $adminRouter->get('dashboard', function () {
            return redirect(route('admin.company.index'));
        })->name('dashboard');


        $adminRouter->get('/profile', [UserProfileController::class, 'show'])
            ->name('profile.show');



        $adminRouter->get('companies', [AdminCompanyController::class, 'index'])->name('company.index');
        $adminRouter->get('companies/{company}/edit', CompanyEdit::class)->name('company.edit');

        $adminRouter->get('plans', Plans::class)->name('plans.index');
    });


Route::prefix('system')->as('system.')->middleware('auth', 'role:super-admin')->group(function ($systemRoutes) {
    $systemRoutes->get('', function () {
        return response('SYSTEM HOME', 200);
    })->name('home');

    $systemRoutes->get('mail', function () {
        try {
            $company = company(1);

            $order = $company->order;
            $data = collect($order->order_data)->groupBy('is_vaxel_plan')->map(fn ($group) => $group->map(fn ($data) => OrderData::fromArray($data)))->flatten();
            $plansData = [
                'data' => $data,
                'total' => $order->total,
            ];
            $form = [
                'order' => [
                    'gatunamn' => $company->address->gatunamn,
                    'postnr' => $company->address->postnr,
                    'postort' => $company->address->postort,
                ]
            ];
            $company->contact->notify(new OfferExpiredNotification($company));

            echo 'TEST MAIL SENT';
        } catch (\Throwable $th) {
            throw $th;
        }
    });

    $systemRoutes->view('test', 'test');
});
