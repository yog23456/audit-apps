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
        <button type="button" id="btnCaseManual" class="border border-[#005691] text-[#005691] bg-white hover:bg-blue-50/60 px-4 py-1.5 rounded-full text-xs font-semibold flex items-center gap-1.5 transition-colors shadow-sm">
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
            <i class="bi bi-[#...] bi-sliders"></i> Menampilkan <?= (int) $total_case ?> kasus
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
                    <tr class="hover:bg-blue-50/20 transition-colors">
                        <!-- Invoice with expand arrow -->
                        <td class="px-3.5 py-3.5 whitespace-nowrap font-medium text-gray-800">
                            <div class="flex items-center gap-2">
                                <button type="button" class="text-gray-400 hover:text-gray-600 focus:outline-none">
                                    <?php if (!empty($row['expanded'])): ?>
                                        <i class="bi bi-[#...] bi-caret-up-fill text-[11px] text-[#005691]"></i>
                                    <?php else: ?>
                                        <i class="bi bi-[#...] bi-caret-down-fill text-[11px] text-gray-400"></i>
                                    <?php endif; ?>
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
                        <td class="px-3.5 py-3.5 whitespace-nowrap text-center">
                            <button type="button" class="w-7 h-7 rounded-full bg-[#005691] hover:bg-[#004475] text-white flex items-center justify-center text-xs transition-colors mx-auto shadow-sm" title="Edit Case">
                                <i class="bi bi-pencil-fill text-[10px]"></i>
                            </button>
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
<div id="modalCaseManual" class="fixed inset-0 z-50 hidden bg-gray-900/50 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="bg-white rounded-xl max-w-md w-full p-6 shadow-xl border border-gray-100">
        <div class="flex items-center justify-between border-b border-gray-100 pb-3 mb-4">
            <h3 class="font-bold text-sm text-gray-800 flex items-center gap-2">
                <i class="bi bi-[#...] bi-plus-circle-fill text-[#005691]"></i> Tambah Case Manual
            </h3>
            <button type="button" id="modalCloseBtn" class="text-gray-400 hover:text-gray-600 text-lg">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
        <form id="formCaseManual" action="<?= site_url('dashboard/case/store') ?>" method="post" class="space-y-3 text-xs">
            <div>
                <label class="block font-semibold text-gray-600 mb-1">Invoice</label>
                <input type="text" name="invoice" required placeholder="AUD-2026-xxx" class="w-full border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:border-[#005691]">
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block font-semibold text-gray-600 mb-1">Sumber</label>
                    <input type="text" name="sumber" value="ECES" required class="w-full border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:border-[#005691]">
                </div>
                <div>
                    <label class="block font-semibold text-gray-600 mb-1">Kategori</label>
                    <input type="text" name="kategori" value="Piutang ECES" required class="w-full border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:border-[#005691]">
                </div>
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block font-semibold text-gray-600 mb-1">Proyek</label>
                    <input type="text" name="proyek" required placeholder="Nama proyek" class="w-full border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:border-[#005691]">
                </div>
                <div>
                    <label class="block font-semibold text-gray-600 mb-1">Auditee</label>
                    <input type="text" name="auditee" required placeholder="Nama auditee" class="w-full border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:border-[#005691]">
                </div>
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block font-semibold text-gray-600 mb-1">Nilai (Rp)</label>
                    <input type="number" name="nilai" required placeholder="0" class="w-full border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:border-[#005691]">
                </div>
                <div>
                    <label class="block font-semibold text-gray-600 mb-1">Stage</label>
                    <select name="stage" class="w-full border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:border-[#005691]">
                        <option value="Investigasi">Investigasi</option>
                        <option value="Review SPV">Review SPV</option>
                        <option value="Review Head Unit">Review Head Unit</option>
                        <option value="Konfirmasi Auditee">Konfirmasi Auditee</option>
                        <option value="Telaah">Telaah</option>
                        <option value="Terbit BA">Terbit BA</option>
                        <option value="Feedback">Feedback</option>
                        <option value="Closed">Closed</option>
                    </select>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block font-semibold text-gray-600 mb-1">Auditor PIC</label>
                    <input type="text" name="auditor_pic" value="Budi Santoso" required class="w-full border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:border-[#005691]">
                </div>
                <div>
                    <label class="block font-semibold text-gray-600 mb-1">Target Actual</label>
                    <input type="date" name="target_actual" value="<?= date('Y-m-d') ?>" required class="w-full border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:border-[#005691]">
                </div>
            </div>

            <div class="flex items-center justify-end gap-2 pt-3 border-t border-gray-100 mt-4">
                <button type="button" id="modalCancelBtn" class="px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-100 font-semibold">Batal</button>
                <button type="submit" class="px-4 py-2 rounded-lg bg-[#005691] hover:bg-[#004475] text-white font-semibold shadow-sm">Simpan Case</button>
            </div>
        </form>
    </div>
</div>