<!DOCTYPE html>
<html lang="id">
<head>
<?php $this->load->view('layouts/header'); ?>
</head>
<body class="bg-[#f5f7fa] font-sans text-gray-800 antialiased min-h-screen flex flex-col">

<?php $this->load->view('layouts/navbar'); ?>

<main class="flex-1 px-6 py-6 max-w-[1440px] w-full mx-auto">
    <?php $this->load->view($content); ?>
</main>

<?php $this->load->view('layouts/footer'); ?>
<?php $this->load->view('layouts/scripts'); ?>

</body>
</html>