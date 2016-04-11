<?php $this->load->view('layout/header'); ?>
<?php 
if(isset($create) || isset($update)){
    $this->load->view('layout/create_kapal_view');
} else 
$this->load->view('layout/kapal_view');
?>
<?php $this->load->view('layout/footer'); ?>
