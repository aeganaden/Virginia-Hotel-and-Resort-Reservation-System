<?php
date_default_timezone_set('Asia/Manila');
defined('BASEPATH') OR exit('No direct script access allowed');

class Payments extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('Crud');
	}

	public function index() {
		if ($this->uri->segment(3)) {
			$title = "My Reservations";
			$transactionID = $this->uri->segment(3);
			$this->load->view('includes/materialize/header', compact('title', 'transactionID'));
			$this->load->view('payments');
			$this->load->view('includes/materialize/footer');
		} else {
			redirect('Welcome');
		}
	}

	public function updatePayment() {
		$reservation_key = $this->uri->segment(3);
		$config['upload_path'] = './assets/uploads/payments';
		$config['allowed_types'] = 'jpg|png|jpeg';
		$config['max_size'] = 1000;

		$this->load->library('upload', $config);

		if (!$this->upload->do_upload('file')) {
			$error = array('error' => strip_tags($this->upload->display_errors()));
			echo json_encode($error);
		} else {
			$data = array('upload_data' => $this->upload->data());
			$updateData = array(
				'reservation_payment_status' => 1,
				'reservation_updated_at' => strtotime('now'),
				'reservation_payment_photo' => $data["upload_data"]['file_name'],
			);
			if ($this->Crud->update('reservation', $updateData, array('reservation_key' => $reservation_key))) {
				echo json_encode(true);
			} else {
				echo json_encode(false);
			}

		}
	}

	public function updateBills() {
		$post = $this->input->post(array('changesTotal', 'reservation_key', 'adultCount', 'childCount', 'sbRoomCount', 'dbRoomCount', 'mattressCount'));

		$resSbUpdateData = array(
			'reservation_adult' => $post['adultCount'],
			'reservation_child' => $post['childCount'],
			'reservation_roomCount' => $post['sbRoomCount'],
			'reservation_updated_at' => strtotime('now'),
		);
		$resDbUpdateData = array(
			'reservation_adult' => $post['adultCount'],
			'reservation_child' => $post['childCount'],
			'reservation_roomCount' => $post['dbRoomCount'],
			'reservation_updated_at' => strtotime('now'),
		);
		$billingData = array(
			'billing_price' => $post['changesTotal'],
			'billing_name' => "Reservation Update",
			'billing_quantity' => 1,
			'reservation_key' => $post['reservation_key'],
		);
		$billingMattressData = array(
			'billing_price' => 350,
			'billing_name' => "Misc. Mattress ",
			'billing_quantity' => $post['mattressCount'],
			'reservation_key' => $post['reservation_key'],
		);
		$billingMattressUpdateData = array(
			'billing_quantity' => $post['mattressCount'],
		);
		$where_sb = array('reservation_key' => $post['reservation_key'], 'room_type_id' => 1);
		$where_db = array('reservation_key' => $post['reservation_key'], 'room_type_id' => 2);

		if (!$this->Crud->update('reservation', $resSbUpdateData, $where_sb)) {
			echo json_encode("Error updating single bedroom");
		}
		if (!$this->Crud->update('reservation', $resDbUpdateData, $where_db)) {
			echo json_encode("Error updating double bedroom");
		}
		if ($mattress = $this->Crud->fetch_like('billing', 'billing_name', 'Misc. Mattress', array('reservation_key' => $post['reservation_key']))) {
			if (!$this->Crud->update('billing', $billingMattressUpdateData, array('billing_id' => $mattress[0]->billing_id))) {
				echo "<pre>";
				var_dump($billingMattressUpdateData);
				echo json_encode("Error updating mattress billing");
			}
		} else {
			if (!$this->Crud->insert('billing', $billingMattressData)) {
				echo json_encode("Error inserting mattress to billing");
			}
		}

		if ($post['changesTotal'] > 0) {
			if ($this->Crud->insert('billing', $billingData)) {
				echo json_encode(true);
			} else {
				echo json_encode("Error inserting to billing");
			}
		} else {
			echo json_encode(true);
		}

		// if ($this->Crud->update('reservation',$resSbUpdateData,$where_sb)) {
		// 	if ($this->Crud->update('reservation',$resDbUpdateData,$where_db)) {
		// 		if ($this->Crud->insert('billing',$billingMattressData)) {
		// 			if ($post['changesTotal'] > 0) {
		// 				if ($this->Crud->insert('billing',$billingData)) {
		// 					echo json_encode(true);
		// 				}else{
		// 					echo json_encode("Error inserting to billing");
		// 				}
		// 			}else{
		// 				echo json_encode(true);
		// 			}
		// 		}else{
		// 			echo json_encode("Error inserting to billing");
		// 		}
		// 	}else{
		// 		echo json_encode("Error updating double bedroom");
		// 	}
		// }else{
		// 	echo json_encode("Error updating single bedroom");
		// }

	}

	// public function downloadPDF() {
	// 	if (!empty($id = $this->uri->segment(3))) {
	// 		require_once './application/vendor/autoload.php';

	// 		$reservation = $this->Crud->fetch('reservation', array('reservation_key' => $id));
	// 		if ($reservation) {
	// 			$guest = $this->Crud->fetch('guest', array('guest_id' => $reservation[0]->guest_id));
	// 			$guest = $guest[0];
	// 			$fullname = $guest->guest_firstname . " " . $guest->guest_lastname;

	// 			$stay_type = $reservation[0]->reservation_day_type == 1 ? "Day Stay" : "Night Stay";

	// 			// Compute length of stay
	// 			$datetime1 = new DateTime(date('Y-m-d', $reservation[0]->reservation_in));
	// 			$datetime2 = new DateTime(date('Y-m-d', $reservation[0]->reservation_out));
	// 			$difference = $datetime1->diff($datetime2);

	// 			$billing = $this->Crud->fetch('billing', array('reservation_key' => $reservation[0]->reservation_key));
	// 			$billing_total = 0;
	// 			$billing_total_negative = 0;
	// 			foreach ($billing as $key => $value) {
	// 				$billing_total += ($value->billing_price * $value->billing_quantity);
	// 				if ($value->billing_price * $value->billing_quantity > 0) {
	// 				} else {
	// 					$billing_total_negative += ($value->billing_price * $value->billing_quantity) * -1;
	// 				}
	// 			}
	// 			$billing_total = $billing_total + $billing_total_negative;
	// 			$tax = $this->Crud->fetch('settings', array('settings_id' => 1))[0]->settings_tax;
	// 			$totalTax = ($billing_total / $tax);
	// 			$totalTax = round($totalTax, 2);
	// 		}
	// 		$data = array(
	// 			"title" => "PDF",
	// 			"id" => $id,
	// 			"reservation" => $reservation,
	// 			"datetime1" => $datetime1,
	// 			"datetime2" => $datetime2,
	// 			"difference" => $difference,
	// 			"stay_type" => $stay_type,
	// 			"billing_total" => $billing_total,
	// 			"totalTax" => $totalTax,
	// 			"tax" => $tax,
	// 			"fullname" => $fullname,
	// 			"email" => $guest->guest_email,
	// 		);

	// 		$mpdf = new \Mpdf\Mpdf();

	// 		// Buffer the following html with PHP so we can store it to a variable later
	// 		ob_start();

	// 		// This is where your script would normally output the HTML using echo or print
	// 		$this->load->view('pdf/pdf_file', $data); //last-mark

	// 		// Now collect the output buffer into a variable
	// 		$html = ob_get_contents();
	// 		ob_end_clean();

	// 		// send the captured HTML from the output buffer to the mPDF class for processing
	// 		$mpdf->WriteHTML($html);
	// 		if (file_exists('assets/uploads/pdfs/pdf_' . $id . '.pdf')) {
	// 			unlink('assets/uploads/pdfs/pdf_' . $id . '.pdf');
	// 		}
	// 		$mpdf->Output('assets/uploads/pdfs/pdf_' . $id . '.pdf');
	// 		echo json_encode(base_url() . 'assets/uploads/pdfs/pdf_' . $id . '.pdf');
	// 	} else {
	// 		echo json_encode("error");
	// 	}
	// }

}

/* End of file Payments.php */
/* Location: ./application/controllers/Payments.php */