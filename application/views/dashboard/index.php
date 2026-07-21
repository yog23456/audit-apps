<?php $this->load->helper('dashboard'); ?>

<!-- ============ TITLE BAR CARD ============ -->
<div class="flex flex-wrap items-center justify-between gap-4 bg-white border border-gray-200/80 rounded-xl px-5 py-3.5 mb-5 shadow-[0_1px_3px_rgba(0,0,0,0.02)]">
    <div class="flex items-center gap-3.5">
        <div class="w-9 h-9 rounded-lg border border-[#005691] text-[#005691] flex items-center justify-center text-lg font-semibold bg-blue-50/20">
            <i class="bi bi-grid-1x2"></i>
        </div>
        <div>
            <h1 class="text-sm font-bold text-gray-900 leading-tight mb-0.5"><?= htmlspecialchars($page_title) ?></h1>
            <p class="text-[11px] text-gray-500 font-normal leading-tight"><?= htmlspecialchars($page_subtitle) ?></p>
        </div>
    </div>
    <div class="flex items-center gap-2.5">
        <button type="button" class="bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-semibold px-4 py-2 rounded-lg transition-colors">
            Deteksi Anomali
        </button>
        <button type="button" class="bg-[#005691] hover:bg-[#004475] text-white text-xs font-semibold px-4 py-2 rounded-lg transition-colors shadow-sm">
            Tracking Progress
        </button>
    </div>
</div>

<!-- ============ PIPELINE STATUS INVESTIGASI ============ -->
<section class="bg-white border border-gray-200/80 rounded-xl p-5 mb-5 shadow-[0_1px_3px_rgba(0,0,0,0.02)]">
    <div class="flex items-center justify-between gap-3 mb-4">
        <h2 class="text-sm font-bold text-gray-800 tracking-tight">Pipeine Status Investigasi</h2>
        <button type="button" id="btnCaseManual" class="border border-[#005691] text-[#005691] bg-white hover:bg-blue-50/60 px-4 py-1.5 rounded-full text-xs font-semibold flex items-center gap-1.5 transition-colors shadow-sm cursor-pointer">
            <i class="bi bi-plus-lg text-sm"></i> Case Manual
        </button>
    </div>

    <!-- 8 Stage Grid -->
    <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-8 gap-3">
        <?php foreach ($pipeline_summary as $stage): ?>
            <div class="bg-[#f8fafc] border border-gray-200/80 rounded-xl p-3 flex flex-col justify-between hover:border-blue-200 transition-colors">
                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <span class="text-[10px] text-gray-400 font-medium truncate"><?= htmlspecialchars($stage['role']) ?></span>
                        <span class="w-6 h-6 rounded-full border border-[#005691] text-[#005691] flex items-center justify-center text-xs shrink-0 bg-white">
                            <i class="bi bi-<?= htmlspecialchars($stage['icon']) ?>"></i>
                        </span>
                    </div>
                    <p class="text-xs font-semibold text-gray-800 leading-tight mb-1 truncate"><?= htmlspecialchars($stage['label']) ?></p>
                </div>
                <div>
                    <p class="text-xl font-bold text-gray-900 my-1 leading-none"><?= (int) $stage['total'] ?></p>
                    <div class="text-[10px] flex items-center gap-1 mt-1 font-medium">
                        <span class="inline-flex items-center gap-1 text-[#10b981]">
                            <span class="w-1.5 h-1.5 rounded-full bg-[#10b981] inline-block"></span>
                            <span><?= (int) $stage['ontime'] ?> Ontime</span>
                        </span>
                        <span class="text-gray-300">|</span>
                        <span class="inline-flex items-center gap-1 text-[#ef4444]">
                            <span class="w-1.5 h-1.5 rounded-full bg-[#ef4444] inline-block"></span>
                            <span><?= (int) $stage['late'] ?> Late</span>
                        </span>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<!-- ============ FILTER BAR ============ -->
