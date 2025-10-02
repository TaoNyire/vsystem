<?php

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
use App\Http\Controllers\StatsController;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::get('/dashboard', function () {
    return view('stats.dashboard');
})->name('dashboard');

// Add routes for each statistic
Route::get('/stats/gender-not-registered', [StatsController::class, 'genderNotRegistered'])->name('stats.gender_not_registered');
Route::get('/stats/winning-candidates', [StatsController::class, 'winningCandidates'])->name('stats.winning_candidates');
Route::get('/stats/candidates-not-registered', [StatsController::class, 'candidatesNotRegistered'])->name('stats.candidates_not_registered');
Route::get('/stats/null-void-votes', [StatsController::class, 'nullVoidVotes'])->name('stats.null_void_votes');
Route::get('/stats/gender-voter-candidate', [StatsController::class, 'genderVoterCandidate'])->name('stats.gender_voter_candidate');