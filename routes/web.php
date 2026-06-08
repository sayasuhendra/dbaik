<?php

use Livewire\Volt\Volt;

Volt::route('/', 'pages.home')->name('home');
Volt::route('/produk/{slug}', 'pages.product-gallery')->name('product.gallery');
Volt::route('/portofolio/{id}', 'pages.portfolio-detail')->name('portfolio.detail');

// Client Portal Routes
Volt::route('/client/login', 'pages.client.login')->name('client.login');
Volt::route('/client/register', 'pages.client.register')->name('client.register');
Volt::route('/client/portal', 'pages.client.portal')->name('client.portal');
