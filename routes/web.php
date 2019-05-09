<?php

use App\Http\Controllers\MaterialController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/* Route::get('/', function () {
    return view('welcome');
}); */

Auth::routes();
Route::group(['middleware' => ['web']], function () {

});

Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/profile', 'ProfileController@index');
Route::post('/ldaplogin', 'LDAPController@login');
Route::post('/ldaplogout', 'LDAPController@logout');

/* DASHBOARD */
Route::post('/search', 'HomeController@search');

/* CART */ 
Route::get('/cart', 'CartController@index')->name('cart');
Route::post('/checkout', 'CartController@checkout')->name('checkout');
Route::get('/myorder/on-progress', 'CartController@onprogress')->name('myorder/on-progress');
Route::get('/cart/add/{id}', 'CartController@add');
Route::post('/plusmindata/{no_material}/{no_id}/{action}', 'CartController@plusmindata')->name('/plusmindata/{no_material}/{no_id}/{action}');
Route::post('/create_order', 'CartController@create_order')->name('create_order');
Route::get('/cart/show/{id}', 'CartController@show')->name('/cart/show/{id}');
Route::post('/cart/delete', 'CartController@remove')->name('/cart/delete');

/* MATERIAL SET */
Route::resource('/setmaterial', 'SetMaterialController');
Route::post('/setmaterial/post', 'SetMaterialController@store');
Route::get('/setmaterial/edit/', 'SetMaterialController@show');
Route::post('/setmaterial/inactive', 'SetMaterialController@inactive');
Route::post('/setmaterial/active', 'SetMaterialController@active');
Route::get('grid-setmaterial', ['as' => 'get.setmaterial_grid', 'uses' => 'SetMaterialController@dataGrid']);
Route::get('get-api-group-material', ['as' => 'get.get_group_material', 'uses' => 'SetMaterialController@get_material_group']);

/* MATERIAL */
Route::resource('materials', 'MaterialController');
Route::post('/materials/post', 'MaterialController@store');
Route::get('/materials/edit/', 'MaterialController@show');
Route::post('/materials/inactive', 'MaterialController@inactive');
Route::post('/materials/active', 'MaterialController@active');
Route::get('data-table-material', ['as' => 'get.material', 'uses' => 'MaterialController@getData']);
Route::get('sap_group_material', ['as' => 'get.sap_group_material', 'uses' => 'MaterialController@sap_group_material']);
Route::get('data-table-group-material', ['as' => 'get.data_table_group_material', 'uses' => 'MaterialController@groupMaterialGroup']);

/* MASTER MATERIAL */
Route::resource('mastermaterial', 'MasterMaterialController');
/* Route::post('mastermaterial/post', 'MasterMaterialController@store');
Route::get('mastermaterial/edit', 'MasterMaterialController@show'); */
//Route::get('get-mastermaterial_grid', ['as' => 'get.mastermaterial_grid', 'uses' => 'MasterMaterialController@get_material_user_grid']);
Route::match(['get', 'post'], 'mastermaterial_grid', [
    'as' => 'mastermaterial.grid',
    'uses' => 'MasterMaterialController@get_material_user_grid'
]);


/* Route::post('/mastermaterial/grid', 'MasterMaterialController@get_material_user_grid'); */
Route::get('get-mastermaterial_grid_search', ['as' => 'get.mastermaterial_grid_search', 'uses' => 'MasterMaterialController@get_material_user_grid_search']);


/* MATERIAL REQUEST */
Route::resource( 'materialrequest', 'MaterialRequestController');
//Route::resource( 'materialrequest', 'MaterialRequestController@search');
Route::get('/material_extend/{id}', 'MaterialRequestController@extend')->name('extend');
Route::get('/materialrequest/show', 'MaterialController@show');
Route::get( 'get-editmaterialrequest', ['as' => 'get.editmaterialrequest', 'uses' => 'EditMaterialRequestController@get_editmaterial']);
Route::get( 'get-editmaterialrequestfiles', ['as' => 'get.editmaterialrequestfiles', 'uses' => 'EditMaterialRequestController@get_files']);


//Route::get('/materialrequest/search', 'MaterialController@search');
Route::post('/materialrequest/post', 'MaterialRequestController@store');
Route::put('/materialrequest/store_location/{id}', 'MaterialRequestController@store_location');
Route::get('/materialrequest/getimage/', 'MaterialRequestController@get_image');
Route::get('get-image-detail', ['as' => 'get.get_image_detail', 'uses' => 'MaterialRequestController@get_image']);
Route::get('material-user-detail', ['as' => 'get.material_user_detail', 'uses' => 'MaterialRequestController@detail']);

