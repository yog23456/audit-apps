document.addEventListener('DOMContentLoaded', function () {

    // ---------- Custom Success Toast System ----------
    function showToast(title, message) {
        var container = document.getElementById('toast-container');
        if (!container) {
            container = document.createElement('div');
            container.id = 'toast-container';
            container.className = 'fixed top-5 right-5 z-[9999] flex flex-col gap-3 pointer-events-none';
            document.body.appendChild(container);
        }

        var toast = document.createElement('div');
        toast.className = 'toast-animate-in bg-white border border-emerald-100 rounded-xl p-4 shadow-xl flex items-start gap-3 pointer-events-auto max-w-sm w-80 md:w-96 relative overflow-hidden';
        
        toast.innerHTML = [
            '<div class="w-8 h-8 rounded-full bg-emerald-50 text-emerald-500 flex items-center justify-center shrink-0">',
                '<i class="bi bi-check-circle-fill text-base"></i>',
            '</div>',
            '<div class="flex-1 min-w-0">',
                '<h4 class="font-bold text-gray-900 text-xs">' + title + '</h4>',
                '<p class="text-gray-500 text-[11px] mt-0.5 leading-relaxed">' + message + '</p>',
            '</div>',
            '<button type="button" class="close-toast-btn text-gray-400 hover:text-gray-600 transition-colors ml-1 mt-0.5 focus:outline-none shrink-0 cursor-pointer">',
                '<i class="bi bi-x-lg text-[10px]"></i>',
            '</button>',
            '<div class="absolute bottom-0 left-0 right-0 h-[3px] bg-emerald-100">',
                '<div class="toast-progress-bar h-full bg-emerald-500"></div>',
            '</div>'
        ].join('');

        container.appendChild(toast);

        var dismissTimeout = setTimeout(function () {
            dismissToast(toast);
        }, 3000);

        var closeBtn = toast.querySelector('.close-toast-btn');
        if (closeBtn) {
            closeBtn.addEventListener('click', function () {
                clearTimeout(dismissTimeout);
                dismissToast(toast);
            });
        }
    }

    function dismissToast(toast) {
        toast.classList.remove('toast-animate-in');
        toast.classList.add('toast-animate-out');
        toast.addEventListener('animationend', function () {
            toast.remove();
        });
    }

    function showToastAfterReload(title, message) {
        sessionStorage.setItem('pendingToast', JSON.stringify({ title: title, message: message }));
        window.location.reload();
    }

    // Check for pending toast on load
    var pendingToast = sessionStorage.getItem('pendingToast');
    if (pendingToast) {
        try {
            var toastData = JSON.parse(pendingToast);
            showToast(toastData.title, toastData.message);
        } catch (e) {}
        sessionStorage.removeItem('pendingToast');
    }

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
                        showToastAfterReload('Registrasi Berhasil', 'Case baru berhasil didaftarkan ke tracking.');
                    } else {
                        alert('Gagal menyimpan case. Silakan coba lagi.');
                    }
                })
                .catch(function () {
                    closeModal();
                    var judulVal = document.getElementById('inputJudulCase') ? document.getElementById('inputJudulCase').value : '';
                    var displayMsg = judulVal ? 'Case "' + judulVal + '" berhasil didaftarkan ke tracking.' : 'Case manual berhasil didaftarkan ke tracking.';
                    showToastAfterReload('Registrasi Berhasil', displayMsg);
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

    // ---------- Modal: Upload Dokumen ----------
    var uploadModal = document.getElementById('modalUploadDokumen');
    var openUploadBtns = document.querySelectorAll('.btn-open-upload');
    var closeUploadX = document.getElementById('uploadModalCloseX');
    var closeUploadCancel = document.getElementById('uploadModalCancel');
    var uploadDropzone = document.getElementById('uploadDropzone');
    var fileUploadInput = document.getElementById('fileUploadInput');
    var fileStatusCard = document.getElementById('fileStatusCard');
    var fileNameEl = document.getElementById('fileName');
    var fileSizeEl = document.getElementById('fileSize');
    var fileIconEl = document.getElementById('fileIcon');
    var fileCheckIcon = document.getElementById('fileCheckIcon');
    var uploadProgressBar = document.getElementById('uploadProgressBar');
    var uploadProgressPercent = document.getElementById('uploadProgressPercent');
    var removeFileBtn = document.getElementById('removeFileBtn');
    var changeFileBtn = document.getElementById('changeFileBtn');
    var submitUploadBtn = document.getElementById('submitUploadBtn');

    var uploadModalBadge = document.getElementById('uploadModalBadge');
    var uploadModalInvoice = document.getElementById('uploadModalInvoice');
    var uploadModalAlert = document.getElementById('uploadModalAlert');

    var stageNextMap = {
        'Investigasi': { next: 'SPV', text: 'Upload dokumen olahan data investigasi. Setelah submit diteruskan ke SPV untuk direview.' },
        'Review SPV': { next: 'Head Audit', text: 'Upload dokumen review SPV. Setelah submit diteruskan ke Head Audit untuk direview.' },
        'Review Head': { next: 'Auditee', text: 'Upload dokumen hasil review Head. Setelah submit diteruskan ke Auditee untuk dikonfirmasi.' },
        'Review Head Unit': { next: 'Auditee', text: 'Upload dokumen hasil review Head. Setelah submit diteruskan ke Auditee untuk dikonfirmasi.' },
        'Konfirmasi Auditee': { next: 'Auditor (Telaah)', text: 'Upload dokumen tanggapan auditee. Setelah submit diteruskan ke Auditor untuk ditelaah.' },
        'Telaah': { next: 'SPV (Terbit BA)', text: 'Upload dokumen hasil telaah. Setelah submit diteruskan ke SPV untuk penerbitan Berita Acara.' },
        'Terbit BA': { next: 'Auditee (Feedback)', text: 'Upload Berita Acara. Setelah submit diteruskan ke Auditee untuk feedback.' },
        'Feedback': { next: 'Closed', text: 'Upload feedback auditee. Setelah submit status case dapat ditutup.' },
        'Closed': { next: '-', text: 'Case ini sudah selesai/tertutup.' }
    };

    function openUploadModal(btn) {
        if (!uploadModal) return;
        var invoice = btn.getAttribute('data-invoice') || 'AUD-2026-004';
        var stage = btn.getAttribute('data-stage') || 'Investigasi';
        var stageColor = btn.getAttribute('data-stage-color') || 'bg-orange-500';

        // Set case details
        if (uploadModalInvoice) uploadModalInvoice.textContent = invoice;
        if (uploadModalBadge) {
            uploadModalBadge.textContent = stage;
            // Clear old bg- classes
            uploadModalBadge.className = 'text-white text-[10px] font-semibold px-2.5 py-0.5 rounded-full ml-2';
            // Parse classes from stageColor
            stageColor.split(' ').forEach(function(cls) {
                if (cls.trim()) uploadModalBadge.classList.add(cls);
            });
        }

        // Set alert message based on stage
        if (uploadModalAlert) {
            var stageInfo = stageNextMap[stage] || stageNextMap['Investigasi'];
            uploadModalAlert.textContent = stageInfo.text;
        }

        resetUploadState();
        uploadModal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeUploadModal() {
        if (uploadModal) {
            uploadModal.classList.add('hidden');
            document.body.style.overflow = '';
        }
    }

    function resetUploadState() {
        if (fileUploadInput) fileUploadInput.value = '';
        if (uploadDropzone) uploadDropzone.classList.remove('hidden');
        if (fileStatusCard) fileStatusCard.classList.add('hidden');
        if (uploadProgressBar) {
            uploadProgressBar.style.width = '0%';
            uploadProgressBar.classList.remove('bg-green-500');
            uploadProgressBar.classList.add('bg-[#005691]');
        }
        if (uploadProgressPercent) uploadProgressPercent.textContent = '0%';
        if (fileCheckIcon) {
            fileCheckIcon.classList.add('opacity-0');
            fileCheckIcon.className = 'bi bi-check-circle-fill text-[#005691] text-base ml-2 shrink-0 opacity-0 transition-opacity duration-300';
        }
        if (submitUploadBtn) {
            submitUploadBtn.className = 'bg-[#a5c3db] pointer-events-none text-white font-semibold px-5 py-2 rounded-xl text-xs transition-all shadow-sm';
        }
    }

    openUploadBtns.forEach(function (btn) {
        btn.addEventListener('click', function () {
            openUploadModal(btn);
        });
    });

    if (closeUploadX) closeUploadX.addEventListener('click', closeUploadModal);
    if (closeUploadCancel) closeUploadCancel.addEventListener('click', closeUploadModal);
    if (uploadModal) {
        uploadModal.addEventListener('click', function (e) {
            if (e.target === uploadModal) closeUploadModal();
        });
    }

    // Trigger file selection on dropzone click
    if (uploadDropzone && fileUploadInput) {
        uploadDropzone.addEventListener('click', function () {
            fileUploadInput.click();
        });
    }

    // Handle file drag events
    if (uploadDropzone) {
        ['dragenter', 'dragover'].forEach(eventName => {
            uploadDropzone.addEventListener(eventName, function(e) {
                e.preventDefault();
                uploadDropzone.classList.add('border-blue-400', 'bg-blue-50/10');
            }, false);
        });

        ['dragleave', 'dragend', 'drop'].forEach(eventName => {
            uploadDropzone.addEventListener(eventName, function(e) {
                e.preventDefault();
                uploadDropzone.classList.remove('border-blue-400', 'bg-blue-50/10');
            }, false);
        });

        uploadDropzone.addEventListener('drop', function(e) {
            var dt = e.dataTransfer;
            var files = dt.files;
            if (files && files.length > 0) {
                handleFileSelect(files[0]);
            }
        });
    }

    // Handle file input change
    if (fileUploadInput) {
        fileUploadInput.addEventListener('change', function(e) {
            if (fileUploadInput.files && fileUploadInput.files.length > 0) {
                handleFileSelect(fileUploadInput.files[0]);
            }
        });
    }

    // Handle file selection and simulation
    function handleFileSelect(file) {
        if (!file) return;

        // Hide dropzone, show file card
        if (uploadDropzone) uploadDropzone.classList.add('hidden');
        if (fileStatusCard) fileStatusCard.classList.remove('hidden');

        // Set file details
        if (fileNameEl) fileNameEl.textContent = file.name;
        
        // Format size
        var sizeStr = '';
        if (file.size < 1024 * 1024) {
            sizeStr = Math.round(file.size / 1024) + ' KB';
        } else {
            sizeStr = (file.size / (1024 * 1024)).toFixed(1) + ' MB';
        }
        if (fileSizeEl) fileSizeEl.textContent = sizeStr;

        // Dynamic icon based on extension
        var ext = file.name.split('.').pop().toLowerCase();
        var iconClass = 'bi-file-earmark-text-fill';
        if (['pdf'].includes(ext)) {
            iconClass = 'bi-file-earmark-pdf-fill';
        } else if (['png', 'jpg', 'jpeg', 'gif'].includes(ext)) {
            iconClass = 'bi-file-earmark-image-fill';
        } else if (['doc', 'docx'].includes(ext)) {
            iconClass = 'bi-file-earmark-word-fill';
        } else if (['xls', 'xlsx'].includes(ext)) {
            iconClass = 'bi-file-earmark-excel-fill';
        } else if (['zip', 'rar'].includes(ext)) {
            iconClass = 'bi-file-earmark-zip-fill';
        }
        if (fileIconEl) {
            fileIconEl.className = 'bi ' + iconClass + ' text-lg';
        }

        // Simulate progress bar animation
        var progress = 0;
        if (uploadProgressBar) uploadProgressBar.style.width = '0%';
        if (uploadProgressPercent) uploadProgressPercent.textContent = '0%';
        if (fileCheckIcon) fileCheckIcon.classList.add('opacity-0');
        if (submitUploadBtn) {
            submitUploadBtn.className = 'bg-[#a5c3db] pointer-events-none text-white font-semibold px-5 py-2 rounded-xl text-xs transition-all shadow-sm';
        }

        var intervalTime = 15;
        var increment = 4;
        var uploadInterval = setInterval(function() {
            progress += increment;
            if (progress >= 100) {
                progress = 100;
                clearInterval(uploadInterval);
                onUploadComplete();
            }
            if (uploadProgressBar) uploadProgressBar.style.width = progress + '%';
            if (uploadProgressPercent) uploadProgressPercent.textContent = progress + '%';
        }, intervalTime);
    }

    function onUploadComplete() {
        if (fileCheckIcon) {
            fileCheckIcon.classList.remove('opacity-0');
        }
        if (submitUploadBtn) {
            submitUploadBtn.className = 'bg-[#005691] hover:bg-[#004475] text-white font-semibold px-5 py-2 rounded-xl text-xs transition-all shadow-sm hover:shadow-md cursor-pointer';
            submitUploadBtn.removeAttribute('style');
        }
    }

    // Remove file action
    if (removeFileBtn) {
        removeFileBtn.addEventListener('click', function() {
            resetUploadState();
        });
    }

    // Change file action
    if (changeFileBtn && fileUploadInput) {
        changeFileBtn.addEventListener('click', function() {
            fileUploadInput.click();
        });
    }

    // Submit upload action
    if (submitUploadBtn) {
        submitUploadBtn.addEventListener('click', function() {
            var invoice = uploadModalInvoice ? uploadModalInvoice.textContent : 'AUD-2026-004';
            var stage = uploadModalBadge ? uploadModalBadge.textContent : 'Investigasi';
            var fileName = fileNameEl ? fileNameEl.textContent : 'dokumen';

            closeUploadModal();
            var nextStage = (stageNextMap[stage] && stageNextMap[stage].next) ? stageNextMap[stage].next : 'tahap berikutnya';
            showToastAfterReload('Upload Berhasil', 'Dokumen "' + fileName + '" berhasil diunggah untuk Case ' + invoice + ' dan diteruskan ke ' + nextStage + '.');
        });
    }

});