<?php

namespace Config;

$routes = Services::routes();

if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();

// Home
$routes->group('/', static function ($routes) {
    $routes->get('', 'Home::index');
    $routes->get('access-denied', 'Home::accessDenied');
});

$routes->group('login', static function ($routes) {
    $routes->get('', 'Auth\LoginController::index', ['as' => 'formLogin']);
    $routes->post('attempt-login', 'Auth\LoginController::attemptLogin', ['as' => 'attemptLogin']);
});
//$routes->get('register', 'AuthController::register');
//$routes->post('register', 'AuthController::attemptRegister');
//$routes->get('forgot', 'AuthController::forgotPassword');
//$routes->post('forgot', 'AuthController::attemptForgotPassword');
//$routes->get('reset-password', 'AuthController::resetPassword');
//$routes->post('reset-password', 'AuthController::attemptResetPassword');

// Admin
$routes->group('admin', ['filter' => 'role:admin'], static function ($routes) {
    $routes->get('/', 'Admin::index', ['as' => 'indexAdmin']);
});

// Event
$routes->group('event', ['filter' => 'role:admin'], static function ($routes) {
    $routes->post('save-event', 'Event::saveEvent', ['as' => 'saveEvent']);
    $routes->post('delete-event', 'Event::deleteEvent', ['as' => 'deleteEvent']);
});

// Event Date
$routes->group('event-date', ['filter' => 'role:admin'], static function ($routes) {
    $routes->post('save-event-date', 'Event::saveEventDate', ['as' => 'saveEventDate']);
    $routes->post('update-event-date', 'Event::updateEventDate', ['as' => 'updateEventDate']);
    $routes->post('delete-event-date', 'Event::deleteEventDate', ['as' => 'deleteEventDate']);
});

// cashier
$routes->group('cashier', ['filter' => 'role:cashier'], static function ($routes) {
    $routes->get('/', 'Cashier::index', ['as' => 'indexCashier']);

    // Menu, Order, Check Order, and Save Order
    $routes->post('detail', 'Cashier\Menu::detail', ['as' => 'detailCashier']);
    $routes->post('search-menu', 'Cashier\Menu::searchMenu', ['as' => 'searchMenuCashier']);
    $routes->post('get-menu', 'Cashier\Menu::getMenu', ['as' => 'getMenuCashier']);
    $routes->post('checking-order', 'Cashier\Order::checkOrder', ['as' => 'checkOrderCashier']);
    $routes->post('saving-order', 'Cashier\Order::saveOrder', ['as' => 'saveOrderCashier']);
    $routes->post('get-distribution', 'Cashier\Order::getDistribution', ['as' => 'getDistributionCashier']);

    // Print Pay Order
    $routes->post('printPemeriksa', 'cashier::printPemeriksa');
    $routes->post('printTagihan', 'cashier::printTagihan');
    $routes->post('pembayaranPesanan', 'cashier::pembayaranPesanan');
    $routes->get('printStruk/(:any)', 'cashier::printStruk/$1');

    //  Profile Cashier
    $routes->get('profile', 'Cashier\Profile::index', ['as' => 'profileCashier']);
    $routes->post('update-profile', 'Cashier\Profile::update', ['as' => 'updateProfileCashier']);

    //  Password Cashier
    $routes->get('password', 'Cashier\Passwords::changePassword', ['as' => 'changePasswordCashier']);
    $routes->post('update-password', 'Cashier\Passwords::updatePassword', ['as' => 'updatePasswordCashier']);
});

// Category
$routes->group('category', ['filter' => 'role:admin'], static function ($routes) {
    $routes->get('/', 'Category::index', ['as' => 'indexCategory']);
    $routes->get('create', 'Category::create', ['as' => 'createCategory']);
    $routes->post('save', 'Category::save', ['as' => 'saveCategory']);
    $routes->get('edit', 'Category::edit', ['as' => 'editCategory']);
    $routes->post('update', 'Category::update', ['as' => 'updateCategory']);
    $routes->post('delete', 'Category::delete', ['as' => 'deleteCategory']);
});

// Distribution
$routes->group('distribution', ['filter' => 'role:admin'], static function ($routes) {
    $routes->get('/', 'Distribution::index', ['as' => 'indexDistribution']);
    $routes->get('create', 'Distribution::create', ['as' => 'createDistribution']);
    $routes->post('save', 'Distribution::save', ['as' => 'saveDistribution']);
    $routes->get('edit', 'Distribution::edit', ['as' => 'editDistribution']);
    $routes->post('update', 'Distribution::update', ['as' => 'updateDistribution']);
    $routes->post('delete', 'Distribution::delete', ['as' => 'deleteDistribution']);
});

// Menu
$routes->group('menu', ['filter' => 'role:admin'], static function ($routes) {
    $routes->get('/', 'Menu::index', ['as' => 'indexMenu']);
    $routes->post('listData', 'Menu::listData', ['as' => 'listMenu']);
    $routes->get('create', 'Menu::create', ['as' => 'createMenu']);
    $routes->post('save', 'Menu::save', ['as' => 'saveMenu']);
    $routes->get('edit/(:num)', 'Menu::edit/$1', ['as' => 'editMenu']);
    $routes->post('update', 'Menu::update', ['as' => 'updateMenu']);
    $routes->post('delete', 'Menu::delete', ['as' => 'deleteMenu']);
    $routes->post('detail', 'Menu::detail', ['as' => 'detailMenu']);
});

