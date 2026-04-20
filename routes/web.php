<?php

use Illuminate\Support\Facades\Route;

use Livewire\Volt\Volt;

Volt::route('/', 'pages.home')->name('home');
Volt::route('/produk/{slug}', 'pages.product-gallery')->name('product.gallery');
Volt::route('/portofolio/{id}', 'pages.portfolio-detail')->name('portfolio.detail');
