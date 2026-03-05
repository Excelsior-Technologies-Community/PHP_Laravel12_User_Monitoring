# PHP_Laravel12_User_Monitoring

## Introduction

PHP_Laravel12_User_Monitoring is a Laravel 12 project designed to monitor and log user activities within a web application. By integrating the binafy/laravel-user-monitoring package, this project provides comprehensive tracking of user interactions, including login/logout events, page visits, IP addresses, device information, browser details, and URL requests.

The system is particularly useful for security auditing, user behavior analytics, and system monitoring, allowing developers and administrators to gain insights into how users interact with the application.

---

## Project Overview

The project demonstrates how to:

1) Set up a Laravel 12 application with proper authentication using Laravel Breeze.

2) Install and configure the User Monitoring package, including publishing migrations, config files, middleware, and views.

3) Track and store user activity logs in the database via three main tables:

- visits_monitoring — Logs page visits, IP, browser, and device information.

- actions_monitoring — Logs CRUD actions on models (create, update, delete, read).

- authentications_monitoring — Logs login and logout events.

4) Register middleware to automatically capture all web requests.

5) Display monitoring data in a user-friendly dashboard with links to visit monitoring, action monitoring, and authentication monitoring pages.

6) Provide an example route (/test-action) to manually log actions for demonstration.

The project ensures that every authenticated user activity is tracked in real-time, helping developers maintain better security, auditing, and analytics capabilities in Laravel applications.

---

## Project Objective

The goal of this project is to:

* Demonstrate Laravel package integration
* Track authenticated user activity
* Store monitoring logs in the database
* Monitor user browsing behavior
* Record IP, device, and browser information

---

## Features

* Laravel 12 Project Setup
* Authentication with Laravel Breeze
* User Activity Monitoring
* IP Address Tracking
* Browser Detection
* Device Detection
* URL Tracking
* Monitoring Dashboard
* Database Log Storage

---

## System Requirements

Make sure your system has the following installed:

* PHP 8.2+
* Composer
* MySQL
* Node.js (optional but recommended)
* Laravel 12
* XAMPP / Laragon / WAMP

Check installed versions:

```bash
php -v
composer -v
```

---

## Step 1 — Create Laravel 12 Project

Open terminal and run:

```bash
composer create-project laravel/laravel PHP_Laravel12_User_Monitoring "12.*"
```

Move into the project folder:

```bash
cd PHP_Laravel12_User_Monitoring
```

Start Laravel server:

```bash
php artisan serve
```

Open browser:

http://127.0.0.1:8000

If the Laravel welcome page appears, the installation is successful.

---

## Step 2 — Configure Database

Open the `.env` file.

Update database settings:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=user_monitoring_db
DB_USERNAME=root
DB_PASSWORD=
```

Now create the database in **phpMyAdmin**:

Database Name:

```
user_monitoring_db
```

Otherwise

Run Migration Command:

```bash
php artisan migrate
```

---

## Step 3 — Install Laravel Breeze Authentication

User monitoring requires authenticated users.

Install Breeze:

```bash
composer require laravel/breeze --dev
```

Install Breeze scaffolding:

```bash
php artisan breeze:install
```

Install frontend dependencies:

```bash
npm install
```

Build frontend assets:

```bash
npm run dev
```

Run migrations:

```bash
php artisan migrate
```

Authentication is now ready.

Available routes:

```
/register
/login
/dashboard
```

---

## Step 4 — Install User Monitoring Package

Install the package:

```bash
composer require binafy/laravel-user-monitoring
```

This package automatically records user activity.

---

## Step 5 — Publish Config, Migration, and ... Files:

Laravel-User-Monitoring comes with its own config, migration, views, middleware, and routes. To use it in your project, you need to publish these files.

Run:

```bash
php artisan vendor:publish --provider="Binafy\LaravelUserMonitoring\Providers\LaravelUserMonitoringServiceProvider"
```

What this does:

- Copies the configuration file to config/user-monitoring.php

- Copies database migrations to database/migrations (for monitoring tables)

- Copies views to resources/views/vendor/LaravelUserMonitoring

- Copies middleware to app/Http/Middleware (VisitMonitoringMiddleware)

- Copies routes to routes/user-monitoring.php

> This allows you to customize monitoring behavior, UI, and logic in your project


After publishing, run:

```bash
php artisan migrate
```

This will create the following tables:

- visits_monitoring — logs every page visit (IP, browser, platform, device, etc.)

- actions_monitoring — logs model actions (create, update, delete, read)

- authentications_monitoring — logs logins and logouts

Without running migrations, the monitoring system cannot store any data.

---

## Step 6 — Register Middleware (Laravel 12 Method)


Middleware is registered in:

```
bootstrap/app.php
```

Open the file and modify the middleware section.

Add this code:

```php
<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Binafy\LaravelUserMonitoring\Middlewares\VisitMonitoringMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )

    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->appendToGroup('web', [
            VisitMonitoringMiddleware::class,
        ]);
    })

    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
