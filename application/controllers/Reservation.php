<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reservation extends CI_Controller {

	public function __construct() {
		parent::__construct(); 
		$this->load->model('Crud');
	}

	public function index()
	{
		$dateFrom = $this->input->post('date-from');
		$dateTo = $this->input->post('date-to');
		$title = "Reservation - Virginia and Boy Lodge and Resort";

		// Fetch room type
		$roomType = $this->Crud->fetch('room_type'); 

		$this->load->view('includes/header',compact('title','dateTo','dateFrom','roomType'));
		$this->load->view('reservation/index'); 
		$this->load->view('includes/footer');
	}

	public function checkReservation()
	{
		$dateIn = $this->input->post('dateIn');
		$dateOut = $this->input->post('dateOut');

		echo json_encode($dateIn);
	}

}

/* End of file Reservation.php */
/* Location: ./application/controllers/Reservation.php */