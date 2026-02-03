<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Redirect root to login or dashboard
$routes->get('/', 'Dashboard::index', ['filter' => 'auth']);

// Auth routes
$routes->group('auth', ['filter' => 'guest'], function ($routes) {
    $routes->get('login', 'Auth::login');
    $routes->post('login', 'Auth::login');
});
$routes->get('auth/logout', 'Auth::logout');

// Protected routes
$routes->group('', ['filter' => 'auth'], function ($routes) {
    // Dashboard
    $routes->get('dashboard', 'Dashboard::index');

    // Categories
    $routes->get('category', 'Category::index');
    $routes->get('category/create', 'Category::create');
    $routes->post('category/store', 'Category::store');
    $routes->get('category/edit/(:num)', 'Category::edit/$1');
    $routes->post('category/update/(:num)', 'Category::update/$1');
    $routes->get('category/delete/(:num)', 'Category::delete/$1');

    // Products
    $routes->get('product', 'Product::index');
    $routes->get('product/create', 'Product::create');
    $routes->post('product/store', 'Product::store');
    $routes->get('product/edit/(:num)', 'Product::edit/$1');
    $routes->post('product/update/(:num)', 'Product::update/$1');
    $routes->get('product/delete/(:num)', 'Product::delete/$1');
    $routes->get('product/search', 'Product::search');
    $routes->get('product/low-stock', 'Product::lowStock');

    // Suppliers
    $routes->get('supplier', 'Supplier::index');
    $routes->get('supplier/create', 'Supplier::create');
    $routes->post('supplier/store', 'Supplier::store');
    $routes->get('supplier/edit/(:num)', 'Supplier::edit/$1');
    $routes->post('supplier/update/(:num)', 'Supplier::update/$1');
    $routes->get('supplier/delete/(:num)', 'Supplier::delete/$1');

    // Customers
    $routes->get('customer', 'Customer::index');
    $routes->get('customer/create', 'Customer::create');
    $routes->post('customer/store', 'Customer::store');
    $routes->get('customer/edit/(:num)', 'Customer::edit/$1');
    $routes->post('customer/update/(:num)', 'Customer::update/$1');
    $routes->get('customer/delete/(:num)', 'Customer::delete/$1');
    $routes->get('customer/search', 'Customer::search');
    $routes->get('customer/show/(:num)', 'Customer::show/$1');

    // Stock Management
    $routes->get('stock', 'Stock::index');
    $routes->get('stock/in', 'Stock::stockIn');
    $routes->post('stock/in', 'Stock::processStockIn');
    $routes->get('stock/out', 'Stock::stockOut');
    $routes->post('stock/out', 'Stock::processStockOut');
    $routes->get('stock/adjustment', 'Stock::adjustment');
    $routes->post('stock/adjustment', 'Stock::processAdjustment');

    // POS
    $routes->get('pos', 'Pos::index');
    $routes->get('pos/search-product', 'Pos::searchProduct');
    $routes->get('pos/search-customer', 'Pos::searchCustomer');
    $routes->get('pos/product/(:num)', 'Pos::getProduct/$1');
    $routes->post('pos/process', 'Pos::processTransaction');
    $routes->post('pos/add-customer', 'Pos::addCustomer');

    // Transactions
    $routes->get('transaction', 'Transaction::index');
    $routes->get('transaction/show/(:num)', 'Transaction::show/$1');
    $routes->get('transaction/print/(:num)', 'Transaction::print/$1');
    $routes->get('transaction/cancel/(:num)', 'Transaction::cancel/$1');

    // Reports
    $routes->get('report/sales', 'Report::sales');
    $routes->get('report/stock', 'Report::stock');
    $routes->get('report/best-selling', 'Report::bestSelling');
    $routes->get('report/export/sales-pdf', 'Report::exportSalesPdf');
    $routes->get('report/export/stock-excel', 'Report::exportStockExcel');
});
