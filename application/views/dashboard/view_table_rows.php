<?php if (!function_exists('format_rupiah')): $this->load->helper('dashboard'); endif; ?>

<?php if (empty($case_list)): ?>
    <tr>
        <td colspan="11" class="text-center text-gray-500 py-8">Tidak ada kasus yang cocok dengan filter saat ini.</td>
    </tr>
<?php else: ?>
    <?php foreach ($case_list as $case): ?>
        <tr class="hover:bg-gray-50">
            <td>
                <button type="button" class="row-expand-btn text-navy text-sm" aria-label="Lihat detail">
                    <i class="bi bi-chevron-down"></i>
                </button>
            </td>
            <td class="font-semibold"><?= htmlspecialchars($case['invoice']) ?></td>
            <td><span class="badge-source"><i class="bi bi-database-fill"></i> <?= htmlspecialchars($case['sumber']) ?></span></td>
            <td><?= htmlspecialchars($case['kategori']) ?></td>
            <td>
                <div class="font-semibold"><?= htmlspecialchars($case['proyek']) ?></div>
                <div class="text-xs text-gray-500"><?= htmlspecialchars($case['auditee']) ?></div>
            </td>
            <td><?= format_rupiah($case['nilai']) ?></td>
            <td><span class="<?= stage_badge_class($case['stage']) ?>"><?= htmlspecialchars($case['stage']) ?></span></td>
            <td><?= htmlspecialchars($case['deadline']) ?></td>
            <td>
                <div class="flex items-center gap-2 min-w-[130px]">
                    <div class="progress-track">
                        <div class="progress-fill <?= progress_bar_class($case['progress']) ?>" style="width: <?= (int) $case['progress'] ?>%;"></div>
                    </div>
                    <span class="text-xs font-semibold text-brand min-w-[32px]"><?= (int) $case['progress'] ?>%</span>
                </div>
            </td>
            <td><?= htmlspecialchars($case['auditor_pic']) ?></td>
            <td>
                <div class="flex items-center gap-2.5">
                    <span><?= htmlspecialchars($case['target_actual']) ?></span>
                    <a href="<?= site_url('dashboard/edit/' . $case['invoice']) ?>" class="edit-btn" aria-label="Edit case">
                        <i class="bi bi-pencil-fill"></i>
                    </a>
                </div>
            </td>
        </tr>
    <?php endforeach; ?>
<?php endif; ?>
