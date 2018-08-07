<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->model('Crud');
		$this->load->library('form_validation'); 
		$this->load->helper('form');
	}

	public function index()
	{
		$userData = $this->session->userdata('userdata');
		if (!$userData) {
			$title = "Admin - Login";
			$this->load->view('includes/materialize/header',compact('title'));
			$this->load->view('admin/login'); 
			$this->load->view('includes/materialize/footer');
		}else{
			$title = "Admin - Home";
			$this->load->view('includes/materialize/header',compact('title'));
			$this->load->view('admin/admin'); 
			$this->load->view('includes/materialize/footer');
		}
	}

	public function checkCredentials()
	{ 
		$username = $this->input->post('username');	
		$password = sha1($this->input->post('password'));	
		$data = array(
			'admin_username' => $username,
			'admin_password' => $password,
		);

		if ($data = $this->Crud->fetch('admin',$data)) {
			$sessionData = array(
				'logged_in' => true,
				'data' => $data,
			);
			$this->session->set_userdata('userdata', $sessionData);
			redirect('Admin');
		}else{
			$this->session->set_flashdata('error', 'Account Credentials are incorrect.');
			redirect('Admin');
		}
	}

	public function addModerator()
	{
		$this->form_validation->set_rules('first_name', 'First Name', 'required');
		$this->form_validation->set_rules('last_name', 'Last Name', 'required'); 
		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');
		$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required');


		if ($this->form_validation->run() == FALSE){
			$errors = validation_errors();
			echo json_encode(['error'=>$errors]);
		}else{
			echo json_encode(['success'=>'Record added successfully.']);
		}

	}

	public function logout()
	{
		$this->session->unset_userdata('userdata');
		redirect('Welcome');
	}

}

/* End of file Admin.php */
/* Location: ./application/controllers/Admin.php */