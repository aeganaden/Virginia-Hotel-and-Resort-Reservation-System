<?php
date_default_timezone_set('Asia/Manila');
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Admin extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('session');
		$this->load->model('Crud');
		$this->load->library('form_validation');
		$this->load->helper(['form', 'download']);
	}

	public function index() {
		$userData = $this->session->userdata('userdata');

		if (!$userData) {
			$title = "Admin - Login";
			$this->load->view('includes/materialize/header', compact('title'));
			$this->load->view('admin/login');
			$this->load->view('includes/materialize/footer');
		} else {
			$title = "Admin - Home";
			$this->load->view('includes/materialize/header', compact('title'));
			$this->load->view('admin/reports');
			$this->load->view('includes/materialize/footer');
		}
	}

	public function fetchGuest() {
		$guestID = $this->input->post('guestID');
		$data = array('guest_id' => $guestID);

		$guest = $this->Crud->fetch('guest', $data);

		echo json_encode($guest[0]);

	}

	public function loadReports() {
		$reports = $this->Crud->fetch_distinct('reservation');

		foreach ($reports as $key => $value) {
			$billing = $this->Crud->getSum('billing', 'billing_price', array('reservation_key' => $value->reservation_key));
			$value->billing_price = $billing[0]->billing_price;
			$value->date_in_formatted = date('M d, Y', $value->reservation_in);
			$value->date_out_formatted = date('M d, Y', $value->reservation_out);
		}

		echo json_encode($reports);
	}

	public function moderators() {
		$userData = $this->session->userdata('userdata');
		if (!$userData) {
			$title = "Admin - Login";
			$this->load->view('includes/materialize/header', compact('title'));
			$this->load->view('admin/login');
			$this->load->view('includes/materialize/footer');
		} else {
			$title = "Admin - Reports";
			$this->load->view('includes/materialize/header', compact('title'));
			$this->load->view('admin/admin');
			$this->load->view('includes/materialize/footer');
		}
	}

	public function checkCredentials() {
		$username = $this->input->post('username');
		$password = sha1($this->input->post('password'));
		$data = array(
			'admin_username' => $username,
			'admin_password' => $password,
		);

		if ($data = $this->Crud->fetch('admin', $data)) {
			$sessionData = array(
				'logged_in' => true,
				'data' => $data,
			);
			$this->session->set_userdata('userdata', $sessionData);
			redirect('Admin');
		} else {
			$this->session->set_flashdata('error', 'Account Credentials are incorrect.');
			redirect('Admin');
		}
	}

	public function addModerator() {
		$this->form_validation->set_rules('first_name', 'First Name', 'required|alpha');
		$this->form_validation->set_rules('last_name', 'Last Name', 'required|alpha');
		$this->form_validation->set_rules('username', 'Username', 'required|min_length[6]|alpha');
		$this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
		$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[password]');

		if ($this->form_validation->run() == FALSE) {
			$errors = validation_errors();
			echo json_encode(['error' => $this->form_validation->error_array()]);
		} else {
			$insertData = array(
				'moderator_username' => $this->input->post('username'),
				'moderator_firstname' => $this->input->post('first_name'),
				'moderator_lastname' => $this->input->post('last_name'),
				'moderator_password' => sha1($this->input->post('password')),
				'moderator_status' => 1,
				'moderator_created_at' => strtotime('now'),
			);
			if ($this->Crud->insert('moderator', $insertData)) {
				echo json_encode(true);
			} else {
				echo json_encode("Error Inserting Data");
			}
		}

	}

	public function updateStatus() {
		$id = $this->input->post("id");
		$val = $this->input->post("value");
		if ($this->Crud->update("moderator", array("moderator_status" => $val), array("moderator_id" => $id))) {
			echo json_encode("true");
		}
	}

	public function logout() {
		$this->session->unset_userdata('userdata');
		redirect('Welcome');
	}

	public function downloadReports() {
		$userData = $this->session->userdata('userdata');
		if (!empty($userData)) {
			require 'vendor/autoload.php';
			$spreadsheet = new Spreadsheet();
			$sheet = $spreadsheet->getActiveSheet();
			$sheet->getDefaultColumnDimension()->setWidth(15);

			$sheet->setCellValue('A1', 'Report as of: ' . date("F d, Y - g:i:s A", time()));
			$sheet->setCellValue('A3', 'ROOM');
			$sheet->setCellValue('B3', 'TYPE');
			$sheet->setCellValue('C3', 'RATE');
			$sheet->setCellValue('D3', 'CAPACITY');
			$sheet->setCellValue('E3', 'STATUS');
			$sheet->getStyle("A3:E3")->getFont()->setBold(true);
			$sheet->getStyle("A1")->getFont()->setBold(true);

			$orderby = ["r.room_id", "ASC"];
			$col = "r.room_name, r.room_status, r.reservation_key, rt.room_type_price, rt.room_type_pax, rt.room_type_name, rt.room_type_id";
			$join = [
				// ["reservation as res", "res.reservation_key = r.reservation_key"],
				["room_type as rt", "rt.room_type_id = r.room_type_id"],
			];
			$result = $this->Crud->fetch_join("room as r", $col, $join, NULL, NULL, NULL, NULL, NULL, NULL, NULL, $orderby);
			$col = "reservation_id";
			$counter = 0;
			foreach ($result as $sub) {
				$count_hold = $counter + 4;
				$sheet->setCellValue('A' . ($count_hold), $sub->room_name);
				$sheet->setCellValue('B' . ($count_hold), $sub->room_type_name);
				$sheet->setCellValue('C' . ($count_hold), "₱" . number_format($sub->room_type_price));
				$sheet->setCellValue('D' . ($count_hold), $sub->room_type_pax);
				if ($sub->room_status == 1) {
					$temp = "Reserved";
				} else if ($sub->room_status == 2) {
					$temp = "Cleaning";
				} else if ($sub->room_status == 3) {
					$temp = "Vacant";
				} else {
					$temp = "Unknown";
				}

				$sheet->setCellValue('E' . ($count_hold), $temp);
				$counter++;
			}

			$writer = new Xlsx($spreadsheet);
			$file_name = "Virginia report";
			$writer->save('./assets/uploads/' . $file_name . '.xlsx');
			force_download('./assets/uploads/' . $file_name . '.xlsx', NULL);
		} else {
			redirect();
		}
	}

}

/* End of file Admin.php */
/* Location: ./application/controllers/Admin.php */