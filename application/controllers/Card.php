<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Card extends CI_Controller {
    
    public function __construct() {
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model('card_model');
		$this->load->model('welcome_model');
		$this->load->model('config_model');
		$this->load->model('category_model');
 
		if($this->session->userdata("my_token") != $this->security->get_csrf_hash()){
			redirect("welcome/login");
		}
		/*
		$permission = $this->welcome_model->have_permission();
		( $permission == 0) ? redirect("welcome/no_auth") : "";
		*/
	}
	
	public function index(){
	    	$config = array();
        $config["base_url"] 	= base_url() . "card/index";
        $config["total_rows"] 	= $this->card_model->get_count_card();
        $config["per_page"] 	= 20;
        $config["uri_segment"] 	= 3;
		
		$config['full_tag_open'] = '<ul class="pagination pagination-lg justify-content-center mt-4">';        
		$config['full_tag_close'] = '</ul>';        
		$config['first_link'] = 'الصفحة الاولى';        
		$config['last_link'] = 'الصفحة الاخيرة';        
		$config['first_tag_open'] = '<li class="page-item">';        
		$config['first_tag_close'] = '</li>';        
		$config['prev_link'] = 'السابق';        
		$config['prev_tag_open'] = '<li class="page-item">';        
		$config['prev_tag_close'] = '</li>';        
		$config['next_link'] = 'التالي';        
		$config['next_tag_open'] = '<li class="page-item">';        
		$config['next_tag_close'] = '</li>';        
		$config['last_tag_open'] = '<li class="page-item">';        
		$config['last_tag_close'] = '</li>';        
		$config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="#">';        
		$config['cur_tag_close'] = '</a></li>';        
		$config['num_tag_open'] = '<li class="page-item">';        
		$config['num_tag_close'] = '</span></li>';
		
        $this->pagination->initialize($config); 
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		
        $data["links"] = $this->pagination->create_links(); 
		$data["view"] = $this->card_model->get_all_cards($config["per_page"], $page); 
		$data["page"] = "back/card/definition/index";
		$this->load->view('include/temp',$data); 
	} 
/*
		$data["view"] = $this->card_model->get_all_card();
		$data["page"] = "back/card/definition/index";
		$this->load->view('include/temp',$data); 
	}
	*/
	public function new_card(){
		$data["category"] = $this->category_model->get_category(0);
		$data["language"] = $this->config_model->get_language();
		$data["page"] = "back/card/definition/add";
		$this->load->view('include/temp',$data);
	}
	
	public function add_card(){
		$post = $this->input->post(null, true);
		
		$config['upload_path']="./upload/card/";
		$config['allowed_types']='gif|jpg|png|svg';
		$config['encrypt_name']= true; 
		$this->load->library('upload',$config);
		
		$card_pic = ""; 
		
		if($_FILES['card_pic']['name'] != ''){
			if($this->upload->do_upload("card_pic")){
				$pic = array('upload_data' => $this->upload->data()); 
				$card_pic = $config['upload_path'].$pic['upload_data']['file_name']; 
			}
		}
		
		$card_id = $this->card_model->add_card($post, $card_pic);
		if($card_id != false){
			$res = "تم اضافة بطاقة جديدة بنجاح";
			$status = "success";
			$link = "";
		} else {
			$res = "حدث خطأ اثناء حفظ التغيرات ، يرجى المحاولة مرة اخرى";
			$status = "error";
			$link = "";
		}
		echo json_encode(array("res" => $res, "status" => $status, "link" => $link));
	}
	
	public function view_card($card_id = null){
		if($card_id != null and $card_id > 0){
			$data["category"] = $this->category_model->get_category(0);
			$data["language"] = $this->config_model->get_language();
			$data["view"] = $this->card_model->get_card_id($card_id); 
			$data["page"] = "back/card/definition/view";
			$this->load->view('include/temp',$data); 
		} else {
			$this->session->set_flashdata("erorr","حدث خطأ ما اثناء التوجيه.");
			redirect("card");
		}
	} 

	public function update_card(){
		$post = $this->input->post(null, true);

		$config['upload_path']="./upload/card/";
		$config['allowed_types']='gif|jpg|png|svg';
		$config['encrypt_name']= true; 
		$this->load->library('upload',$config); 
		
		$card_pic = $post["last_card_pic"]; 
		
		if($_FILES['card_pic']['name'] != ''){
			if($this->upload->do_upload("card_pic")){
				$pic = array('upload_data' => $this->upload->data()); 
				$card_pic = $config['upload_path'].$pic['upload_data']['file_name']; 
				//remove old pic
				//unlink($post["last_card_pic"]);
			}
		}
		
		$res = $this->card_model->update_card($post, $card_pic);
		if($res != false){
			$res = "تم تعديل البطاقة الالكترونية بنجاح ";
			$status = "success";
			$link = site_url()."card";
		} else {
			$res = "حدث خطأ اثناء حفظ التغيرات ، يرجى المحاولة مرة اخرى";
			$status = "error";
			$link = "";
		}
		echo json_encode(array("res" => $res, "status" => $status, "link" => $link));
	} 

	public function update_card_status(){ 
		$card_id = $this->input->post("card_id", true); 
		$card_active = $this->input->post("card_active", true);
		
		$res = $this->card_model->update_card_status($card_active, $card_id);
		if($res != false){
			$res = "تم تغيير حالة البطاقة الالكترونية بنجاح";
			$status = "success";
			$link = "";
		} else {
			$res = "حدث خطأ اثناء حفظ التغيرات ، يرجى المحاولة مرة اخرى";
			$status = "error";
			$link = "";
		}  
		echo json_encode(array("res" => $res, "status" => $status, "link" => $link));
	}
	
	public function remove_card_id(){ 
		$card_id = $this->input->post("card_id", true);  
		
		$res = $this->card_model->remove_card_id($card_id);
		if($res != false){
			$res = " تم حذف البطاقة الالكترونية بنجاح.";
			$status = "success";
			$link = "";
		} else {
			$res = "حدث خطأ اثناء حفظ التغيرات ، يرجى المحاولة مرة اخرى";
			$status = "error";
			$link = "";
		}  
		echo json_encode(array("res" => $res, "status" => $status, "link" => $link));
	}

	function get_sub_category(){
		$category_root = $this->input->post("category_root", true);
		$category_id = $this->input->post("category_id", true);
		$view = $this->category_model->get_category($category_root);
		if(!empty($view)){ 
			$res = '<option value="" seleted disabled></option>';
			foreach($view as $v){ 
					if($category_id == $v->category_id){
						$selected = "selected";
					} else{
						$selected = "";
					}
				$res .= '<option value="'. $v->category_id .'"' .$selected .' > '. json_decode($v->category_name)->ar .' </option>';
			}
		} else {
			$res = false;
		}
		echo $res;
	}

	/*------------------------------
		Charge
	------------------------------*/
	
	public function card_charge($card_id = null){
		if($card_id  != null and $card_id > 0){
			$data["view"] = $this->card_model->get_card_charge($card_id);
			$data["card_info"] = $this->card_model->get_card_id($card_id);
			$data["page"] = "back/card/charge/card_charge";
			$this->load->view('include/temp',$data); 
		}
	}

	public function add_charge($card_id = null){
		if($card_id  != null and $card_id > 0){
			$data["card_info"] = $this->card_model->get_card_id($card_id);
			$data["page"] = "back/card/charge/add";
			$this->load->view('include/temp',$data);
		}
	}

	public function new_charge(){
		$post = $this->input->post(null, true);
		
		$card_info = $this->card_model->get_card_id($post["card_id"]);
		$old_amount = $card_info->card_amount;
		$old_price = $card_info->card_price;
		$card_id = $this->card_model->new_charge($post, $old_amount, $old_price);
		if($card_id != false){
			$res = "تم اضافة رصيد جديد بنجاح";
			$status = "success";
			$link = "";
		} else {
			$res = "حدث خطأ اثناء حفظ التغيرات ، يرجى المحاولة مرة اخرى";
			$status = "error";
			$link = "";
		}
		echo json_encode(array("res" => $res, "status" => $status, "link" => $link)); 
	}

	/*------------------------------
		Offer
	------------------------------*/
	
	public function card_offer($card_id = null){
		if($card_id  != null and $card_id > 0){
			$data["view"] = $this->card_model->get_card_offer($card_id);
			$data["card_info"] = $this->card_model->get_card_id($card_id);
			$data["have_offer"] = $this->card_model->card_have_offer($card_id);
			$data["page"] = "back/card/offer/card_offer";
			$this->load->view('include/temp',$data);
		}
	}
	public function add_offer($card_id = null){
		if($card_id  != null and $card_id > 0){
			$have_offer= $this->card_model->card_have_offer($card_id);
			if(empty($have_offer)){
				$data["card_info"] = $this->card_model->get_card_id($card_id);
				$data["page"] = "back/card/offer/add";
				$this->load->view('include/temp',$data);
			} else {
				redirect("card/card_offer/".$card_id);
			}
		}
	}
	
	public function new_offer(){
		$post = $this->input->post(null, true);
		
		$card_id = $this->card_model->new_offer($post);
		if($card_id != false){
			$res = "تم اضافة عرض جديد بنجاح";
			$status = "success";
			$link = "";
		} else {
			$res = "حدث خطأ اثناء حفظ التغيرات ، يرجى المحاولة مرة اخرى";
			$status = "error";
			$link = "";
		}
		echo json_encode(array("res" => $res, "status" => $status, "link" => $link)); 
	}

	/*------------------------------
		card_item
	------------------------------*/
	
	public function card_item($card_id = null){
		if($card_id  != null and $card_id > 0){
			$data["view"] = $this->card_model->get_card_item($card_id);
			$data["card_info"] = $this->card_model->get_card_id($card_id);
			$data["page"] = "back/card/item/index";
			$this->load->view('include/temp',$data);
		} else {
			redirect("welcome/error404");
		}
	}

	public function new_card_item($card_id = null){
		if($card_id  != null and $card_id > 0){
			$data["card_info"] = $this->card_model->get_card_id($card_id);
			$data["page"] = "back/card/item/add";
			$this->load->view('include/temp',$data);
		} else {
			redirect("welcome/error404");
		}
	}
	public function view_card_item_id($card_item_id, $card_id){
		$data["card_info"] = $this->card_model->get_card_id($card_id);
		$data["view"] = $this->card_model->get_card_item_id($card_item_id);
		$data["page"] = "back/card/item/view";
		$this->load->view('include/temp',$data);
	
	}
	
	public function add_card_item(){
		$post = $this->input->post(null, true);
		
		$this->form_validation->set_rules('card_item_code', 'كود البطاقة', 'trim|required|is_unique[card_item.card_item_code]');
		if ($this->form_validation->run() == FALSE) {
			$res = validation_errors('<div class="text-danger">', '</div>');
			$status = "error";
			$link = "";
		} else {
			$row = $this->card_model->add_card_item($post);
			if($row != false){
				$res = "تم اضافة بطاقة جديدة بنجاح";
				$status = "success";
				$link = "";
			} else {
				$res = "حدث خطأ اثناء حفظ التغيرات ، يرجى المحاولة مرة اخرى";
				$status = "error";
				$link = "";
			}
		}
		
		echo json_encode(array("res" => $res, "status" => $status, "link" => $link)); 
	}
	
	public function update_card_item(){
		$post = $this->input->post(null, true);
		 
		$row = $this->card_model->update_card_item($post);
		if($row != false){
			$res = "تم التعديل بنجاح";
			$status = "success";
			$link = "";
		} else {
			$res = "حدث خطأ اثناء حفظ التغيرات ، يرجى المحاولة مرة اخرى";
			$status = "error";
			$link = "";
		}
	 
		echo json_encode(array("res" => $res, "status" => $status, "link" => $link)); 
	}
	
	
	

}




