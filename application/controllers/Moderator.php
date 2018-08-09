<?php
date_default_timezone_set('Asia/Manila');
defined('BASEPATH') OR exit('No direct script access allowed');

class Moderator extends CI_Controller {


	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->model('Crud'); 
	}

	public function index()
	{
		$moderData = $this->session->userdata('moderdata'); 
		if (!$moderData) {
			$title = "Moderator - Login";
			$this->load->view('includes/materialize/header',compact('title'));
			$this->load->view('moderator/login'); 
			$this->load->view('includes/materialize/footer');
		}else{
			$title = "Moderator - Home";
			$this->load->view('includes/materialize/header',compact('title','moderData'));
			$this->load->view('moderator/moderator'); 
			$this->load->view('includes/materialize/footer');
		}


	}

	public function fetchReservations()
	{
		$start = $this->input->post('start');
		$end = $this->input->post('end'); 
		$data = $this->Crud->fetchDateBetween('reservation',$start,$end);
		$allData = array();

		$previousValue = null;

		foreach ($data as $key => $value) {
			if ($value->reservation_key!=$previousValue) {
				array_push($allData, $value);
			}
			$previousValue = $value->reservation_key;
		}
		if ($allData) {
			echo json_encode($allData);
		}
	}

	public function fetchReservationDetails()
	{
		$rKey = $this->input->post('rKey');

		$reservation = $this->Crud->fetch('reservation',array('reservation_key'=>$rKey)); 
		$reservation_1 = $reservation[1];
		$reservation = $reservation[0];



		// STAY TYPE
		$stay_type = $reservation->reservation_day_type == 1 ? "Day Stay" : "Night Stay"; 
		$reservation->stay_type = $stay_type; 

		// LENGTH OF STAY
		$datetime1 = new DateTime(date('Y-m-d',$reservation->reservation_in)); 
		$datetime2 = new DateTime(date('Y-m-d',$reservation->reservation_out));
		$difference = $datetime1->diff($datetime2);
		$reservation->stay_length = $difference->d+1;

		// ROOM TYPE
		$room_types = $this->Crud->fetch('room_type');
		$reservation->room_1_type = $room_types[0]->room_type_name;
		$reservation->room_2_type = $room_types[1]->room_type_name;

		// Room 2 Count
		$reservation->room_2 = $reservation_1->reservation_roomCount;

		echo json_encode($reservation);

	}


	public function checkCredentials()
	{ 
		$username = $this->input->post('username');	
		$password = sha1($this->input->post('password'));	
		$data = array(
			'moderator_username' => $username,
			'moderator_password' => $password,
		);

		if ($data = $this->Crud->fetch('moderator',$data)) {
			$sessionData = array(
				'logged_in' => true,
				'data' => $data,
			);
			$this->session->set_userdata('moderdata', $sessionData);
			redirect('Moderator');
		}else{
			$this->session->set_flashdata('error', 'Account Credentials are incorrect.');
			redirect('Moderator');
		}
	}

	public function approveReservation()
	{
		$r_key = $this->input->post('rKey'); 
		$reservations = $this->Crud->fetch('reservation',array('reservation_key'=>$r_key));

		// USER ROOM COUNT
		$roomCount = array();
		foreach ($reservations as $key => $value) {
			array_push($roomCount, $value->reservation_roomCount);
		}

		// AVAILABLE ROOMS
		$room_1 = $this->Crud->countResult('room',array('room_type_id' => 1, 'room_status' => 3));
		$room_2 = $this->Crud->countResult('room',array('room_type_id' => 2, 'room_status' => 3));

		// echo json_encode("TANGINA MO"); 
		if ($room_1 < $roomCount[0]) {
			echo json_encode(["PROBLEM - INSUFFICIENT ROOMS","There are no enough rooms for Single Bedroom"]);  
		}else if ($room_2 < $roomCount[1]) {
			echo json_encode(["PROBLEM - INSUFFICIENT ROOMS","There are no enough rooms for Double Bedroom"]);   
		}else{
			
			if ($roomCount[0] > 0) {
				$i = 1;
				$room_1_available = $this->Crud->fetch('room',array('room_type_id' => 1, 'room_status' => 3));
				foreach ($room_1_available as $key => $value) { 
					$this->Crud->update('room',array('room_status'=>1, 'reservation_key'=>$r_key),array('room_id'=>$value->room_id));
					if ($i == $roomCount[0]) {
						break;
					}
					$i++;
				}
			}
			
			if ($roomCount[1] > 0) {
				$i = 1;
				$room_2_available = $this->Crud->fetch('room',array('room_type_id' => 2, 'room_status' => 3));
				foreach ($room_2_available as $key => $value) { 
					$this->Crud->update('room',array('room_status'=>1, 'reservation_key'=>$r_key),array('room_id'=>$value->room_id));
					if ($i == $roomCount[1]) {
						break;
					}
					$i++;
				}
			}

			if ($this->Crud->update('reservation',array('reservation_status'=>1),array('reservation_key'=>$r_key))) {
				echo json_encode(true);
			}else{
				echo json_encode("Failed to update reservation");
			}
		}


		
	}

	public function denyReservation()
	{
		$key = $this->input->post('rKey');

		if ($this->Crud->update('reservation',array('reservation_status'=>3),array('reservation_key'=>$key))) {
			echo json_encode(true);
		}else{
			echo json_encode("Failed to update reservation");
		}
	}

	public function logout()
	{
		$this->session->unset_userdata('moderdata');
		redirect('Welcome');
	}

}

/* End of file Moderator.php */
			/* Location: ./application/controllers/Moderator.php */