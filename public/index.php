<?php
// Chỉ bật lỗi khi phát triển — TẮT trong production
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
ini_set('log_errors', '1');

require_once __DIR__ . '/../bootstrap.php';
define('APPNAME', 'FootBallBooking');
session_start();
$router = new \Bramus\Router\Router();

// Auth Routes Xong
$router->get('/login', '\App\Controllers\Auth\LoginController@showLoginForm');
$router->post('/login', '\App\Controllers\Auth\LoginController@store');
$router->get('/register', '\App\Controllers\Auth\RegisterController@showRegisterForm');
$router->post('/register', '\App\Controllers\Auth\RegisterController@store');
$router->post('/logout', '\App\Controllers\Auth\LoginController@destroy');

// Trang chính Xong
$router->get('/', '\App\Controllers\HomeController@index');
$router->get('/list', '\App\Controllers\ListController@index');
$router->get('/contact', '\App\Controllers\ContactController@index');
$router->get('/aboutus', '\App\Controllers\AboutUsController@index');

// Chi tiết 1 sân (public) Xong
$router->get('/field/(\w[\w-]*)', '\App\Controllers\FieldDetailController@index');

// Hồ sơ người dùng Xong
$router->get('/profile', '\App\Controllers\ProfileController@index');
$router->post('/profile', '\App\Controllers\ProfileController@update');

// Booking
$router->get('/bookings', '\App\Controllers\BookingController@index');
$router->get('/bookings/create', '\App\Controllers\BookingController@create');
$router->post('/bookings', '\App\Controllers\BookingController@store');
$router->post('/bookings/(\w[\w-]*)/cancel', '\App\Controllers\BookingController@cancel');

// Admin Xong
$router->get('/admin', '\App\Controllers\AdminController@index');
$router->post('/admin/users/deactivate', '\App\Controllers\AdminController@deactivate');
$router->post('/admin/users/activate', '\App\Controllers\AdminController@activate');
$router->post('/admin/users/set-owner', '\App\Controllers\AdminController@setOwner');
$router->post('/admin/users/revoke-owner', '\App\Controllers\AdminController@revokeOwner');

// --- OWNER: quản lý sân --- Xong
$router->get('/owner', '\App\Controllers\OwnerController@index');
$router->get('/owner/fields/create', '\App\Controllers\OwnerController@createField');
$router->post('/owner/fields', '\App\Controllers\OwnerController@storeField');
$router->get('/owner/fields/(\w[\w-]*)/edit', '\App\Controllers\OwnerController@editField');
$router->post('/owner/fields/(\w[\w-]*)', '\App\Controllers\OwnerController@updateField');
$router->post('/owner/fields/(\w[\w-]*)/delete', '\App\Controllers\OwnerController@deleteField');
$router->get('/owner/bookings', '\App\Controllers\OwnerController@allBookings');
$router->post('/owner/bookings/(\w[\w-]*)/payment-status', '\App\Controllers\OwnerController@updatePaymentStatus');


// Bình luận Xong
$router->post('/reviews', '\App\Controllers\ReviewController@store');
$router->post('/reviews/delete', '\App\Controllers\ReviewController@delete');
$router->post('/reviews/edit', '\App\Controllers\ReviewController@update');

// SSE Realtime Xong
$router->get('/sse/stream', '\App\Controllers\SSEController@stream');

// Bắt lỗi 404 Xong
$router->set404('\App\Controllers\Controller@sendNotFound');
$router->run();