```

This will monitor all web requests.

---

## Step 7 — Update platform.blade.php

Open this file:

```bash
resources/views/vendor/LaravelUserMonitoring/layouts/platform.blade.php
```

```
@php
    // Detect platform safely from any monitoring page
    $platform = '';

    if (isset($visit) && isset($visit->platform)) {
        $platform = $visit->platform;
    } elseif (isset($authenticationMonitoring) && isset($authenticationMonitoring->platform)) {
        $platform = $authenticationMonitoring->platform;
    } elseif (isset($action) && isset($action->platform)) {
        $platform = $action->platform;
    }

    $platform = strtolower($platform);
@endphp


{{-- WINDOWS --}}
@if (str_contains($platform, 'windows'))

<svg class="text-gray-800" xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" viewBox="0 0 24 24">
    <path fill-rule="evenodd" d="M3.005 12 3 6.408l6.8-.923v6.517H3.005ZM11 5.32 19.997 4v8H11V5.32ZM20.067 13l-.069 8-9.065-1.275L11 13h9.067ZM9.8 19.58l-6.795-.931V13H9.8v6.58Z" clip-rule="evenodd"/>
</svg>


{{-- LINUX --}}
@elseif (str_contains($platform, 'linux'))

<svg width="25" height="25" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
    <circle cx="16" cy="16" r="14" fill="#fff"/>
    <path d="M16 6c-3 0-4 3-4 6 0 2 1 3 1 4s-2 3-2 5c0 2 2 4 5 4s5-2 5-4c0-2-2-4-2-5s1-2 1-4c0-3-1-6-4-6z" fill="#000"/>
</svg>


{{-- MAC --}}
@elseif (str_contains($platform, 'mac') || str_contains($platform, 'darwin'))

<svg width="25" height="25" viewBox="0 0 24 24" fill="black" xmlns="http://www.w3.org/2000/svg">
    <path d="M16 2c0 2-2 3-2 3s-1-2 1-3c1-1 1 0 1 0zM12 5c-4 0-7 3-7 7 0 3 2 7 5 7 1 0 2-1 3-1s2 1 3 1c3 0 5-4 5-7 0-4-3-7-7-7z"/>
</svg>


{{-- ANDROID --}}
@elseif (str_contains($platform, 'android'))

<svg width="25" height="25" viewBox="0 0 24 24" fill="#3DDC84" xmlns="http://www.w3.org/2000/svg">
    <path d="M17.6 9.48l1.43-2.48a.5.5 0 10-.87-.5l-1.46 2.52A7.957 7.957 0 0012 8c-1.7 0-3.28.53-4.57 1.44L5.97 6.92a.5.5 0 10-.87.5L6.53 9.5A8 8 0 004 15v5h16v-5a8 8 0 00-2.4-5.52z"/>
</svg>


{{-- IOS --}}
@elseif (str_contains($platform, 'ios') || str_contains($platform, 'iphone'))

<svg width="25" height="25" viewBox="0 0 24 24" fill="black" xmlns="http://www.w3.org/2000/svg">
    <path d="M16 13c0-3 2-4 2-4s-1-2-3-2c-2 0-3 1-3 1s-1-1-3-1c-3 0-5 3-5 6s2 7 5 7c1 0 2-1 3-1s2 1 3 1c2 0 5-3 5-7z"/>
</svg>


{{-- UNKNOWN --}}
@else

<svg width="25" height="25" viewBox="0 0 24 24" fill="gray" xmlns="http://www.w3.org/2000/svg">
    <circle cx="12" cy="12" r="10"/>
</svg>

