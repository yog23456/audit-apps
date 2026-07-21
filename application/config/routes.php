<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| DEFAULT & CONFIG ROUTES
| -------------------------------------------------------------------------
*/
$route['default_controller']   = 'auth';
$route['404_override']        = '';
$route['translate_uri_dashes'] = FALSE;

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
$route['dashboard']             = 'dashboard/index';
$route['api/dashboard/stats']   = 'dashboard/get_stats_json';

/*
| -------------------------------------------------------------------------
| WEB AUDIT ROUTES (Tampilan Halaman/HTML)
| -------------------------------------------------------------------------
*/
$route['audit']                = 'audit/index';          // Halaman Tabel Utama Audit
$route['audit/create']         = 'audit/form_create';    // Halaman Form Tambah Audit (Ubah method ke form_create)
$route['audit/detail/(:num)']  = 'audit/view_detail/$1'; // Halaman View Detail Audit & Stage Workflow

/*
| -------------------------------------------------------------------------
| API / FORM SUBMISSION ROUTES (Mengolah Data / JSON Response)
| -------------------------------------------------------------------------
*/
$route['api/audit']                       = 'audit/create';                 // POST: Simpan Audit Baru
$route['api/audit/(:num)']                = 'audit/detail/$1';              // GET: Detail JSON Data
$route['api/audit/investigasi/(:num)']    = 'audit/upload_investigasi/$1'; // POST: Upload Investigasi
$route['api/audit/auditee/(:num)']        = 'audit/upload_auditee/$1';     // POST: Upload Auditee
$route['api/audit/review/(:num)']         = 'audit/review_berita_acara/$1';// POST: Review SPV / Head Audit