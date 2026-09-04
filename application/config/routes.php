<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/userguide3/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'dashboard';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'auth';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['dashboard']                 = 'dashboard/index';
$route['dashboard/filter']          = 'dashboard/filter_ajax';
$route['dashboard/case/store']      = 'dashboard/store_case_manual';
$route['dashboard/case/update']     = 'dashboard/update_case';



/*
| -------------------------------------------------------------------------
| AUTHENTICATION ROUTES
| -------------------------------------------------------------------------
*/
$route['login']         = 'auth/index';
$route['login/process'] = 'auth/process_login';
$route['logout']        = 'auth/logout';

/*
| -------------------------------------------------------------------------
| DASHBOARD ROUTES
| -------------------------------------------------------------------------
*/
$route['api/dashboard/stats']   = 'dashboard/get_stats_json';

/*
| -------------------------------------------------------------------------
| AUDIT CRUD & VIEWS ROUTES
| -------------------------------------------------------------------------
*/
$route['audit']                = 'audit/index';          // Halaman Tabel Utama Audit
$route['audit/create']         = 'audit/create';         // Halaman Form Tambah Audit
$route['audit/store']          = 'audit/store';          // POST: Simpan Audit Baru
$route['audit/detail/(:num)']  = 'audit/detail/$1';      // Halaman Detail Audit & Stage Workflow

/*
| -------------------------------------------------------------------------
| AUDIT STAGE WORKFLOW ROUTES (FORM SUBMISSIONS)
| -------------------------------------------------------------------------
*/
$route['audit/submit_telaah']       = 'audit/submit_telaah';       // Stage 1 -> 2
$route['audit/submit_investigasi']  = 'audit/submit_investigasi';  // Stage 2 -> 3
$route['audit/submit_auditee']      = 'audit/submit_auditee';      // Stage 3 -> 4
$route['audit/submit_review_spv']   = 'audit/submit_review_spv';   // Stage 4 -> 5 / 2
$route['audit/submit_review_head']  = 'audit/submit_review_head';  // Stage 5 -> 6 / 4
$route['audit/submit_berita_acara'] = 'audit/submit_berita_acara'; // Stage 6
$route['audit/submit_feedback']     = 'audit/submit_feedback';     // Stage 7 (Feedback -> Closed)