Route::get('group-material-list', ['as' => 'get.group_material_list', 'uses' => 'MaterialRequestController@groupMaterialGroup']);
Route::get('get-uom', ['as' => 'get.uom', 'uses' => 'MaterialRequestController@get_uom']);
Route::get('get-plant', ['as' => 'get.plant', 'uses' => 'MaterialRequestController@get_plant']);
Route::get('get-div', ['as' => 'get.div', 'uses' => 'MaterialRequestController@get_div']);
Route::get('get-location', ['as' => 'get.location', 'uses' => 'MaterialRequestController@get_location']);
Route::get('get-mrp_controller', ['as' => 'get.mrp_controller', 'uses' => 'MaterialRequestController@get_mrp_controller']);
Route::get('get-valuation_class', ['as' => 'get.valuation_class', 'uses' => 'MaterialRequestController@get_valuation_class']);
Route::get('get-industry_sector', ['as' => 'get.industry_sector', 'uses' => 'MaterialRequestController@get_industry_sector']);
Route::get('get-material_type', ['as' => 'get.material_type', 'uses' => 'MaterialRequestController@get_material_type']);
Route::get('get-sales_org', ['as' => 'get.sales_org', 'uses' => 'MaterialRequestController@get_sales_org']);
Route::get('get-dist_channel', ['as' => 'get.dist_channel', 'uses' => 'MaterialRequestController@get_dist_channel']);
Route::get('get-item_cat', ['as' => 'get.item_cat', 'uses' => 'MaterialRequestController@get_item_cat']);
Route::get('get-tax_classification', ['as' => 'get.tax_classification', 'uses' => 'MaterialRequestController@get_tax_classification']);
Route::get('get-account_assign', ['as' => 'get.account_assign', 'uses' => 'MaterialRequestController@get_account_assign']);
Route::get('get-availability_check', ['as' => 'get.availability_check', 'uses' => 'MaterialRequestController@get_availability_check']);
Route::get('get-transportation_group', ['as' => 'get.transportation_group', 'uses' => 'MaterialRequestController@get_transportation_group']);
Route::get('get-loading_group', ['as' => 'get.loading_group', 'uses' => 'MaterialRequestController@get_loading_group']);
Route::get('get-profit_center', ['as' => 'get.profit_center', 'uses' => 'MaterialRequestController@get_profit_center']);
Route::get('get-mrp_type', ['as' => 'get.mrp_type', 'uses' => 'MaterialRequestController@get_mrp_type']);
Route::get('get-material_user_grid', ['as' => 'get.material_user_grid', 'uses' => 'MaterialRequestController@get_material_user_grid']);
Route::get('get-material_user_grid_search', ['as' => 'get.material_user_grid_search', 'uses' => 'MaterialRequestController@get_material_user_grid_search']);
Route::get('get-tm_material', ['as' => 'get.tm_material', 'uses' => 'MaterialRequestController@get_tm_materials']);
Route::get('get-tr_material', ['as' => 'get.tr_material', 'uses' => 'MaterialRequestController@get_tr_materials']);
Route::get('get-sle', ['as' => 'get.sle', 'uses' => 'MaterialRequestController@get_sle']);
Route::get('get-auto_sugest', ['as' => 'get.auto_sugest', 'uses' => 'MaterialRequestController@get_auto_sugest']);

/* MATERIAL USER EDIT */
Route::resource('/editmaterialrequest', 'EditMaterialRequestController');
Route::post( '/editmaterialrequest/post', 'EditMaterialRequestController@store');
Route::get('editmaterialrequest_auto_sugest', 'EditMaterialRequestController@auto_sugest');
Route::get('get-editmaterialrequest_auto_sugest', ['as' => 'get.editmaterialrequest_auto_sugest', 'uses' => 'EditMaterialRequestController@auto_sugest']);
Route::get( 'get-editmaterialrequest_grid', ['as' => 'get.editmaterialrequest_grid', 'uses' => 'EditMaterialRequestController@grid']);


Route::resource('/editmaterial', 'EditMaterialController');
Route::post('/editmaterial/post', 'EditMaterialController@store');
Route::get('/editmaterial/edit/', 'EditMaterialController@show');
Route::get('/editmaterial_grid/{id}', 'EditMaterialController@grid')->name('search');
Route::get('editmaterial_auto_sugest', 'EditMaterialController@auto_sugest');
Route::get( 'get-editmaterialfiles', ['as' => 'get.editmaterialfiles', 'uses' => 'EditMaterialController@get_files']);



/* USER SETTINGS */
Route::resource('/users', 'UsersController');
Route::post('/users/post', 'UsersController@store');
Route::get('/users/edit/', 'UsersController@show');
Route::post('/users/inactive', 'UsersController@inactive');
Route::post('/users/active', 'UsersController@active');
Route::get('grid-tr-user', ['as' => 'get.grid_tr_user', 'uses' => 'UsersController@dataGrid']);

Route::resource('/roles', 'RolesController');
Route::post('/roles/post', 'RolesController@store');
Route::get('/roles/edit/', 'RolesController@show');
Route::post('/roles/inactive', 'RolesController@inactive');
Route::post('/roles/active', 'RolesController@active');
Route::get('grid-tm-role', ['as' => 'get.grid_tm_role', 'uses' => 'RolesController@dataGrid']);


