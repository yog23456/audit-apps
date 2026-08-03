<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| DEFAULT & CONFIG ROUTES
| -------------------------------------------------------------------------
*/
$route['default_controller']   = 'auth';
$route['404_override']         = '';
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