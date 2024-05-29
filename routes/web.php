<?php

use App\Http\Controllers\Admin\AdminLoginController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\admin\HomeController;
use App\Http\Controllers\admin\SubCategoryController;
use App\Http\Controllers\admin\TempImagesController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontController;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

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

// Route::get('/', function () {
//     return view('welcome');
// });

// Front-end
Route::get('/', [FrontController::class,'index']) -> name('front.home');

// login register
Route::get('/register',[AuthController::class,'register'])->name('account.register');
Route::post('/process-register',[AuthController::class,'processRegister'])->name('account.processRegister');



// Back-end
Route::group(['prefix' => 'admin'], function(){

    Route::group(['middleware' => 'admin.guest'], function(){

        Route::get('/login', [AdminLoginController::class,'index']) -> name('admin.login');
        Route::post('/authenticate', [AdminLoginController::class,'authenticate']) -> name('admin.authenticate');
    });

    Route::group(['middleware' => 'admin.auth'], function(){
        Route::get('/dashboard', [HomeController::class,'index']) -> name('admin.dashboard');
        Route::get('/logout', [HomeController::class,'logout']) -> name('admin.logout');

        // Category Routes
        Route::get('/categories', [CategoryController::class,'index']) -> name('categories.index');
        Route::get('/categories/create', [CategoryController::class,'create']) -> name('categories.create');
        Route::post('/categories', [CategoryController::class,'store']) -> name('categories.store');
        Route::get('/categories/{categories}/edit', [CategoryController::class,'edit']) -> name('categories.edit');
        Route::put('/categories/{categories}', [CategoryController::class,'update']) -> name('categories.update');
        Route::delete('/categories/{categories}', [CategoryController::class,'destroy']) -> name('categories.delete');

        // Sub Category Routes
        Route::get('/sub-categories/create', [SubCategoryController::class,'create']) -> name('sub-categories/create');
        Route::post('/sub-categories',[SubCategoryController::class,'store']) -> name('sub-categories.store');

        // temp-image.create
        Route::post('/upload-temp-image', [TempImagesController::class,'create']) -> name('temp-images.create');

        Route::get('/getSlug', function(Request $request){
            $slug = '';
            if(!empty($request->title)) {
                $slug = Str::slug($request->title);
            }
            return response()->json([
                'status' => true,
                'slug' => $slug
            ]);
        })->name('getSlug');
    });
});
