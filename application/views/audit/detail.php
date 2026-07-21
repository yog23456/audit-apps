<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @var stdClass|array $audit  <-- TAMBAHKAN BARIS INI (Membuat IDE paham variabel $audit)
 * @property CI_Session $session
 * @property CI_Input $input
 * @property CI_Form_validation $form_validation
 * @property CI_Upload $upload
 */
?>

<div class="container mt-4">
    <h2>Detail Audit: <?= $audit->no_invoice; ?></h2>
    <p><strong>Project:</strong> <?= $audit->project_name; ?></p>
    <p><strong>Stage Saat Ini:</strong> <span class="badge bg-info"><?= $audit->nama_stage; ?></span></p>
    <p><strong>Progress Total:</strong> <?= $audit->progress; ?>%</p>

    <hr>

    <!-- FORM DYNAMIC BERDASARKAN ROLE & STAGE -->
    
    <!-- 1. Akses Auditor pada Stage 1 (Telaah) -->
    <?php if ($audit->id_stage == 1 && $this->session->userdata('role_name') == 'auditor'): ?>
        <div class="card p-3">
            <h4>Upload Berkas Telaah</h4>
            <?= form_open_multipart('audit/submit_telaah'); ?>
                <input type="hidden" name="id_audit" value="<?= $audit->id_audit; ?>">
                
                <div class="mb-3">
                    <label>File Dokumen Telaah (PDF/DOCX)</label>
                    <input type="file" name="file_telaah" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Catatan Auditor</label>
                    <textarea name="catatan" class="form-control" rows="3"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Submit & Lanjut Stage</button>
            <?= form_close(); ?>
        </div>
    <?php endif; ?>

    <!-- 2. Akses SPV Audit pada Stage Review SPV (Misal Stage ID 4) -->
    <?php if ($audit->id_stage == 4 && $this->session->userdata('role_name') == 'spv_audit'): ?>
        <div class="card p-3">
            <h4>Persetujuan Supervisor</h4>
            <?= form_open('audit/submit_review_spv'); ?>
                <input type="hidden" name="id_audit" value="<?= $audit->id_audit; ?>">
                
                <div class="mb-3">
                    <label>Keputusan</label>
                    <select name="keputusan" class="form-control" required>
                        <option value="approved">Approve (Lanjut Stage)</option>
                        <option value="rejected">Reject (Minta Revisi)</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label>Catatan Reviewer</label>
                    <textarea name="catatan" class="form-control" rows="3" required></textarea>
                </div>
                <button type="submit" class="btn btn-success">Simpan Keputusan</button>
            <?= form_close(); ?>
        </div>
    <?php endif; ?>

</div>