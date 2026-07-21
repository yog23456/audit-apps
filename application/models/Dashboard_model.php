<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_pipeline_summary()
    {
        return array(
            array('role' => 'Auditor',    'label' => 'Investigasi', 'icon' => 'person-vcard',        'total' => 25, 'ontime' => 16, 'late' => 2),
            array('role' => 'SPV Audit',  'label' => 'Review SPV',  'icon' => 'arrow-repeat',         'total' => 25, 'ontime' => 16, 'late' => 2),
            array('role' => 'Head Audit', 'label' => 'Review Head', 'icon' => 'check-circle',        'total' => 25, 'ontime' => 16, 'late' => 2),
            array('role' => 'Auditee',    'label' => 'Konfirmasi',  'icon' => 'chat-left-dots',      'total' => 25, 'ontime' => 16, 'late' => 2),
            array('role' => 'Auditor',    'label' => 'Telaah',      'icon' => 'search',              'total' => 25, 'ontime' => 16, 'late' => 2),
            array('role' => 'SPV Audit',  'label' => 'Terbit BA',   'icon' => 'file-earmark-check',  'total' => 25, 'ontime' => 16, 'late' => 2),
            array('role' => 'Auditee',    'label' => 'Feedback',    'icon' => 'at',                  'total' => 25, 'ontime' => 16, 'late' => 2),
            array('role' => 'Selesai',    'label' => 'Closed',      'icon' => 'card-checklist',      'total' => 25, 'ontime' => 16, 'late' => 2),
        );
    }

    public function get_case_list($filters = array(), $limit = 7, $offset = 0)
    {
        return array(
            array(
                'invoice' => 'AUD-2026-001', 'sumber' => 'ECES', 'kategori' => 'Piutang ECES',
                'proyek' => 'Arjawinangun 1 T3', 'auditee' => 'Sukendra', 'nilai' => 10960000,
                'stage' => 'Review SPV', 'stage_color' => 'bg-[#004b87]', 'deadline' => '-',
                'progress' => 10, 'progress_color' => 'bg-red-500 text-red-500',
                'auditor_pic' => 'Budi Santoso', 'target_actual' => '2026-04-21', 'expanded' => true
            ),
            array(
                'invoice' => 'AUD-2026-002', 'sumber' => 'ECES', 'kategori' => 'Piutang ECES',
                'proyek' => 'Arjawinangun By Pass', 'auditee' => 'Sukendra', 'nilai' => 10288400,
                'stage' => 'Telaah', 'stage_color' => 'bg-[#10b981]', 'deadline' => '-',
                'progress' => 80, 'progress_color' => 'bg-[#005691] text-[#005691]',
                'auditor_pic' => 'Budi Santoso', 'target_actual' => '2026-04-21', 'expanded' => false
            ),
            array(
                'invoice' => 'AUD-2026-003', 'sumber' => 'ECES', 'kategori' => 'Piutang ECES',
                'proyek' => 'RN Gegunung', 'auditee' => 'Trisno', 'nilai' => 4834000,
                'stage' => 'Review Head Unit', 'stage_color' => 'bg-[#5b3fa6]', 'deadline' => '-',
                'progress' => 60, 'progress_color' => 'bg-[#f97316] text-[#f97316]',
                'auditor_pic' => 'Budi Santoso', 'target_actual' => '2026-04-21', 'expanded' => false
            ),
            array(
                'invoice' => 'AUD-2026-004', 'sumber' => 'ECES', 'kategori' => 'Piutang ECES',
                'proyek' => 'RN Ningrat', 'auditee' => 'Karya Wiguna', 'nilai' => 6350000,
                'stage' => 'Konfirmasi Auditee', 'stage_color' => 'bg-[#f97316]', 'deadline' => '-',
                'progress' => 60, 'progress_color' => 'bg-[#f97316] text-[#f97316]',
                'auditor_pic' => 'Budi Santoso', 'target_actual' => '2026-04-21', 'expanded' => false
            ),
            array(
                'invoice' => 'AUD-2026-005', 'sumber' => 'ECES', 'kategori' => 'Piutang ECES',
                'proyek' => 'RN Pejambon', 'auditee' => 'Ridwanuddin', 'nilai' => 10960000,
                'stage' => 'Terbit BA', 'stage_color' => 'bg-[#2563eb]', 'deadline' => '-',
                'progress' => 80, 'progress_color' => 'bg-[#005691] text-[#005691]',
                'auditor_pic' => 'Budi Santoso', 'target_actual' => '2026-04-21', 'expanded' => false
            ),
            array(
                'invoice' => 'AUD-2026-005', 'sumber' => 'ECES', 'kategori' => 'Piutang ECES',
                'proyek' => 'Arjawinangun By Pass', 'auditee' => 'Sukendra', 'nilai' => 0,
                'stage' => 'Closed', 'stage_color' => 'bg-[#9ca3af]', 'deadline' => '-',
                'progress' => 100, 'progress_color' => 'bg-[#005691] text-[#005691]',
                'auditor_pic' => 'Budi Santoso', 'target_actual' => '2026-04-21', 'expanded' => false
            ),
            array(
                'invoice' => 'AUD-2026-005', 'sumber' => 'ECES', 'kategori' => 'Piutang ECES',
                'proyek' => 'Trusmiland 5', 'auditee' => 'CV Berlian Alam', 'nilai' => 1730000,
                'stage' => 'Investigasi', 'stage_color' => 'bg-[#f59e0b]', 'deadline' => '-',
                'progress' => 60, 'progress_color' => 'bg-red-500 text-red-500',
                'auditor_pic' => 'Budi Santoso', 'target_actual' => '2026-04-21', 'expanded' => false
            ),
        );
    }

    public function count_case_list($filters = array())
    {
        return 24;
    }

    public function insert_case_manual($data)
    {
        return true;
    }
}
