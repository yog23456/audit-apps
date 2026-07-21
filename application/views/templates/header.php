<?php
defined('BASEPATH') or exit('No direct script access allowed');
$user_name = $this->session->userdata('name') ?? 'Guest';
$user_role = $this->session->userdata('role_name') ?? '';
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? $title : 'Audit System'; ?></title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .navbar-brand {
            font-size: 1.4rem;
        }

        .progress-bar-custom {
            height: 10px;
            border-radius: 5px;
        }

        .card-custom {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm mb-4">
        <div class="container-fluid px-4">
            <a class="navbar-brand fw-bold" href="<?= site_url('dashboard'); ?>">
                <i class="fa-solid fa-shield-halved me-2"></i>Audit System
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link <?= (uri_string() == 'dashboard' || uri_string() == '') ? 'active' : ''; ?>" href="<?= site_url('dashboard'); ?>">
                            <i class="fa-solid fa-chart-line me-1"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= (strpos(uri_string(), 'audit') !== false) ? 'active' : ''; ?>" href="<?= site_url('audit'); ?>">
                            <i class="fa-solid fa-file-invoice me-1"></i> Audit Cases
                        </a>
                    </li>
                </ul>
                <div class="d-flex align-items-center text-white">
                    <div class="me-3 text-end">
                        <span class="d-block fw-semibold"><?= html_escape($user_name); ?></span>
                        <small class="text-white-50"><?= strtoupper(html_escape($user_role)); ?></small>
                    </div>
                    <a href="<?= site_url('auth/logout'); ?>" class="btn btn-outline-light btn-sm ms-2">
                        <i class="fa-solid fa-right-from-bracket me-1"></i> Logout
                    </a>
                </div>
            </div>
        </div>
    </nav>