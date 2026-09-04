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
                <?php if (!empty($auditors)): ?>
                    <?php foreach ($auditors as $aud): ?>
                        <option value="<?= htmlspecialchars($aud->name) ?>" <?= ($filters['auditor'] == $aud->name) ? 'selected' : '' ?>><?= htmlspecialchars($aud->name) ?></option>
                    <?php endforeach; ?>
                <?php else: ?>
                    <option value="Budi Santoso" <?= ($filters['auditor'] == 'Budi Santoso') ? 'selected' : '' ?>>Budi Santoso</option>
                <?php endif; ?>
            </select>
            <i class="bi bi-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 text-[10px] pointer-events-none"></i>
        </div>

        <!-- Dropdown Kategori -->
        <div class="relative">
            <select name="kategori" class="bg-white border border-gray-200 rounded-full px-4 py-2 pr-8 text-xs font-medium text-gray-700 focus:outline-none focus:border-[#005691] appearance-none cursor-pointer">
                <option value="">Semua Kategori</option>
                <?php if (!empty($categories)): ?>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?= htmlspecialchars($cat['kategori']) ?>" <?= ($filters['kategori'] == $cat['kategori']) ? 'selected' : '' ?>><?= htmlspecialchars($cat['kategori']) ?></option>
                    <?php endforeach; ?>
                <?php else: ?>
                    <option value="Piutang ECES" <?= ($filters['kategori'] == 'Piutang ECES') ? 'selected' : '' ?>>Piutang ECES</option>
                <?php endif; ?>
            </select>
            <i class="bi bi-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 text-[10px] pointer-events-none"></i>
        </div>

        <!-- Dropdown Stage -->
        <div class="relative">
            <select name="stage" class="bg-white border border-gray-200 rounded-full px-4 py-2 pr-8 text-xs font-medium text-gray-700 focus:outline-none focus:border-[#005691] appearance-none cursor-pointer">
                <option value="">Semua Stage</option>
                <?php if (!empty($stages)): ?>
                    <?php foreach ($stages as $stg): ?>
                        <option value="<?= htmlspecialchars($stg->nama_stage) ?>" <?= ($filters['stage'] == $stg->nama_stage) ? 'selected' : '' ?>><?= htmlspecialchars($stg->nama_stage) ?></option>
                    <?php endforeach; ?>
                <?php else: ?>
                    <option value="Investigasi" <?= ($filters['stage'] == 'Investigasi') ? 'selected' : '' ?>>Investigasi</option>
                    <option value="Review SPV" <?= ($filters['stage'] == 'Review SPV') ? 'selected' : '' ?>>Review SPV</option>
                    <option value="Review Head Unit" <?= ($filters['stage'] == 'Review Head Unit') ? 'selected' : '' ?>>Review Head Unit</option>
                    <option value="Konfirmasi Auditee" <?= ($filters['stage'] == 'Konfirmasi Auditee') ? 'selected' : '' ?>>Konfirmasi Auditee</option>
                    <option value="Telaah" <?= ($filters['stage'] == 'Telaah') ? 'selected' : '' ?>>Telaah</option>
                    <option value="Terbit BA" <?= ($filters['stage'] == 'Terbit BA') ? 'selected' : '' ?>>Terbit BA</option>
                    <option value="Feedback" <?= ($filters['stage'] == 'Feedback') ? 'selected' : '' ?>>Feedback</option>
                    <option value="Closed" <?= ($filters['stage'] == 'Closed') ? 'selected' : '' ?>>Closed</option>
                <?php endif; ?>
            </select>
            <i class="bi bi-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 text-[10px] pointer-events-none"></i>
        </div>

        <!-- Dropdown Sumber -->
        <div class="relative">
            <select name="sumber" class="bg-white border border-gray-200 rounded-full px-4 py-2 pr-8 text-xs font-medium text-gray-700 focus:outline-none focus:border-[#005691] appearance-none cursor-pointer">
                <option value="">Semua Sumber</option>
                <?php if (!empty($sources)): ?>
                    <?php foreach ($sources as $src): ?>
                        <option value="<?= htmlspecialchars($src['sumber']) ?>" <?= ($filters['sumber'] == $src['sumber']) ? 'selected' : '' ?>><?= htmlspecialchars($src['sumber']) ?></option>
                    <?php endforeach; ?>
                <?php else: ?>
                    <option value="ECES" <?= ($filters['sumber'] == 'ECES') ? 'selected' : '' ?>>ECES</option>
                <?php endif; ?>
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
                                            $stages_list = array(
                                                array('name' => 'Investigasi', 'icon' => 'bi-file-earmark-text'),
                                                array('name' => 'Review SPV',  'icon' => 'bi-x-circle'),
                                                array('name' => 'Review Head', 'icon' => 'bi-check-circle'),
                                                array('name' => 'Auditee',     'icon' => 'bi-chat-square-text'),
                                                array('name' => 'Telaah',      'icon' => 'bi-search'),
                                                array('name' => 'Terbit BA',   'icon' => 'bi-person-vcard'),
                                                array('name' => 'Feedback',    'icon' => 'bi-chat-heart'),
                                                array('name' => 'Closed',      'icon' => 'bi-list-check'),
                                            );
                                            $current_step = 0; // index tahap yang sedang aktif
                                            foreach ($stages_list as $i => $stage):
                                                $is_active = ($i === $current_step);
                                                $is_done   = ($i < $current_step);
                                            ?>
                                                <div class="flex flex-col items-center z-10">
                                                    <div class="w-10 h-10 rounded-full flex items-center justify-center text-base transition-all
                        <?= $is_active
                                                    ? 'border-2 border-orange-500 bg-white text-orange-500 shadow-sm'
                                                    : ($is_done
                                                        ? 'border-2 border-orange-500 bg-orange-500 text-white'
                                                        : 'border border-gray-200 bg-white text-gray-300') ?>">
                                                        <i class="bi <?= $stage['icon'] ?>"></i>
                                                    </div>
                                                    <span class="text-[11px] mt-2 block text-center whitespace-nowrap
                        <?= $is_active ? 'font-semibold text-orange-500' : 'font-medium text-gray-400' ?>">
                                                        <?= $stage['name'] ?>
                                                    </span>
                                                </div>

                                                <?php if ($i < count($stages_list) - 1): ?>
                                                    <div class="flex-1 h-[2px] bg-gray-200 mx-1 -mt-5"></div>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </div>

                                    </div>
                                    <div class="flex justify-end mt-4">
                                        <button type="button" class="btn-open-upload bg-[#005691] hover:bg-[#004475] text-white text-xs font-semibold px-3.5 py-2 rounded-lg flex items-center gap-1.5 transition-colors" data-invoice="<?= htmlspecialchars($row['invoice']) ?>" data-stage="<?= htmlspecialchars($row['stage']) ?>" data-stage-color="<?= htmlspecialchars($row['stage_color']) ?>">
                                            + Update
                                        </button>
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
    <?php
        $curr = isset($current_page) ? (int)$current_page : 1;
        $tot_pages = isset($total_pages) ? (int)$total_pages : 1;
        $query_params = $_GET;
    ?>
    <div class="flex flex-wrap items-center justify-between gap-3 mt-4 pt-2">
        <?php if ($curr > 1): 
            $query_params['page'] = $curr - 1;
        ?>
            <a href="<?= site_url('dashboard?' . http_build_query($query_params)) ?>" class="border border-gray-200 bg-white hover:bg-gray-50 text-gray-600 text-xs font-semibold px-3.5 py-1.5 rounded-lg flex items-center gap-1.5 transition-colors">
                <i class="bi bi-arrow-left"></i> Previous
            </a>
        <?php else: ?>
            <span class="border border-gray-200 bg-gray-50 text-gray-400 text-xs font-semibold px-3.5 py-1.5 rounded-lg flex items-center gap-1.5 cursor-not-allowed">
                <i class="bi bi-arrow-left"></i> Previous
            </span>
        <?php endif; ?>

        <div class="flex items-center gap-1">
            <?php for ($p = 1; $p <= $tot_pages; $p++): 
                $query_params['page'] = $p;
            ?>
                <?php if ($p == $curr): ?>
                    <span class="w-7 h-7 rounded-lg border border-[#005691] text-[#005691] bg-white font-bold text-xs flex items-center justify-center shadow-xs"><?= $p ?></span>
                <?php else: ?>
                    <a href="<?= site_url('dashboard?' . http_build_query($query_params)) ?>" class="w-7 h-7 rounded-lg text-gray-600 hover:bg-gray-100 font-medium text-xs flex items-center justify-center"><?= $p ?></a>
                <?php endif; ?>
            <?php endfor; ?>
        </div>

        <?php if ($curr < $tot_pages): 
            $query_params['page'] = $curr + 1;
        ?>
            <a href="<?= site_url('dashboard?' . http_build_query($query_params)) ?>" class="border border-gray-200 bg-white hover:bg-gray-50 text-gray-600 text-xs font-semibold px-3.5 py-1.5 rounded-lg flex items-center gap-1.5 transition-colors">
                Next <i class="bi bi-arrow-right"></i>
            </a>
        <?php else: ?>
            <span class="border border-gray-200 bg-gray-50 text-gray-400 text-xs font-semibold px-3.5 py-1.5 rounded-lg flex items-center gap-1.5 cursor-not-allowed">
                Next <i class="bi bi-arrow-right"></i>
            </span>
        <?php endif; ?>
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
                <input type="text" name="judul_case" id="inputJudulCase" required placeholder="Nama/Judul Case..." class="w-full border-0 border-b border-gray-200 focus:border-[#005691] focus:ring-0 text-base font-medium text-gray-800 placeholder-gray-400 py-1.5 focus:outline-none">
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
                        <select name="project_name" id="selectProyek" class="w-full bg-white border border-gray-200 rounded-xl px-3.5 py-2 pr-8 text-xs text-gray-700 focus:outline-none focus:border-[#005691] appearance-none cursor-pointer">
                            <option value="" disabled selected>Pilih proyek/area/unit bisnis</option>
                            <?php if (!empty($projects)): ?>
                                <?php foreach ($projects as $prj): ?>
                                    <option value="<?= htmlspecialchars(is_array($prj) ? $prj['project_name'] : $prj->project_name) ?>"><?= htmlspecialchars(is_array($prj) ? $prj['project_name'] : $prj->project_name) ?></option>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <option value="Arjawinangun 1 T3">Arjawinangun 1 T3</option>
                                <option value="Arjawinangun By Pass">Arjawinangun By Pass</option>
                                <option value="RN Gegunung">RN Gegunung</option>
                                <option value="RN Ningrat">RN Ningrat</option>
                                <option value="RN Pejambon">RN Pejambon</option>
                                <option value="Trusmiland 5">Trusmiland 5</option>
                            <?php endif; ?>
                        </select>
                        <i class="bi bi-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 text-[10px] pointer-events-none"></i>
                    </div>
                </div>

                <!-- Nilai Temuan (Rp) -->
                <div class="grid grid-cols-[150px_12px_1fr] items-center text-xs">
                    <label class="font-medium text-gray-700 flex items-center gap-2">
                        <i class="bi bi-cash-stack text-gray-400 text-sm shrink-0"></i>
                        <span>Nilai Temuan (Rp)</span>
                    </label>
                    <span class="text-gray-400 font-medium">:</span>
                    <div>
                        <input type="number" name="nilai" id="inputNilai" placeholder="0" class="w-full bg-white border border-gray-200 rounded-xl px-3.5 py-2 text-xs text-gray-700 placeholder-gray-400 focus:outline-none focus:border-[#005691]">
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