Route::resource('/roleusers', 'RoleUserController');
Route::post('/roleusers/post', 'RoleUserController@store');
Route::get('/roleusers/edit/', 'RoleUserController@show');
Route::post('/roleusers/inactive', 'RoleUserController@inactive');
Route::post('/roleusers/active', 'RoleUserController@active');
Route::get('grid-role-user', ['as' => 'get.role_user', 'uses' => 'RoleUserController@dataGrid']);
Route::get('get-select_tr_user', ['as' => 'get.select_tr_user', 'uses' => 'RoleUserController@get_tr_user']);
Route::get('get-select_role', ['as' => 'get.select_role', 'uses' => 'RoleUserController@get_role']);

Route::resource('/menu', 'MenuController');
Route::post('/menu/post', 'MenuController@store');
Route::get('/menu/edit/', 'MenuController@show');
Route::post('/menu/inactive', 'MenuController@inactive');
Route::post('/menu/active', 'MenuController@active');
Route::get('grid-menu', ['as' => 'get.menu_grid', 'uses' => 'MenuController@dataGrid']);

Route::resource('/mappingmatgroup', 'MappingMaterialGroupController');
Route::post( '/mappingmatgroup/post', 'MappingMaterialGroupController@store');
Route::get( '/mappingmatgroup/edit/', 'MappingMaterialGroupController@show');
Route::post( '/mappingmatgroup/inactive', 'MappingMaterialGroupController@inactive');
Route::get( 'grid-mappingmatgroup', ['as' => 'get.mappingmatgroup_grid', 'uses' => 'MappingMaterialGroupController@dataGrid']);

Route::resource('/mappingmrp', 'MappingMRPController');
Route::post( '/mappingmrp/post', 'MappingMRPController@store');
Route::get( '/mappingmrp/edit/', 'MappingMRPController@show');
Route::post( '/mappingmrp/inactive', 'MappingMRPController@inactive');
Route::get( 'grid-mappingmrp', ['as' => 'get.mappingmrp_grid', 'uses' => 'MappingMRPController@dataGrid']);

Route::resource('/mappingplant', 'MappingPlantController');
Route::post( '/mappingplant/post', 'MappingPlantController@store');
Route::get( '/mappingplant/edit/', 'MappingPlantController@show');
Route::post( '/mappingplant/inactive', 'MappingPlantController@inactive');
Route::get( 'grid-mappingplant', ['as' => 'get.mappingplant_grid', 'uses' => 'MappingPlantController@dataGrid']);

Route::resource('/outstanding', 'OutstandingController');
Route::post('/outstanding/post', 'OutstandingController@store');
Route::get('/outstanding/edit/', 'OutstandingController@show');
Route::post('/outstanding/inactive', 'OutstandingController@inactive');
Route::get('grid-outstanding', ['as' => 'get.outstanding_grid', 'uses' => 'OutstandingController@dataGrid']);

Route::resource('/verifikasi', 'VerifikasiController');
Route::post('/verifikasi/post', 'VerifikasiController@store');
Route::get('/verifikasi/edit/', 'VerifikasiController@show');
Route::post('/verifikasi/inactive', 'VerifikasiController@inactive');
Route::get('grid-verifikasi', ['as' => 'get.verifikasi_grid', 'uses' => 'VerifikasiController@dataGrid']);

Route::resource('/matrixapproval', 'MatrixApprovalController');
Route::post( '/matrixapproval/post', 'MatrixApprovalController@store');
Route::get( '/matrixapproval/edit/', 'MatrixApprovalController@show');
Route::post( '/matrixapproval/inactive', 'MatrixApprovalController@inactive');
Route::get( 'grid-matrixapproval', ['as' => 'get.matrixapproval_grid', 'uses' => 'MatrixApprovalController@dataGrid']);

Route::resource('/accessright', 'AccessRightController');
Route::post('/accessright/post', 'AccessRightController@store');
Route::get('/accessright/edit/', 'AccessRightController@show');
Route::post('/accessright/inactive', 'AccessRightController@inactive');
Route::post('/accessright/active', 'AccessRightController@active');
Route::get('grid-accessright', ['as' => 'get.accessright_grid', 'uses' => 'AccessRightController@dataGrid']);
Route::get('get-select_menu', ['as' => 'get.select_menu', 'uses' => 'AccessRightController@get_menu']);

Route::resource('/roleaccess', 'RoleAccessController');

//Route::get('select2list', ['as' => 'get.select2', 'uses' => 'Select2Controller@select2']);
Route::get('/select2', 'Select2Controller@get')->name('data');
Route::resource('/sap', 'SAPController');
Route::get('syncsap', ['as' => 'sap.sync', 'uses' => 'SAPController@sync']);