<section class="bg-white border border-gray-200/80 rounded-xl px-4 py-3 mb-5 shadow-[0_1px_3px_rgba(0,0,0,0.02)]">
    <form method="get" action="<?= site_url('dashboard') ?>" id="filterForm" class="flex flex-wrap items-center gap-3">
        <!-- Dropdown Auditor -->
        <div class="relative">
            <select name="auditor" class="bg-white border border-gray-200 rounded-full px-4 py-2 pr-8 text-xs font-medium text-gray-700 focus:outline-none focus:border-[#005691] appearance-none cursor-pointer">
                <option value="">Semua Auditor</option>
                <option value="Budi Santoso" <?= ($filters['auditor'] == 'Budi Santoso') ? 'selected' : '' ?>>Budi Santoso</option>
            </select>
            <i class="bi bi-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 text-[10px] pointer-events-none"></i>
        </div>

        <!-- Dropdown Kategori -->
        <div class="relative">
            <select name="kategori" class="bg-white border border-gray-200 rounded-full px-4 py-2 pr-8 text-xs font-medium text-gray-700 focus:outline-none focus:border-[#005691] appearance-none cursor-pointer">
                <option value="">Semua Kategori</option>
                <option value="Piutang ECES" <?= ($filters['kategori'] == 'Piutang ECES') ? 'selected' : '' ?>>Piutang ECES</option>
            </select>
            <i class="bi bi-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 text-[10px] pointer-events-none"></i>
        </div>

        <!-- Dropdown Stage -->
        <div class="relative">
            <select name="stage" class="bg-white border border-gray-200 rounded-full px-4 py-2 pr-8 text-xs font-medium text-gray-700 focus:outline-none focus:border-[#005691] appearance-none cursor-pointer">
                <option value="">Semua Stage</option>
                <option value="Investigasi" <?= ($filters['stage'] == 'Investigasi') ? 'selected' : '' ?>>Investigasi</option>
                <option value="Review SPV" <?= ($filters['stage'] == 'Review SPV') ? 'selected' : '' ?>>Review SPV</option>
                <option value="Review Head Unit" <?= ($filters['stage'] == 'Review Head Unit') ? 'selected' : '' ?>>Review Head Unit</option>
                <option value="Konfirmasi Auditee" <?= ($filters['stage'] == 'Konfirmasi Auditee') ? 'selected' : '' ?>>Konfirmasi Auditee</option>
                <option value="Telaah" <?= ($filters['stage'] == 'Telaah') ? 'selected' : '' ?>>Telaah</option>
                <option value="Terbit BA" <?= ($filters['stage'] == 'Terbit BA') ? 'selected' : '' ?>>Terbit BA</option>
                <option value="Feedback" <?= ($filters['stage'] == 'Feedback') ? 'selected' : '' ?>>Feedback</option>
                <option value="Closed" <?= ($filters['stage'] == 'Closed') ? 'selected' : '' ?>>Closed</option>
            </select>
            <i class="bi bi-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 text-[10px] pointer-events-none"></i>
        </div>

        <!-- Dropdown Sumber -->
        <div class="relative">
            <select name="sumber" class="bg-white border border-gray-200 rounded-full px-4 py-2 pr-8 text-xs font-medium text-gray-700 focus:outline-none focus:border-[#005691] appearance-none cursor-pointer">
                <option value="">Semua Sumber</option>
                <option value="ECES" <?= ($filters['sumber'] == 'ECES') ? 'selected' : '' ?>>ECES</option>
            </select>
            <i class="bi bi-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 text-[10px] pointer-events-none"></i>
        </div>

        <!-- Search input -->
        <input type="text" name="q" class="bg-[#f8fafc] border border-gray-200 rounded-full px-4 py-2 text-xs text-gray-700 placeholder-gray-400 focus:outline-none focus:bg-white focus:border-[#005691] flex-1 min-w-[220px]" placeholder="Cari case ID, auditee, proyek..." value="<?= htmlspecialchars($filters['q']) ?>">

        <!-- Reset Button -->
        <a href="<?= site_url('dashboard') ?>" class="bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 text-xs font-semibold px-4 py-2 rounded-full transition-colors ml-auto">
            Reset
        </a>
    </form>
</section>

