<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\ResumeAdminController;
use App\Http\Controllers\Auth\LoginController; // Use your custom login controller

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- Public Routes ---
Route::get('/', [PortfolioController::class, 'home'])->name('home');
Route::get('/resume/{user}', [PortfolioController::class, 'show'])->name('resume.public');

// --- Your Custom Authentication Routes ---
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


// --- Admin Routes (protected by login) ---
Route::middleware(['auth'])->group(function () {
    
    Route::get('/admin/resume', [ResumeAdminController::class, 'edit'])->name('resume.edit');
    Route::post('/admin/profile', [ResumeAdminController::class, 'updateProfile'])->name('admin.profile.update');

    Route::post('/admin/skills', [ResumeAdminController::class, 'addSkill'])->name('skills.add');
    Route::delete('/admin/skills/{skill}', [ResumeAdminController::class, 'deleteSkill'])->name('skills.delete');

    Route::post('/admin/education', [ResumeAdminController::class, 'addEducation'])->name('education.add');
    Route::delete('/admin/education/{education}', [ResumeAdminController::class, 'deleteEducation'])->name('education.delete');

    Route::post('/admin/experience', [ResumeAdminController::class, 'addExperience'])->name('experience.add');
    Route::delete('/admin/experience/{experience}', [ResumeAdminController::class, 'deleteExperience'])->name('experience.delete');

    Route::post('/admin/projects', [ResumeAdminController::class, 'addProject'])->name('projects.add');
    Route::delete('/admin/projects/{project}', [ResumeAdminController::class, 'deleteProject'])->name('projects.delete');

    Route::post('/admin/organizations', [ResumeAdminController::class, 'addOrganization'])->name('organizations.add');
    Route::delete('/admin/organizations/{organization}', [ResumeAdminController::class, 'deleteOrganization'])->name('organizations.delete');
});