@endif
```

After Updating

Run this once:

```bash
php artisan optimize:clear
```
---

## Step 8 — Update Dashboard View

Create folder:

```
resources/views/dashboard.blade.php
```

Add:

```blade
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in!") }}
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">

                    <h3 class="text-lg font-bold mb-4 text-gray-900 dark:text-gray-100">
                        User Monitoring
                    </h3>

                    <div class="space-y-3">

                        <a href="/user-monitoring/visits-monitoring"
                            class="block text-gray-600 dark:text-gray-300 hover:text-gray-800 dark:hover:text-gray-100">
                            Visits Monitoring
                        </a>

                        <a href="/user-monitoring/actions-monitoring"
                            class="block text-gray-600 dark:text-gray-300 hover:text-gray-800 dark:hover:text-gray-100">
                            Actions Monitoring
                        </a>

                        <a href="/user-monitoring/authentications-monitoring"
                            class="block text-gray-600 dark:text-gray-300 hover:text-gray-800 dark:hover:text-gray-100">
                            Authentication Monitoring
                        </a>

                    </div>

                </div>
            </div>

        </div>
    </div>

</x-app-layout>
```

---

## Step 9 — Add Monitoring Route

Open:

```
routes/web.php
```

Add:

```php
<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Binafy\LaravelUserMonitoring\Models\ActionMonitoring;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::get('/test-action', function () {

    ActionMonitoring::create([
        'user_id' => auth()->id(),
        'action_type' => 'test',
        'table_name' => 'demo',
        'browser_name' => request()->header('User-Agent'),
        'platform' => php_uname('s'),
        'device' => 'Desktop',
        'ip' => request()->ip(),
        'user_guard' => 'web',
        'page' => request()->url(),
    ]);

    return "Action stored successfully!";
})->middleware('auth'); // <- Add this

require __DIR__.'/auth.php';
require __DIR__.'/user-monitoring.php';
```

---

## Step 10: Run Development Server

Run:

```bash
php artisan serve
```

Now open:

```bash
http://127.0.0.1:8000/register
```

After You can access dashboard

```bash
http://127.0.0.1:8000/dashboard
```

Run:

```bash
http://127.0.0.1:8000/test-action
```

You have visit this for store action.


Monitoring pages

```bash
http://127.0.0.1:8000/user-monitoring/visits-monitoring
http://127.0.0.1:8000/user-monitoring/actions-monitoring
http://127.0.0.1:8000/user-monitoring/authentications-monitoring
```

You will see all user activity logs.

---

## Output

### Visit Monitoring

<img width="1905" height="1030" alt="Screenshot 2026-03-05 142334" src="https://github.com/user-attachments/assets/eb8616f1-1edc-44b1-914c-bd110e056850" />

### Action Monitoring

<img width="1919" height="1028" alt="Screenshot 2026-03-05 142345" src="https://github.com/user-attachments/assets/359b3286-07da-404e-b1e6-28710eda9547" />

### Authentication Monitoring

<img width="1919" height="1028" alt="Screenshot 2026-03-05 142354" src="https://github.com/user-attachments/assets/c9dd52aa-de62-4a00-82f8-bfa521336ca3" />

---

## Project Structure

```
PHP_Laravel12_User_Monitoring
│
├── app
│   ├── Http
│   │   └── Middleware
│   │       └── VisitMonitoringMiddleware.php  ← published from package
│
├── bootstrap
│   └── app.php
│
├── config
│   └── user-monitoring.php  ← published package config
│
├── database
│   ├── migrations
│   │   ├── 2026_03_05_000000_create_visits_monitoring_table.php
│   │   ├── 2026_03_05_000001_create_actions_monitoring_table.php
│   │   └── 2026_03_05_000002_create_authentications_monitoring_table.php
│
├── resources
│   └── views
│       ├── dashboard.blade.php
│       └── vendor
│           └── LaravelUserMonitoring
│
├── routes
│   ├── web.php
│   ├── auth.php
│   └── user-monitoring.php
│
├── .env   ← environment configuration file
│
└── README.md
```

---

## Monitoring Workflow

The monitoring system works like this:

1. User visits the application
2. Middleware intercepts the request
3. Package collects user information
4. Information recorded includes:

   * User ID
   * IP address
   * Browser
   * Device
   * URL
   * Request method
5. Data is stored in the database
6. Logs can be viewed in the monitoring dashboard

---

Your PHP_Laravel12_User_Monitoring Project is now ready!
