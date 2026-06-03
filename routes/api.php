<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Admin\RegistrationController;
use App\Http\Controllers\Admin\AddressController;
use App\Http\Controllers\Admin\AppliqueController;
use App\Http\Controllers\Admin\CategorieController;
use App\Http\Controllers\Admin\ClassifieController;
use App\Http\Controllers\Admin\CommandeController;
use App\Http\Controllers\Admin\ComposeController;
use App\Http\Controllers\Admin\ConcerneController;
use App\Http\Controllers\Admin\ContientController;
use App\Http\Controllers\Admin\EffectueController;
use App\Http\Controllers\Admin\EtageController;
use App\Http\Controllers\Admin\FactureController;
use App\Http\Controllers\Admin\FileController;
use App\Http\Controllers\Admin\InclutController;
use App\Http\Controllers\Admin\LigneController;
use App\Http\Controllers\Admin\LocaliseController;
use App\Http\Controllers\Admin\PavController;
use App\Http\Controllers\Admin\PavCustomController;
use App\Http\Controllers\Admin\PavStandardController;
use App\Http\Controllers\Admin\ProduitController;
use App\Http\Controllers\Admin\ReductionController;
use App\Http\Controllers\Admin\ReductionGlobaleController;
use App\Http\Controllers\Admin\ReductionPersonnelController;
use App\Http\Controllers\Client\CartController;
use App\Http\Controllers\Client\CatalogController;
use App\Http\Controllers\Client\OrderController;
use App\Http\Controllers\Client\ProfessionalRegistrationController;
use App\Http\Controllers\Public\PublicController;
use App\Http\Controllers\user\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('public')->name('api.public.')->group(function (): void {
    Route::get('company', [PublicController::class, 'company'])->name('company');
    Route::get('categories', [PublicController::class, 'categories'])->name('categories');
    Route::post('contact', [PublicController::class, 'contact'])->name('contact');
});

Route::prefix('auth')->group(function (): void {
    Route::post('register', [AuthController::class, 'register'])->name('api.auth.register');
    Route::post('login', [AuthController::class, 'login'])->name('api.auth.login');

    Route::middleware('auth:sanctum')->group(function (): void {
        Route::get('me', [AuthController::class, 'me'])->name('api.auth.me');
        Route::post('logout', [AuthController::class, 'logout'])->name('api.auth.logout');
        Route::put('password', [PasswordController::class, 'update'])->name('api.auth.password.update');
    });
});

Route::post('client/register-request', [ProfessionalRegistrationController::class, 'store'])
    ->name('api.client.register-request');

Route::middleware(['auth:sanctum', 'approved'])->group(function (): void {
    Route::get('roles', [UserController::class, 'roles'])->name('api.roles.index');
    Route::get('stores', [UserController::class, 'stores'])->name('api.stores.index');
    Route::get('client/catalog/products', [CatalogController::class, 'index'])->name('api.client.catalog.products');
    Route::get('client/cart', [CartController::class, 'show'])->name('api.client.cart.show');
    Route::post('client/cart/items', [CartController::class, 'store'])->name('api.client.cart.items.store');
    Route::patch('client/cart/items/{itemId}', [CartController::class, 'update'])->name('api.client.cart.items.update');
    Route::delete('client/cart/items/{itemId}', [CartController::class, 'destroy'])->name('api.client.cart.items.destroy');
    Route::get('client/orders', [OrderController::class, 'index'])->name('api.client.orders.index');
    Route::post('client/orders', [OrderController::class, 'store'])->name('api.client.orders.store');
    Route::get('client/orders/{numero}', [OrderController::class, 'show'])->name('api.client.orders.show');

    Route::prefix('users')->name('api.users.')->controller(UserController::class)->group(function (): void {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('store')->middleware('admin');
        Route::get('/{hashId}', 'show')->name('show');
        Route::patch('/{hashId}', 'update')->name('update')->middleware('admin');
        Route::delete('/{hashId}', 'destroy')->name('destroy')->middleware('admin');
        Route::post('/{hashId}/approve', 'approve')->name('approve')->middleware('admin');
    });
});

Route::middleware(['auth:sanctum', 'approved', 'admin'])
    ->prefix('admin')
    ->name('api.admin.')
    ->group(function (): void {
        Route::get('registrations/pending', [RegistrationController::class, 'pending'])->name('registrations.pending');
        Route::apiResource('addresses', AddressController::class)->parameters(['addresses' => 'id']);
        Route::apiResource('applications', AppliqueController::class)->parameters(['applications' => 'id']);
        Route::apiResource('categories', CategorieController::class)->parameters(['categories' => 'id']);
        Route::apiResource('classifications', ClassifieController::class)->parameters(['classifications' => 'id']);
        Route::apiResource('compositions', ComposeController::class)->parameters(['compositions' => 'id']);
        Route::apiResource('concerns', ConcerneController::class)->parameters(['concerns' => 'id']);
        Route::apiResource('contents', ContientController::class)->parameters(['contents' => 'id']);
        Route::apiResource('executions', EffectueController::class)->parameters(['executions' => 'id']);
        Route::apiResource('factures', FactureController::class)->parameters(['factures' => 'id']);
        Route::apiResource('files', FileController::class)->parameters(['files' => 'id']);
        Route::apiResource('floors', EtageController::class)->parameters(['floors' => 'id']);
        Route::apiResource('inclusions', InclutController::class)->parameters(['inclusions' => 'id']);
        Route::apiResource('lines', LigneController::class)->parameters(['lines' => 'id']);
        Route::apiResource('locations', LocaliseController::class)->parameters(['locations' => 'id']);
        Route::apiResource('orders', CommandeController::class)->parameters(['orders' => 'id']);
        Route::apiResource('pavs', PavController::class)->parameters(['pavs' => 'id']);
        Route::apiResource('pav-customs', PavCustomController::class)->parameters(['pav-customs' => 'id']);
        Route::apiResource('pav-standards', PavStandardController::class)->parameters(['pav-standards' => 'id']);
        Route::apiResource('products', ProduitController::class)->parameters(['products' => 'id']);
        Route::apiResource('reductions', ReductionController::class)->parameters(['reductions' => 'id']);
        Route::apiResource('reductions-globales', ReductionGlobaleController::class)->parameters(['reductions-globales' => 'id']);
        Route::apiResource('reductions-personnelles', ReductionPersonnelController::class)->parameters(['reductions-personnelles' => 'id']);
    });