<!-- ============ MODAL UPLOAD DOKUMEN ============ -->
<div id="modalUploadDokumen" class="fixed inset-0 z-50 hidden bg-black/60 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-[560px] w-full shadow-2xl border border-gray-100 flex flex-col overflow-hidden">
        
        <!-- Header -->
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
            <h3 class="font-bold text-sm text-gray-800">
                Upload Dokumen Investigasi
            </h3>
            <button type="button" id="uploadModalCloseX" class="text-gray-400 hover:text-gray-600 text-lg p-1 focus:outline-none cursor-pointer">
                <i class="bi bi-x-lg text-sm"></i>
            </button>
        </div>

        <!-- Content -->
        <div class="p-6 space-y-4">
            <!-- Case & Stage Row -->
            <div class="flex items-center text-xs text-gray-600">
                <span class="font-medium">Case:</span>
                <span id="uploadModalBadge" class="text-white text-[10px] font-semibold px-2.5 py-0.5 rounded-full ml-2">Investigasi</span>
                <span id="uploadModalInvoice" class="font-bold text-gray-800 ml-2">AUD-2026-004</span>
            </div>

            <!-- Warning Alert Block -->
            <div id="uploadModalAlert" class="bg-orange-50/50 border border-orange-100 rounded-xl p-3.5 text-xs text-orange-600 leading-relaxed">
                Upload dokumen olahan data investigasi. Setelah submit diteruskan ke SPV untuk direview.
            </div>

            <!-- Dotted Divider -->
            <div class="border-t border-dashed border-gray-200"></div>

            <!-- Drag & Drop / Selection Area -->
            <div id="uploadDropzone" class="border-2 border-dashed border-gray-200 hover:border-blue-400 hover:bg-blue-50/10 rounded-xl p-8 flex flex-col items-center justify-center cursor-pointer transition-colors bg-gray-50/30">
                <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center mb-3">
                    <i class="bi bi-cloud-arrow-up text-gray-500 text-lg"></i>
                </div>
                <span class="text-xs text-gray-500 text-center">
                    <span class="text-[#005691] font-semibold hover:underline">Klik untuk mengunggah</span> atau seret dan lepas
                </span>
                <span class="text-[10px] text-gray-400 mt-1 block">PDF, PNG, JPG, atau DOCX (maks. 10MB)</span>
                <input type="file" id="fileUploadInput" class="hidden" accept=".pdf,.png,.jpg,.jpeg,.docx,.xlsx">
            </div>

            <!-- File Uploaded Card (Hidden by default) -->
            <div id="fileStatusCard" class="hidden border border-blue-200 rounded-xl p-4 bg-blue-50/5 flex flex-col space-y-3">
                <div class="flex items-center">
                    <div class="w-8 h-8 rounded-lg bg-blue-50 text-[#005691] flex items-center justify-center shrink-0">
                        <i id="fileIcon" class="bi bi-file-earmark-pdf-fill text-lg"></i>
                    </div>
                    <div class="flex-1 min-w-0 ml-3">
                        <div id="fileName" class="font-semibold text-gray-800 text-xs truncate">Tech design requirements.pdf</div>
                        <div id="fileSize" class="text-[10px] text-gray-400">200 KB</div>
                    </div>
                    <i id="fileCheckIcon" class="bi bi-check-circle-fill text-[#005691] text-base ml-2 shrink-0 opacity-0 transition-opacity duration-300"></i>
                </div>
                
                <!-- Progress bar -->
                <div class="flex items-center gap-3">
                    <div class="flex-1 h-1.5 bg-gray-100 rounded-full overflow-hidden">
                        <div id="uploadProgressBar" class="h-full bg-[#005691] rounded-full transition-all duration-300" style="width: 0%"></div>
                    </div>
                    <span id="uploadProgressPercent" class="text-[10px] font-semibold text-gray-500 shrink-0">0%</span>
                </div>

                <!-- Card Actions -->
                <div class="flex items-center justify-end gap-3 text-[11px] font-semibold pt-1">
                    <button type="button" id="removeFileBtn" class="text-red-500 hover:text-red-600 flex items-center gap-1 cursor-pointer">
                        <i class="bi bi-trash"></i> Hapus
                    </button>
                    <button type="button" id="changeFileBtn" class="text-[#005691] hover:text-[#004475] flex items-center gap-1 cursor-pointer">
                        <i class="bi bi-arrow-repeat"></i> Ganti
                    </button>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="flex items-center justify-end gap-3 px-6 py-4 border-t border-gray-100 bg-gray-50/50">
            <button type="button" id="uploadModalCancel" class="border border-gray-200 bg-white hover:bg-gray-50 text-gray-700 font-semibold px-5 py-2 rounded-xl text-xs transition-colors cursor-pointer">
                Batal
            </button>
            <button type="button" id="submitUploadBtn" class="bg-[#a5c3db] pointer-events-none text-white font-semibold px-5 py-2 rounded-xl text-xs transition-all shadow-sm">
                Konfirmasi & Submit
            </button>
        </div>
    </div>
</div>