// Employee
$routes->group('employee', ['filter' => 'role:admin'], static function ($routes) {
    $routes->get('/', 'Employee::index', ['as' => 'indexEmployee']);
    $routes->post('listData', 'Employee::listData', ['as' => 'listEmployee']);
    $routes->get('create', 'Employee::create', ['as' => 'createEmployee']);
    $routes->post('save', 'Employee::save', ['as' => 'saveEmployee']);
    $routes->get('edit/(:num)', 'Employee::edit/$1', ['as' => 'editEmployee']);
    $routes->post('update', 'Employee::update', ['as' => 'updateEmployee']);
    $routes->post('delete', 'Employee::delete', ['as' => 'deleteEmployee']);
    $routes->post('detail', 'Employee::detail', ['as' => 'detailEmployee']);
    $routes->post('toggle', 'Employee::toggle', ['as' => 'toggleEmployee']);
});

// Profile
$routes->group('profile', ['filter' => 'role:admin'], static function ($routes) {
    $routes->get('/', 'Profile::index', ['as' => 'indexProfile']);
    $routes->post('save', 'Profile::save', ['as' => 'saveProfile']);
    $routes->get('delete', 'Profile::delete', ['as' => 'deleteProfile']);
});

// User
$routes->group('user', ['filter' => 'role:admin'], static function ($routes) {
    $routes->get('/', 'User::index', ['as' => 'indexUser']);
    $routes->post('list-user', 'User::listData', ['as' => 'listUser']);
    $routes->get('create', 'User::create', ['as' => 'createUser']);
    $routes->post('save', 'User::save', ['as' => 'saveUser']);
    $routes->get('edit/(:num)', 'User::edit/$1', ['as' => 'editUser']);
    $routes->post('update', 'User::update', ['as' => 'updateUser']);
    $routes->post('delete', 'User::delete', ['as' => 'deleteUser']);
    $routes->post('getEmployee', 'User::getEmployee', ['as' => 'getEmployeeUser']);
    $routes->post('detail', 'User::detail', ['as' => 'detailUser']);
    $routes->post('reset-password', 'User::resetPassword', ['as' => 'resetPassword']);
    $routes->post('toggle', 'User::toggle', ['as' => 'toggleUser']);
});

// Role
$routes->group('role', ['filter' => 'role:admin'], static function ($routes) {
    $routes->get('/', 'Role::index', ['as' => 'indexRole']);
    $routes->get('create', 'Role::create', ['as' => 'createRole']);
    $routes->post('save', 'Role::save', ['as' => 'saveRole']);
    $routes->get('edit', 'Role::edit', ['as' => 'editRole']);
    $routes->post('update', 'Role::update', ['as' => 'updateRole']);
    $routes->post('delete', 'Role::delete', ['as' => 'deleteRole']);
    $routes->get('setting-permission/(:num)', 'Role::setPermission/$1', ['as' => 'setPermissionRole']);
    $routes->post('save-permission', 'Role::savePermission', ['as' => 'savePermissionRole']);
});

// Permission
$routes->group('permission', ['filter' => 'role:admin'], static function ($routes) {
    $routes->get('/', 'Permission::index', ['as' => 'indexPermission']);
    $routes->get('create', 'Permission::create', ['as' => 'createPermission']);
    $routes->post('save', 'Permission::save', ['as' => 'savePermission']);
    $routes->get('edit', 'Permission::edit', ['as' => 'editPermission']);
    $routes->post('update', 'Permission::update', ['as' => 'updatePermission']);
    $routes->post('delete', 'Permission::delete', ['as' => 'deletePermission']);
});

// Transaction
$routes->group('transaction', ['filter' => 'role:admin'], static function ($routes) {
    $routes->get('/', 'Transaction::index', ['as' => 'indexTransaction']);
    $routes->post('list-user', 'Transaction::listData', ['as' => 'listTransaction']);
    $routes->get('exportExcel/(:any)/(:any)', 'Transaction::exportExcel/$1/$2');
    $routes->get('printTransaction/(:any)/(:any)', 'Transaction::printTransaction/$1/$2');
    $routes->post('detail', 'Transaction::detail');
});

// Report
$routes->group('report', ['filter' => 'role:admin'], static function ($routes) {
    $routes->get('', 'Report::index', ['as' => 'indexReport']);
    $routes->get('transaction', 'Report::Transaction', ['as' => 'reportTransaction']);
    $routes->post('get-transaction-date', 'Report::getTransactionDate', ['as' => 'getTransactionDate']);
    $routes->get('report-print-transaction/(:any)/(:any)', 'Report::printTransaction/$1/$2', ['as' => 'reportPrintTransaction']);
    $routes->get('report-excel-transaction/(:any)/(:any)', 'Report::excelTransaction/$1/$2', ['as' => 'reportExcelTransaction']);
});


/* API */

// Category
$routes->resource('api/category', ['controller' => 'Api\CategoryApi']);
$routes->post('/api/category/(:segment)', 'Api\CategoryApi::update/$1');
// Distribution
$routes->resource('api/distribution', ['controller' => 'Api\DistributionApi']);
$routes->post('/api/distribution/(:segment)', 'Api\DistributionApi::update/$1');
// Menu
$routes->resource('api/menu', ['controller' => 'Api\MenuApi']);
$routes->post('/api/menu/(:segment)', 'Api\MenuApi::update/$1');
// Employee
$routes->resource('api/employee', ['controller' => 'Api\EmployeeApi']);
$routes->post('/api/employee/(:segment)', 'Api\EmployeeApi::update/$1');

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
