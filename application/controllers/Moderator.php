<?php
date_default_timezone_set('Asia/Manila');
defined('BASEPATH') OR exit('No direct script access allowed');

class Moderator extends CI_Controller {


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

	public function checkout()
	{
		$rKey = $this->input->post('rKey');

		if ($this->Crud->update('reservation',array('reservation_status'=>5),array('reservation_key'=>$rKey))) {
			echo json_encode(true);
		}else{
			echo json_encode("Failed to update reservation");
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

	public function addReservation()
	{  
		$i = $this->input->post(array('add_checkin','add_checkout','add_adultCount','add_childCount','Room_0','Room_1','add_stayType','add_request', 'add_firstname','add_lastname','add_gender','add_phone','add_address','add_email',"totalCosts" ));
		$i['Room_0'] = (int) $i['Room_0'];
		$i['Room_1'] = (int) $i['Room_1']; 
		
		$data_guest = array(
			'guest_firstname'=>$i['add_firstname'],
			'guest_lastname'=>$i['add_lastname'],
			'guest_gender'=>$i['add_gender'],
			'guest_phone'=>$i['add_phone'],
			'guest_address'=>$i['add_address'],
			'guest_email'=>$i['add_email'],
		); 
		if ($this->Crud->insert('guest',$data_guest)) {
			$last_id = $this->db->insert_id();
			$transaction_key = strtoupper(uniqid());
			$time_in = $i['add_stayType'] == 1 ? " 8:00 AM": " 6:00 PM";
			$time_out = $i['add_stayType'] == 1 ? " 5:00 PM": " 5:00 AM";

			for ($j=0; $j < 2; $j++) { 
				$data_reservation = array(
					'reservation_in'=>strtotime($i['add_checkin'].$time_in),
					'reservation_reserved_at'=>strtotime('now'),
					'reservation_updated_at'=>strtotime('now'),
					'reservation_out'=>strtotime($i['add_checkout'].$time_out),
					'reservation_adult'=>$i['add_adultCount'],
					'reservation_child'=>$i['add_childCount'],
					'reservation_roomCount'=> $j == 0 ? $i['Room_0'] : $i['Room_1'],
					'reservation_day_type'=>$i['add_stayType'],
					'reservation_status'=>1,
					'reservation_requests'=>$i['add_request'],
					'reservation_payment_status'=>1,
					'reservation_key'=> $transaction_key,
					'guest_id'=>$last_id,
					'room_type_id'=>($j+1),
				);
				$this->Crud->insert('reservation',$data_reservation);
			}

			// ADD BILLING
			$data_billing = array(
				'billing_price'=>$i['totalCosts'],
				'billing_name'=>'Reservation Fee',
				'billing_quantity'=>1,
				'reservation_key'=>$transaction_key,

			);
			$this->Crud->insert('billing',$data_billing);

			//  ADD TO ROOM
			// AVAILABLE ROOMS
			$room_1 = $this->Crud->countResult('room',array('room_type_id' => 1, 'room_status' => 3));
			$room_2 = $this->Crud->countResult('room',array('room_type_id' => 2, 'room_status' => 3));

			if ($room_1 < $i['Room_0']) {
				echo json_encode(["PROBLEM - INSUFFICIENT ROOMS","There are no enough rooms for Single Bedroom"]);  
			}else if ($room_2 < $i['Room_1']) {
				echo json_encode(["PROBLEM - INSUFFICIENT ROOMS","There are no enough rooms for Double Bedroom"]);   
			}else{

				if ($i['Room_0'] > 0) {
					$count = 1;
					$room_1_available = $this->Crud->fetch('room',array('room_type_id' => 1, 'room_status' => 3));
					foreach ($room_1_available as $key => $value) { 
						$this->Crud->update('room',array('room_status'=>1, 'reservation_key'=>$transaction_key),array('room_id'=>$value->room_id));
						if ($count == $i['Room_0']) {
							break;
						}
						$count++;
					}
				}

				if ($i['Room_1'] > 0) {
					$count = 1;
					$room_2_available = $this->Crud->fetch('room',array('room_type_id' => 2, 'room_status' => 3));
					foreach ($room_2_available as $key => $value) { 
						$this->Crud->update('room',array('room_status'=>1, 'reservation_key'=>$transaction_key),array('room_id'=>$value->room_id));
						if ($count == $i['Room_1']) {
							break;
						}
						$count++;
					}
				} 
			}

			// END NA
			echo json_encode(array(true,$transaction_key));
		}else{
			echo json_encode("Failed to add reservation");
		}




	}

	public function guestValidation()
	{ 
		$this->form_validation->set_rules('add_firstname', 'First Name', 'required|alpha');
		$this->form_validation->set_rules('add_lastname', 'Last Name', 'required|alpha'); 
		$this->form_validation->set_rules('add_gender', 'Gender', 'required'); 
		$this->form_validation->set_rules('add_phone', 'Phone Number', 'required|exact_length[11]|numeric'); 
		$this->form_validation->set_rules('add_email', 'Email', 'required|valid_email'); 
		$this->form_validation->set_rules('add_address', 'Address', 'required|alpha_numeric_spaces');  



		if ($this->form_validation->run() == FALSE){
			$errors = validation_errors();
			echo json_encode(['error'=>$this->form_validation->error_array()]);
		}else{
			echo json_encode(true); 
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

		// Miscellaneous 
		$miscs = $this->Crud->fetch_like('billing','billing_name','Misc.', array('reservation_key' => $rKey));
		$reservation->miscs = $miscs;

		// Total Billing
		$billing = $this->Crud->getSum('billing','billing_price',array('reservation_key'=>$rKey));
		$reservation->billing = $billing;
		echo json_encode($reservation);

	}

	public function addBilling()
	{
		$miscName = $this->input->post('miscName');
		$miscPrice = $this->input->post('miscPrice');
		$miscQty = $this->input->post('miscQty');
		$rKey = $this->input->post('rKey');
		$boolean = true;
		foreach ($miscName as $key => $value) {
			$data = array( 
				"billing_price"=>$miscPrice[$key],
				"billing_name"=>"Misc. ".ucwords($value),
				"billing_quantity"=>$miscQty[$key],
				"reservation_key"=>$rKey,
			);
			if (!$this->Crud->insert('billing',$data)) {
				$boolean = false;
			}
		}

		echo json_encode($boolean == true ? true : "Failed to add billing");
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