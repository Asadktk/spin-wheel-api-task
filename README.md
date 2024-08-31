<p align="center">
  <a href="https://laravel.com" target="_blank">
    <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
  </a>
</p>

<p align="center">
  <a href="https://github.com/laravel/framework/actions">
    <img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status">
  </a>
  <a href="https://packagist.org/packages/laravel/framework">
    <img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads">
  </a>
  <a href="https://packagist.org/packages/laravel/framework">
    <img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version">
  </a>
  <a href="https://packagist.org/packages/laravel/framework">
    <img src="https://img.shields.io/packagist/l/laravel/framework" alt="License">
  </a>
</p>

# Spin Wheel API

This repository contains the code for the Spin Wheel API project. Follow the instructions below to set up the project locally.

## Getting Started

### Prerequisites

Before starting, make sure you have the following software installed on your machine:

- **PHP** (version 8.0 or higher)
- **Composer** (latest version)
- **MySQL** or any other supported database
- **Git**

### Installation

Follow these steps to set up the project locally:

1. **Clone the Repository**

   First, clone the repository to your local machine. Open your terminal and run:

   ```bash
   git clone https://github.com/Asadktk/spin-wheel-api-task.git
   cd spin-wheel-api-task
   git checkout master
   git pull origin master
   code .


### Explanation:
```bash
- cp .env.example .env 
- `composer install` 

- `php artisan key:generate`
- `php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"`
- `php artisan migrate`
- `composer require "spatie/laravel-medialibrary"`
- `php artisan vendor:publish --provider="Spatie\MediaLibrary\MediaLibraryServiceProvider" --tag="medialibrary-migrations"`
- `composer require bavix/laravel-wallet`
- `php artisan vendor:publish --tag=laravel-wallet-migrations`
- `php artisan vendor:publish --tag=laravel-wallet-config`
- `php artisan migrate`
- `php artisan db:seed --class=RolesSeeder`
- `php artisan db:seed`
- `php artisan serve`
