<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * @var stdClass|array $user  <-- TAMBAHKAN BARIS INI (Membuat IDE paham variabel $user)
 * @var stdClass|array $summary  <-- TAMBAHKAN BARIS INI (Membuat IDE paham variabel $summary)
 * @property CI_Session $session
 * @property CI_Input $input
 * @property CI_Form_validation $form_validation
 * @property CI_Upload $upload
 */
?>



<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Audit - System</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .card-stat {
            border: none;
            border-radius: 10px;
        }

        .progress-bar-custom {
            height: 8px;
            border-radius: 4px;
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
        <div class="container-fluid px-4">
            <a class="navbar-brand fw-bold" href="#"><i class="fa-solid fa-shield-halved me-2"></i>Audit System</a>
            <div class="d-flex align-items-center text-white ms-auto">
                <div class="me-3 text-end">
                    <span class="d-block fw-semibold"><?= html_escape($user['name']); ?></span>
                    <small class="text-white-50"><?= strtoupper(html_escape($user['role_name'])); ?></small>
                </div>
                <a href="<?= site_url('auth/logout'); ?>" class="btn btn-outline-light btn-sm ms-2">
                    <i class="fa-solid fa-right-from-bracket me-1"></i> Logout
                </a>
            </div>
        </div>
    </nav>

    <div class="container-fluid px-4 py-4">

        <!-- Title / Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="fw-bold mb-0">Dashboard Monitoring</h3>
                <p class="text-muted small">Ringkasan status dan aktivitas pengawasan audit terkini.</p>
            </div>
            <a href="<?= site_url('audit/create'); ?>" class="btn btn-primary">
                <i class="fa-solid fa-plus me-1"></i> Tambah Case Baru
            </a>
        </div>

        <!-- 1. KPI Summary Cards -->
        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="card card-stat shadow-sm border-start border-4 border-primary p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-muted small d-block">TOTAL KASUS</span>
                            <h3 class="fw-bold my-1"><?= number_format($summary['total_case']); ?></h3>
                            <small class="text-primary"><i class="fa-solid fa-folder me-1"></i>Semua Data Audit</small>
                        </div>
                        <div class="bg-primary-subtle text-primary p-3 rounded-circle">
                            <i class="fa-solid fa-briefcase fa-lg"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card card-stat shadow-sm border-start border-4 border-warning p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-muted small d-block">DALAM PROSES</span>
                            <h3 class="fw-bold my-1"><?= number_format($summary['in_progress']); ?></h3>
                            <small class="text-warning"><i class="fa-solid fa-spinner me-1"></i>Stage 1 - 4</small>
                        </div>
                        <div class="bg-warning-subtle text-warning p-3 rounded-circle">
                            <i class="fa-solid fa-clock-rotate-left fa-lg"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card card-stat shadow-sm border-start border-4 border-success p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-muted small d-block">SELESAI (TERBIT BA)</span>
                            <h3 class="fw-bold my-1"><?= number_format($summary['completed']); ?></h3>
                            <small class="text-success"><i class="fa-solid fa-circle-check me-1"></i>Stage 5 Final</small>
                        </div>
                        <div class="bg-success-subtle text-success p-3 rounded-circle">
                            <i class="fa-solid fa-file-signature fa-lg"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card card-stat shadow-sm border-start border-4 border-info p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-muted small d-block">TOTAL NILAI AUDIT</span>
                            <h3 class="fw-bold my-1">Rp <?= number_format($summary['total_nilai'], 0, ',', '.'); ?></h3>
                            <small class="text-info"><i class="fa-solid fa-rupiah-sign me-1"></i>Akumulasi Nilai</small>
                        </div>
                        <div class="bg-info-subtle text-info p-3 rounded-circle">
                            <i class="fa-solid fa-wallet fa-lg"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <!-- 2. Breakdown Cases per Stage -->
            <div class="col-lg-5">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white py-3 border-bottom-0">
                        <h5 class="fw-bold mb-0"><i class="fa-solid fa-layer-group me-2 text-primary"></i>Distribusi per Stage</h5>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($stage_stats)): ?>
                            <?php foreach ($stage_stats as $stage): ?>
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <span class="fw-medium text-dark">
                                            <?= html_escape($stage['stage_name']); ?>
                                        </span>
                                        <span class="badge bg-light text-dark border">
                                            <?= $stage['total_case']; ?> Case
                                        </span>
                                    </div>
                                    <div class="progress progress-bar-custom">
                                        <div class="progress-bar bg-primary"
                                            role="progressbar"
                                            style="width: <?= $stage['progress_value']; ?>%"
                                            aria-valuenow="<?= $stage['progress_value']; ?>"
                                            aria-valuemin="0"
                                            aria-valuemax="100"></div>
                                    </div>
                                    <small class="text-muted">Target Progress: <?= $stage['progress_value']; ?>%</small>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p class="text-muted text-center py-3">Belum ada data stage.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- 3. Recent Cases Table -->
            <div class="col-lg-7">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white py-3 border-bottom-0 d-flex justify-content-between align-items-center">
                        <h5 class="fw-bold mb-0"><i class="fa-solid fa-list-check me-2 text-primary"></i>Audit Terbaru</h5>
                        <a href="<?= site_url('audit'); ?>" class="btn btn-sm btn-link text-decoration-none">Lihat Semua</a>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-3">No Invoice</th>
                                        <th>Project</th>
                                        <th>Nilai</th>
                                        <th>Stage</th>
                                        <th class="text-end pe-3">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($recent_audits)): ?>
                                        <?php foreach ($recent_audits as $audit): ?>
                                            <tr>
                                                <td class="ps-3 fw-bold text-secondary">
                                                    <?= html_escape($audit['no_invoice']); ?>
                                                </td>
                                                <td>
                                                    <span class="d-block fw-semibold text-dark">
                                                        <?= html_escape($audit['project_name']); ?>
                                                    </span>
                                                    <small class="text-muted"><?= html_escape($audit['kategori']); ?></small>
                                                </td>
                                                <td>Rp <?= number_format($audit['nilai'], 0, ',', '.'); ?></td>
                                                <td>
                                                    <span class="badge rounded-pill bg-info-subtle text-info-emphasis border border-info-subtle">
                                                        <?= html_escape($audit['stage_name']); ?> (<?= $audit['progress_value']; ?>%)
                                                    </span>
                                                </td>
                                                <td class="text-end pe-3">
                                                    <a href="<?= site_url('audit/detail/' . $audit['id']); ?>"
                                                        class="btn btn-sm btn-light border"
                                                        title="Detail Audit">
                                                        <i class="fa-solid fa-eye text-secondary"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="5" class="text-center py-4 text-muted">Belum ada data kasus audit.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>