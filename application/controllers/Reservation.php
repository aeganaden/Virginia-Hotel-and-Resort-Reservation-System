<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reservation extends CI_Controller {

	public function __construct() {
		parent::__construct(); 
		$this->load->model('Crud');
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
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
		$reservedDates = $this->input->post('selectedRoomsID');
		$returnValue = array(); 
		$i = 0;

		foreach ($reservedDates as $value) {
			$reservation = $this->Crud->fetch('reservation',array("reservation_id"=>$value,"reservation_status"=>1));
			if ($reservation) {
				$returnValue[$i] = array();
				foreach ($reservation as $innerValue) { 
					$returnValue[$i]['in'] = date('Y-m-d',$innerValue->reservation_in);
					$returnValue[$i]['out'] = date('Y-m-d',$innerValue->reservation_out);
				}
			}
		}

		echo json_encode($returnValue);
	}

	public function addReservation()
	{
		$i = $this->input->post(array('checkin','checkout','inputAdult','inputChild','allReservedRoomQty','stayTypeChk','comment','allReservedRoomType', 'fname','lname','gender','phone','address','email' ));
		$data_guest = array(
			'guest_firstname'=>$i['fname'],
			'guest_lastname'=>$i['lname'],
			'guest_gender'=>$i['gender'],
			'guest_phone'=>$i['phone'],
			'guest_address'=>$i['address'],
			'guest_email'=>$i['email'],
		);

		if ($this->Crud->insert('guest',$data_guest)) {
			$last_id = $this->db->insert_id();
			$transaction_key = strtoupper(uniqid());
			foreach ($i['allReservedRoomType'] as $key => $value) { 
				$data_reservation = array(
					'reservation_in'=>strtotime($i['checkin']),
					'reservation_out'=>strtotime($i['checkout']),
					'reservation_adult'=>$i['inputAdult'],
					'reservation_child'=>$i['inputChild'],
					'reservation_roomCount'=>$i['allReservedRoomQty'][$key],
					'reservation_day_type'=>$i['stayTypeChk'],
					'reservation_status'=>2,
					'reservation_requests'=>$i['comment'],
					'reservation_key'=> $transaction_key,
					'guest_id'=>$last_id,
					'room_type_id'=>$value,
				);
				$this->Crud->insert('reservation',$data_reservation);
				
			}

			echo json_encode(array(true,$transaction_key));
		}else{
			echo json_encode("Failed to add reservation");
		}

	}

	public function viewReservation()
	{
		if ($this->uri->segment(3)) {
			$title = "My Reservations";
			$transactionID = $this->uri->segment(3);
			$this->load->view('includes/materialize/header', compact('title','transactionID'));
			$this->load->view('myreservations');
			$this->load->view('includes/materialize/header');
		}else{
			redirect('Welcome');
		}
	}

	public function reservationExists()
	{
		$transactionID = $this->input->post('transactionID');
		if ($this->Crud->fetch('reservation',array('reservation_key'=>$transactionID))) {
			echo json_encode(true);
		}else{
			echo json_encode(false);
		}
	}

}

/* End of file Reservation.php */
/* Location: ./application/controllers/Reservation.php */