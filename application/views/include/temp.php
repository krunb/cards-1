<?php 
	$this->load->view("include/header");
	if($this->session->userdata('group_id') == 1){
		$this->load->view("include/sidebar");
	}
	$this->load->view($page);
	$this->load->view("include/footer");
?>