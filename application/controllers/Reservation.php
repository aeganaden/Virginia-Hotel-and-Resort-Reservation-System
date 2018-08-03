<?php
date_default_timezone_set('Asia/Manila');
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
		$i = $this->input->post(array('checkin','checkout','inputAdult','inputChild','allReservedRoomQty','stayTypeChk','comment','allReservedRoomType', 'fname','lname','gender','phone','address','email',"totalCharge" ));
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

			for ($j=0; $j < 2; $j++) { 
				$data_reservation = array(
					'reservation_in'=>strtotime($i['checkin']),
					'reservation_reserved_at'=>strtotime('now'),
					'reservation_updated_at'=>strtotime('now'),
					'reservation_out'=>strtotime($i['checkout']),
					'reservation_adult'=>$i['inputAdult'],
					'reservation_child'=>$i['inputChild'],
					'reservation_roomCount'=>isset($i['allReservedRoomQty'][$j]) ? $i['allReservedRoomQty'][$j] : 0,
					'reservation_day_type'=>$i['stayTypeChk'],
					'reservation_status'=>2,
					'reservation_requests'=>$i['comment'],
					'reservation_key'=> $transaction_key,
					'guest_id'=>$last_id,
					'room_type_id'=>($j+1),
				);
				$this->Crud->insert('reservation',$data_reservation);
			}

			// foreach ($i['allReservedRoomType'] as $key => $value) { 
			// 	$data_reservation = array(
			// 		'reservation_in'=>strtotime($i['checkin']),
			// 		'reservation_reserved_at'=>strtotime('now'),
			// 		'reservation_updated_at'=>strtotime('now'),
			// 		'reservation_out'=>strtotime($i['checkout']),
			// 		'reservation_adult'=>$i['inputAdult'],
			// 		'reservation_child'=>$i['inputChild'],
			// 		'reservation_roomCount'=>$i['allReservedRoomQty'][$key],
			// 		'reservation_day_type'=>$i['stayTypeChk'],
			// 		'reservation_status'=>2,
			// 		'reservation_requests'=>$i['comment'],
			// 		'reservation_key'=> $transaction_key,
			// 		'guest_id'=>$last_id,
			// 		'room_type_id'=>$value,
			// 	);
			// 	$this->Crud->insert('reservation',$data_reservation);
			// }

			// ADD BILLING
			$data_billing = array(
				'billing_price'=>$i['totalCharge'],
				'billing_name'=>'Reservation Fee',
				'billing_quantity'=>1,
				'reservation_key'=>$transaction_key,

			);
			$this->Crud->insert('billing',$data_billing);

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
			$this->load->view('includes/materialize/footer');
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

	public function deleteReservation()
	{
		$reservation_key = $this->input->post('reservation_key');
		if ($this->Crud->delete('reservation',array('reservation_key'=>$reservation_key))) {
			if ($this->Crud->delete('billing',array('reservation_key'=>$reservation_key))) {
				echo json_encode(true);
			}else{
				echo json_encode('Failed to remove data on billing table');
			}
		}else{
			echo json_encode('Failed to remove data on reservation table');
		}
		
	}

}

/* End of file Reservation.php */
/* Location: ./application/controllers/Reservation.php */