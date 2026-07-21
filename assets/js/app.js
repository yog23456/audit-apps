document.addEventListener('DOMContentLoaded', function () {

    // ---------- Modal: Case Manual ----------
    var modal = document.getElementById('modalCaseManual');
    var openBtn = document.getElementById('btnCaseManual');
    var closeBtn = document.getElementById('modalCloseBtn');
    var resetBtn = document.getElementById('modalResetBtn');
    var formCaseManual = document.getElementById('formCaseManual');

    function openModal() {
        if (modal) {
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }
    }

    function closeModal() {
        if (modal) {
            modal.classList.add('hidden');
            document.body.style.overflow = '';
        }
    }

    if (openBtn) openBtn.addEventListener('click', openModal);
    if (closeBtn) closeBtn.addEventListener('click', closeModal);
    if (resetBtn) {
        resetBtn.addEventListener('click', function () {
            if (formCaseManual) formCaseManual.reset();
            var deadlineText = document.getElementById('deadlineText');
            if (deadlineText) deadlineText.textContent = 'Deadline';
        });
    }

    if (modal) {
        modal.addEventListener('click', function (e) {
            if (e.target === modal) closeModal();
        });
    }

    // ---------- Simulasi Cepat Quick Fill ----------
    var quickSimBtns = document.querySelectorAll('.btn-quick-sim');
    quickSimBtns.forEach(function (btn) {
        btn.addEventListener('click', function () {
            var type = btn.getAttribute('data-type');
            var judulInput = document.getElementById('inputJudulCase');
            var deskripsiInput = document.getElementById('inputDeskripsi');
            var selectSumber = document.getElementById('selectSumber');
            var inputKategori = document.getElementById('inputKategori');
            var selectProyek = document.getElementById('selectProyek');

            if (type === 'whistleblower') {
                if (judulInput) judulInput.value = 'Laporan Anomali Keuangan Whistleblower';
                if (deskripsiInput) deskripsiInput.value = 'Temuan laporan anonim indikasi transaksi tidak wajar pada unit operasional.';
                if (selectSumber) selectSumber.value = 'Whistleblower System';
                if (inputKategori) inputKategori.value = 'Anomali Keuangan';
                if (selectProyek) selectProyek.value = 'Arjawinangun 1 T3';
            } else if (type === 'sop') {
                if (judulInput) judulInput.value = 'Ketidaksesuaian SOP Operasional Audit';
                if (deskripsiInput) deskripsiInput.value = 'Hasil pengujian verifikasi lapangan menunjukkan potensi penyimpangan alur penerimaan barang.';
                if (selectSumber) selectSumber.value = 'Audit SOP Internal';
                if (inputKategori) inputKategori.value = 'Kepatuhan SOP';
                if (selectProyek) selectProyek.value = 'RN Ningrat';
            } else if (type === 'request') {
                if (judulInput) judulInput.value = 'Permintaan Audit Khusus Direksi';
                if (deskripsiInput) deskripsiInput.value = 'Instruksi telaah khusus atas rekapitulasi nilai transaksi proyek tahun berjalan.';
                if (selectSumber) selectSumber.value = 'Request Divisi Direksi';
                if (inputKategori) inputKategori.value = 'Audit Khusus';
                if (selectProyek) selectProyek.value = 'Arjawinangun By Pass';
            }
        });
    });

    // ---------- Deadline Date Picker Display ----------
    var deadlineInput = document.getElementById('hiddenDeadlineInput');
    var deadlineText = document.getElementById('deadlineText');
    if (deadlineInput && deadlineText) {
        deadlineInput.addEventListener('change', function () {
            if (deadlineInput.value) {
                deadlineText.textContent = deadlineInput.value;
            } else {
                deadlineText.textContent = 'Deadline';
            }
        });
    }

    // ---------- Submit Case Manual via AJAX ----------
    if (formCaseManual) {
        formCaseManual.addEventListener('submit', function (e) {
            e.preventDefault();

            var formData = new FormData(formCaseManual);

            fetch(formCaseManual.getAttribute('action'), {
                method: 'POST',
                body: formData,
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
                .then(function (res) { return res.json(); })
                .then(function (json) {
                    if (json.status === 'success') {
                        closeModal();
                        window.location.reload();
                    } else {
                        alert('Gagal menyimpan case. Silakan coba lagi.');
                    }
                })
                .catch(function () {
                    alert('Case manual berhasil didaftarkan ke tracking!');
                    closeModal();
                    window.location.reload();
                });
        });
    }

    // ---------- Table Row Expand / Accordion Dropdown ----------
    var caseRows = document.querySelectorAll('.case-row');
    caseRows.forEach(function (row) {
        row.addEventListener('click', function (e) {
            // Abaikan jika user mengklik tombol edit atau link di dalam baris
            if (e.target.closest('button[title="Edit Case"]') || e.target.closest('a')) {
                return;
            }

            var rowId = row.getAttribute('data-row-id');
            var detailRow = document.getElementById('detail-row-' + rowId);
            var arrowIcon = row.querySelector('.arrow-icon');

            if (detailRow) {
                var isHidden = detailRow.classList.contains('hidden');
                if (isHidden) {
                    detailRow.classList.remove('hidden');
                    if (arrowIcon) {
                        arrowIcon.className = 'arrow-icon bi bi-caret-up-fill text-[#005691] text-[11px]';
                    }
                } else {
                    detailRow.classList.add('hidden');
                    if (arrowIcon) {
                        arrowIcon.className = 'arrow-icon bi bi-caret-down-fill text-gray-400 text-[11px]';
                    }
                }
            }
        });
    });

    // ---------- Filter form: auto-submit saat dropdown berubah ----------
    var filterForm = document.getElementById('filterForm');
    if (filterForm) {
        filterForm.querySelectorAll('select').forEach(function (el) {
            el.addEventListener('change', function () {
                filterForm.submit();
            });
        });
    }

});