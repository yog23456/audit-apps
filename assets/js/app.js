document.addEventListener('DOMContentLoaded', function () {

    // ---------- Modal: Case Manual ----------
    var modal = document.getElementById('modalCaseManual');
    var openBtn = document.getElementById('btnCaseManual');
    var closeBtn = document.getElementById('modalCloseBtn');
    var cancelBtn = document.getElementById('modalCancelBtn');

    function openModal() { if (modal) modal.classList.add('open'); }
    function closeModal() { if (modal) modal.classList.remove('open'); }

    if (openBtn) openBtn.addEventListener('click', openModal);
    if (closeBtn) closeBtn.addEventListener('click', closeModal);
    if (cancelBtn) cancelBtn.addEventListener('click', closeModal);
    if (modal) {
        modal.addEventListener('click', function (e) {
            if (e.target === modal) closeModal();
        });
    }

    // ---------- Submit Case Manual via AJAX ----------
    var formCaseManual = document.getElementById('formCaseManual');
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
                    alert('Terjadi kesalahan koneksi.');
                });
        });
    }

    // ---------- Row expand toggle ----------
    document.querySelectorAll('.row-expand-btn').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var icon = btn.querySelector('i');
            icon.classList.toggle('bi-chevron-down');
            icon.classList.toggle('bi-chevron-up');
            // TODO: tampilkan detail tambahan pada baris jika diperlukan
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