<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('format_rupiah')) {
    function format_rupiah($number)
    {
        return 'Rp' . number_format((float) $number, 0, ',', '.');
    }
}

if (!function_exists('stage_badge_class')) {
    /**
     * Peta nama stage -> class badge Bootstrap (dipadukan dengan class custom
     * di assets/css/dashboard.css untuk warna yang persis sesuai desain).
     */
    function stage_badge_class($stage)
    {
        $map = array(
            'Investigasi'        => 'badge-stage badge-stage-orange',
            'Review SPV'         => 'badge-stage badge-stage-navy',
            'Review Head Unit'   => 'badge-stage badge-stage-purple',
            'Konfirmasi Auditee' => 'badge-stage badge-stage-amber',
            'Telaah'             => 'badge-stage badge-stage-green',
            'Terbit BA'          => 'badge-stage badge-stage-blue',
            'Feedback'           => 'badge-stage badge-stage-teal',
            'Closed'             => 'badge-stage badge-stage-gray',
        );

        return isset($map[$stage]) ? $map[$stage] : 'badge-stage badge-stage-gray';
    }
}

if (!function_exists('progress_bar_class')) {
    /**
     * Warna progress bar Bootstrap berdasarkan persentase.
     */
    function progress_bar_class($percent)
    {
        if ($percent >= 70) return 'bg-primary';
        if ($percent >= 40) return 'bg-warning';
        return 'bg-danger';
    }
}
