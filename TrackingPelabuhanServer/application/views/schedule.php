<?php $this->load->view('layout/header'); ?>
<?php
if(isset($create) || isset($update)){
    $this->load->view('layout/create_schedule_view');
} else
    $this->load->view('layout/schedule_view');
?>
<?php $this->load->view('layout/footer'); ?>