<!-- ============ DETAIL KASUS INVESTIGASI ============ -->
<section class="bg-white border border-gray-200/80 rounded-xl p-5 shadow-[0_1px_3px_rgba(0,0,0,0.02)]">
    <div class="flex items-center justify-between gap-3 mb-4">
        <h2 class="text-sm font-bold text-gray-800 tracking-tight">Detail Kasus Investigasi</h2>
        <span class="text-xs text-[#005691] font-semibold flex items-center gap-1.5">
            <i class="bi bi-sliders"></i> Menampilkan <?= (int) $total_case ?> kasus
        </span>
    </div>

    <!-- Table Container -->
    <div class="overflow-x-auto rounded-lg border border-gray-200/80">
        <table class="w-full border-collapse text-left min-w-[1000px]">
            <thead>
                <tr class="bg-[#004b87] text-white text-[11px] font-semibold">
                    <th class="px-3.5 py-3 font-semibold rounded-tl-lg">
                        <div class="flex items-center gap-1 cursor-pointer">
                            <span>Invoice</span>
                            <i class="bi bi-caret-down-fill text-[9px] opacity-70"></i>
                        </div>
                    </th>
                    <th class="px-3.5 py-3 font-semibold">Sumber</th>
                    <th class="px-3.5 py-3 font-semibold">Kategori</th>
                    <th class="px-3.5 py-3 font-semibold">Proyek/Auditee</th>
                    <th class="px-3.5 py-3 font-semibold">Nilai</th>
                    <th class="px-3.5 py-3 font-semibold">Stage</th>
                    <th class="px-3.5 py-3 font-semibold">Deadline</th>
                    <th class="px-3.5 py-3 font-semibold">Progress</th>
                    <th class="px-3.5 py-3 font-semibold">Auditor PIC</th>
                    <th class="px-3.5 py-3 font-semibold">Target Actual</th>
                    <th class="px-3.5 py-3 font-semibold rounded-tr-lg text-center"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200/80 bg-white text-xs">
                <?php foreach ($case_list as $index => $row): ?>
                    <!-- Main Table Row -->
                    <tr class="case-row hover:bg-blue-50/20 transition-colors cursor-pointer" data-row-id="<?= $index ?>">
                        <!-- Invoice with expand arrow -->
                        <td class="px-3.5 py-3.5 whitespace-nowrap font-medium text-gray-800">
                            <div class="flex items-center gap-2">
                                <button type="button" class="btn-toggle-row text-gray-400 hover:text-gray-600 focus:outline-none" data-row-id="<?= $index ?>">
                                    <i class="arrow-icon bi <?= !empty($row['expanded']) ? 'bi-caret-up-fill text-[#005691]' : 'bi-caret-down-fill text-gray-400' ?> text-[11px]"></i>
                                </button>
                                <span class="font-semibold text-gray-800"><?= htmlspecialchars($row['invoice']) ?></span>
                            </div>
                        </td>

                        <!-- Sumber badge -->
                        <td class="px-3.5 py-3.5 whitespace-nowrap">
                            <span class="inline-flex items-center gap-1 border border-[#005691] text-[#005691] rounded-full px-2.5 py-0.5 text-[10px] font-semibold bg-blue-50/40">
                                <i class="bi bi-flower1 text-[9px]"></i> <?= htmlspecialchars($row['sumber']) ?>
                            </span>
                        </td>

                        <!-- Kategori -->
                        <td class="px-3.5 py-3.5 whitespace-nowrap text-gray-600 font-medium">
                            <?= htmlspecialchars($row['kategori']) ?>
                        </td>

                        <!-- Proyek / Auditee -->
                        <td class="px-3.5 py-3.5">
                            <div class="leading-tight">
                                <div class="font-bold text-gray-900 text-xs"><?= htmlspecialchars($row['proyek']) ?></div>
                                <div class="text-[11px] text-gray-500 mt-0.5"><?= htmlspecialchars($row['auditee']) ?></div>
                            </div>
                        </td>

                        <!-- Nilai -->
                        <td class="px-3.5 py-3.5 whitespace-nowrap font-semibold text-gray-800">
                            <?= 'Rp' . number_format($row['nilai'], 0, ',', '.') ?>
                        </td>

                        <!-- Stage Badge -->
                        <td class="px-3.5 py-3.5 whitespace-nowrap">
                            <span class="<?= $row['stage_color'] ?> text-white text-[10px] font-semibold px-3 py-1 rounded-full inline-block text-center min-w-[95px] shadow-sm">
                                <?= htmlspecialchars($row['stage']) ?>
                            </span>
                        </td>

                        <!-- Deadline -->
                        <td class="px-3.5 py-3.5 whitespace-nowrap text-gray-400 font-medium">
                            <?= htmlspecialchars($row['deadline']) ?>
                        </td>

                        <!-- Progress Bar & % -->
                        <td class="px-3.5 py-3.5 whitespace-nowrap">
                            <div class="flex items-center gap-2 min-w-[110px]">
                                <div class="w-16 h-1.5 bg-gray-100 rounded-full overflow-hidden flex-1">
                                    <div class="h-full rounded-full <?= explode(' ', $row['progress_color'])[0] ?>" style="width: <?= (int)$row['progress'] ?>%"></div>
                                </div>
                                <span class="text-[11px] font-semibold <?= explode(' ', $row['progress_color'])[1] ?>">
                                    <?= (int)$row['progress'] ?>%
                                </span>
                            </div>
                        </td>

                        <!-- Auditor PIC -->
                        <td class="px-3.5 py-3.5 whitespace-nowrap text-gray-700 font-medium">
                            <?= htmlspecialchars($row['auditor_pic']) ?>
                        </td>

                        <!-- Target Actual -->
                        <td class="px-3.5 py-3.5 whitespace-nowrap text-gray-500 font-medium text-[11px]">
                            <?= htmlspecialchars($row['target_actual']) ?>
                        </td>

                        <!-- Action Edit Circle Button -->
                        <td class="px-3.5 py-3.5 whitespace-nowrap text-center" onclick="event.stopPropagation();">
                            <button type="button" class="w-7 h-7 rounded-full bg-[#005691] hover:bg-[#004475] text-white flex items-center justify-center text-xs transition-colors mx-auto shadow-sm" title="Edit Case">
                                <i class="bi bi-pencil-fill text-[10px]"></i>
                            </button>
                        </td>
                    </tr>

                    <!-- Dropdown Accordion Row Detail (Timeline & Evidence) -->
                    <tr id="detail-row-<?= $index ?>" class="case-detail-row <?= empty($row['expanded']) ? 'hidden' : '' ?> bg-[#f6f8fb]">
                        <td colspan="11" class="p-6 border-b border-gray-200/80">
                            <!-- Container Content Box -->
                            <div class="space-y-6">
                                
                                <!-- Timeline Tahapan Investigasi Section -->
                                <div>
                                    <h4 class="text-xs font-bold text-gray-700 mb-4 tracking-tight">Timeline Tahapan Investigasi</h4>
                                    
                                    <!-- Stepper Items Wrapper -->
                                    <div class="bg-white rounded-2xl border border-gray-200/80 p-5 shadow-xs">
                                        <div class="flex items-center justify-between w-full relative px-2">
                                            <?php 
                                            $stages_list = array('Investigasi', 'Investigasi', 'Investigasi', 'Investigasi', 'Investigasi', 'Investigasi', 'Investigasi', 'Investigasi');
                                            foreach ($stages_list as $i => $st_name): 
                                                $is_active = ($i === 0); // Active first step in orange
                                            ?>
                                                <div class="flex flex-col items-center z-10">
                                                    <div class="w-10 h-10 rounded-full flex items-center justify-center text-base transition-all <?= $is_active ? 'border-2 border-orange-500 bg-white text-orange-500 shadow-sm' : 'border border-gray-200 bg-white text-gray-400' ?>">
                                                        <i class="bi bi-file-earmark-text"></i>
                                                    </div>
                                                    <span class="text-[11px] <?= $is_active ? 'font-semibold text-orange-500' : 'font-medium text-gray-400' ?> mt-2 block text-center">
                                                        <?= $st_name ?>
                                                    </span>
                                                </div>

                                                <?php if ($i < count($stages_list) - 1): ?>
                                                    <div class="flex-1 h-[2px] bg-gray-200 mx-1 -mt-5"></div>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>

                                <!-- Evidence Section -->
                                <div>
                                    <h4 class="text-xs font-bold text-gray-700 mb-2 tracking-tight">Evidence:</h4>
                                    
                                    <!-- Uploader Info -->
                                    <div class="flex items-center gap-2 mb-3">
                                        <div class="w-8 h-8 rounded-full bg-blue-100 text-[#005691] font-bold text-xs flex items-center justify-center border border-blue-200">
                                            OR
                                        </div>
                                        <span class="text-xs text-gray-600 font-medium">3 Juli, 2026 - 10:00</span>
                                    </div>

                                    <!-- PDF Attachment Card -->
                                    <div class="bg-white border border-gray-200 rounded-xl p-3.5 max-w-[280px] shadow-xs flex items-start gap-3 relative hover:border-blue-200 transition-colors">
                                        <div class="w-9 h-9 rounded-lg bg-blue-50 text-[#005691] flex items-center justify-center text-lg shrink-0 border border-blue-100">
                                            <i class="bi bi-file-earmark-pdf"></i>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="text-xs font-semibold text-gray-800 leading-tight truncate">Dashboard prototype recording.pdf</div>
                                            <div class="text-[11px] text-gray-400 mt-0.5 font-medium">16 MB</div>
                                            <div class="text-right mt-2">
                                                <a href="#" onclick="event.stopPropagation(); alert('Silakan pilih file baru...'); return false;" class="text-xs font-semibold text-[#005691] hover:underline cursor-pointer">Ganti</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination Footer -->
    <div class="flex flex-wrap items-center justify-between gap-3 mt-4 pt-2">
        <button type="button" class="border border-gray-200 bg-white hover:bg-gray-50 text-gray-600 text-xs font-semibold px-3.5 py-1.5 rounded-lg flex items-center gap-1.5 transition-colors">
            <i class="bi bi-arrow-left"></i> Previous
        </button>

        <div class="flex items-center gap-1">
            <span class="w-7 h-7 rounded-lg border border-[#005691] text-[#005691] bg-white font-bold text-xs flex items-center justify-center shadow-xs">1</span>
            <button class="w-7 h-7 rounded-lg text-gray-600 hover:bg-gray-100 font-medium text-xs flex items-center justify-center">2</button>
            <button class="w-7 h-7 rounded-lg text-gray-600 hover:bg-gray-100 font-medium text-xs flex items-center justify-center">3</button>
            <span class="text-gray-400 text-xs px-1">...</span>
            <button class="w-7 h-7 rounded-lg text-gray-600 hover:bg-gray-100 font-medium text-xs flex items-center justify-center">8</button>
            <button class="w-7 h-7 rounded-lg text-gray-600 hover:bg-gray-100 font-medium text-xs flex items-center justify-center">9</button>
            <button class="w-7 h-7 rounded-lg text-gray-600 hover:bg-gray-100 font-medium text-xs flex items-center justify-center">10</button>
        </div>

        <button type="button" class="border border-gray-200 bg-white hover:bg-gray-50 text-gray-600 text-xs font-semibold px-3.5 py-1.5 rounded-lg flex items-center gap-1.5 transition-colors">
            Next <i class="bi bi-arrow-right"></i>
        </button>
    </div>
