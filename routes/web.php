<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Profile\ImageController;
use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Database\Eloquent\Casts\Attribute;
use OpenAI\Laravel\Facades\OpenAI;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;



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
    return view('welcome');
    //$users = DB::select('SELECT * FROM users WHERE email = ?', ['harshit@123gmail.com']);
    //$user_insert = DB::insert('INSERT INTO users (name, email, password) VALUES (?, ?, ?)', ['kiran', 'kiran@gmail.com', '123456789']);
    //$user_delete = DB::delete('DELETE FROM users WHERE id = ?', [4]);
    //$user_update = DB::update('UPDATE users SET name = ? WHERE id = ?', ['kiran', 2]);

    //$users = DB::table('users')->get();
    // $user_insert = DB::table('users')->insert([
    //     'name' => 'AAAA',
    //     'email' => 'aaa@gmil.com',
    //     'password' => md5('123456789'),
    // ]);
    // $user_update = DB::table('users')->where('id', '=', '1')->update([
    //     'name' => 'anuradha',
    // ]);
    // $user_delete = DB::table('users')->where('id', '=', '10')->delete();
    // //$user_find = DB::table('users')->find(2);
    // $user_find = DB::table('users')->first();
    
    //wirte a eloquent query
    // $user = User::find(1);
    // $user = User::all();
    // $users = User::where('id', '=', '1')->first();
    // $user_insert = User::create([
    //     'name' => 'Kk',
    //     'email' => 'kk@gmail.com',
    //     'password' => '123456789',
    // ]);
    // $user_update = User::where('id', '=', '12')->update([
    //     'name' => 'reee',
    // ]);
    // $user_delete = User::where('id', '=', '12')->delete();
    // 
    //  dd($user->name);
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    //Uploade Image route
    Route::patch('/profile/Image', [ImageController::class, 'Image_uploade'])->name('profile.uploadeImage');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// Route::get('/openai',function(){
//     //create image code here using openai-php client 
//     $result = OpenAI::images()->create([
//         'prompt' => 'A cute baby sea otter',
//         'n' => 1,
//         'size' => '512x512'
//     ]);
    
//     // dd($result); 
    

// });

//Github authentication route here 
Route::post('/auth/redirect', function () {
    return Socialite::driver('github')->redirect();
})->name('login.github');
 
Route::get('/auth/callback', function () {
    // dd(auth());
    $user = Socialite::driver('github')->user();
     
    $user = User::updateOrCreate(['email' => $user->email], [
        'name' => $user->name,
        'password' => 'password',
    ]);

    Auth::login($user);
    return redirect()->route('dashboard');
    // dd($user);
    // $user->token
});

Route::middleware('auth')->group(function () {
    Route::resource('/ticket', TicketController::class);
    // Route::resource('/ticket',TicketController::class);
});