</section>

<!-- ============ MODAL CASE MANUAL ============ -->
<div id="modalCaseManual" class="fixed inset-0 z-50 hidden bg-black/60 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-[560px] w-full p-6 shadow-2xl border border-gray-100 flex flex-col max-h-[94vh] overflow-y-auto">
        
        <!-- Header -->
        <div class="flex items-center justify-between pb-2 mb-2 border-b border-gray-100">
            <h3 class="font-bold text-base text-gray-800">
                Daftarkan Case Manual
            </h3>
            <button type="button" id="modalCloseBtn" class="text-gray-400 hover:text-gray-600 text-lg p-1 focus:outline-none cursor-pointer">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>

        <form id="formCaseManual" action="<?= site_url('dashboard/case/store') ?>" method="post" class="space-y-4">
            
            <!-- Simulasi Cepat Box -->
            <div class="border border-gray-200/80 rounded-xl p-3 bg-white">
                <div class="flex items-center gap-1.5 text-[#005691] text-xs font-semibold mb-2.5">
                    <i class="bi bi-sliders2"></i>
                    <span>Simulasi Cepat</span>
                </div>
                <div class="grid grid-cols-3 gap-2.5">
                    <button type="button" class="btn-quick-sim border border-gray-200 hover:border-[#005691] hover:text-[#005691] hover:bg-blue-50/40 rounded-full py-1.5 px-3 text-xs text-gray-700 font-medium transition-all text-center cursor-pointer" data-type="whistleblower">
                        Whistleblower
                    </button>
                    <button type="button" class="btn-quick-sim border border-gray-200 hover:border-[#005691] hover:text-[#005691] hover:bg-blue-50/40 rounded-full py-1.5 px-3 text-xs text-gray-700 font-medium transition-all text-center cursor-pointer" data-type="sop">
                        SOP
                    </button>
                    <button type="button" class="btn-quick-sim border border-gray-200 hover:border-[#005691] hover:text-[#005691] hover:bg-blue-50/40 rounded-full py-1.5 px-3 text-xs text-gray-700 font-medium transition-all text-center cursor-pointer" data-type="request">
                        Request Divisi
                    </button>
                </div>
            </div>

            <!-- Nama / Judul Case Input -->
            <div class="pt-1">
                <input type="text" name="judul_case" id="inputJudulCase" required placeholder="| Nama/Judul Case..." class="w-full border-0 border-b border-gray-200 focus:border-[#005691] focus:ring-0 text-base font-medium text-gray-800 placeholder-gray-400 py-1.5 focus:outline-none">
            </div>

            <!-- Deskripsi / Uraian Temuan Input -->
            <div class="relative pt-1">
                <div class="flex items-start gap-2">
                    <i class="bi bi-card-text text-gray-400 text-sm mt-1 shrink-0"></i>
                    <textarea name="deskripsi" id="inputDeskripsi" rows="3" placeholder="Deskripsi/Uraian Temuan" class="w-full border-0 focus:ring-0 text-xs text-gray-700 placeholder-gray-400 py-1 focus:outline-none resize-none"></textarea>
                </div>
            </div>

            <!-- Assign & Deadline Pills -->
            <div class="flex items-center gap-2 pt-1">
                <button type="button" id="btnAssign" class="border border-gray-200 hover:bg-gray-50 rounded-full px-3 py-1.5 text-xs text-gray-700 font-medium flex items-center gap-1.5 transition-colors cursor-pointer">
                    <i class="bi bi-person-plus text-gray-500"></i>
                    <span id="assignText">Assign</span>
                </button>
                <input type="hidden" name="auditor_pic" id="hiddenAuditorPic" value="Budi Santoso">

                <div class="relative inline-block">
                    <button type="button" id="btnDeadline" class="border border-gray-200 hover:bg-gray-50 rounded-full px-3 py-1.5 text-xs text-gray-700 font-medium flex items-center gap-1.5 transition-colors cursor-pointer">
                        <i class="bi bi-calendar-event text-gray-500"></i>
                        <span id="deadlineText">Deadline</span>
                    </button>
                    <input type="date" name="target_actual" id="hiddenDeadlineInput" class="absolute inset-0 opacity-0 cursor-pointer w-full h-full">
                </div>
            </div>

            <!-- Form Row Fields -->
            <div class="space-y-3 pt-2">
                <!-- Sumber Informasi -->
                <div class="grid grid-cols-[150px_12px_1fr] items-center text-xs">
                    <label class="font-medium text-gray-700 flex items-center gap-2">
                        <i class="bi bi-grid-1x2 text-gray-400 text-sm shrink-0"></i>
                        <span>Sumber Informasi<span class="text-red-500">*</span></span>
                    </label>
                    <span class="text-gray-400 font-medium">:</span>
                    <div class="relative">
                        <select name="sumber" id="selectSumber" required class="w-full bg-white border border-gray-200 rounded-xl px-3.5 py-2 pr-8 text-xs text-gray-700 focus:outline-none focus:border-[#005691] appearance-none cursor-pointer">
                            <option value="" disabled selected>Pilih sumber informasi</option>
                            <option value="ECES">ECES</option>
                            <option value="Whistleblower System">Whistleblower System</option>
                            <option value="Audit SOP Internal">Audit SOP Internal</option>
                            <option value="Request Divisi Direksi">Request Divisi Direksi</option>
                        </select>
                        <i class="bi bi-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 text-[10px] pointer-events-none"></i>
                    </div>
                </div>

                <!-- Kategori Case -->
                <div class="grid grid-cols-[150px_12px_1fr] items-center text-xs">
                    <label class="font-medium text-gray-700 flex items-center gap-2">
                        <i class="bi bi-search text-gray-400 text-sm shrink-0"></i>
                        <span>Kategori Case<span class="text-red-500">*</span></span>
                    </label>
                    <span class="text-gray-400 font-medium">:</span>
                    <div>
                        <input type="text" name="kategori" id="inputKategori" required placeholder="Isi kategori case" class="w-full bg-white border border-gray-200 rounded-xl px-3.5 py-2 text-xs text-gray-700 placeholder-gray-400 focus:outline-none focus:border-[#005691]">
                    </div>
                </div>

                <!-- Proyek / Area / Unit Bisnis -->
                <div class="grid grid-cols-[150px_12px_1fr] items-center text-xs">
                    <label class="font-medium text-gray-700 flex items-center gap-2">
                        <i class="bi bi-house-door text-gray-400 text-sm shrink-0"></i>
                        <span>Proyek/Area/Unit Bisnis</span>
                    </label>
                    <span class="text-gray-400 font-medium">:</span>
                    <div class="relative">
                        <select name="proyek" id="selectProyek" class="w-full bg-white border border-gray-200 rounded-xl px-3.5 py-2 pr-8 text-xs text-gray-700 focus:outline-none focus:border-[#005691] appearance-none cursor-pointer">
                            <option value="" disabled selected>Pilih proyek/area/unit bisnis</option>
                            <option value="Arjawinangun 1 T3">Arjawinangun 1 T3</option>
                            <option value="Arjawinangun By Pass">Arjawinangun By Pass</option>
                            <option value="RN Gegunung">RN Gegunung</option>
                            <option value="RN Ningrat">RN Ningrat</option>
                            <option value="RN Pejambon">RN Pejambon</option>
                            <option value="Trusmiland 5">Trusmiland 5</option>
                        </select>
                        <i class="bi bi-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 text-[10px] pointer-events-none"></i>
                    </div>
                </div>
            </div>

            <!-- Catatan / Instruksi Head Audit -->
            <div class="pt-2">
                <label class="block text-[11px] font-semibold text-gray-500 mb-1.5">
                    Catatan/Intruksi Head Audit
                </label>
                <textarea name="catatan_head_audit" id="inputCatatan" rows="3" placeholder="Konteks tambahan, referensi dokumen, atau intruksi khusus..." class="w-full bg-white border border-gray-200/80 rounded-xl p-3 text-xs text-gray-700 placeholder-gray-400 focus:outline-none focus:border-[#005691] resize-none"></textarea>
            </div>

            <!-- Modal Footer Action Buttons -->
            <div class="flex items-center justify-end gap-3 pt-3 border-t border-gray-100 mt-5">
                <button type="button" id="modalResetBtn" class="border border-gray-200 hover:bg-gray-50 bg-white text-gray-700 font-semibold px-5 py-2 rounded-xl text-xs transition-colors cursor-pointer">
                    Reset
                </button>
                <button type="submit" class="bg-[#005691] hover:bg-[#004475] text-white font-semibold px-5 py-2 rounded-xl text-xs shadow-sm transition-colors cursor-pointer">
                    Daftarkan ke Tracking
                </button>
            </div>
        </form>
    </div>
</div>