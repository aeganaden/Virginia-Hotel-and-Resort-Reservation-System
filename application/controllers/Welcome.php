<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

	public function __construct() {
		parent::__construct(); 
		$this->load->model('Crud'); 
	}

	public function index()
	{
		$this->updateToExpired();
		$title = "Virginia and Boy Lodge and Resort";

		$this->load->view('includes/header',compact('title'));
		$this->load->view('index'); 
		$this->load->view('includes/footer');
	}

	public function updateToExpired()
	{
		$where = array(
			'reservation_status' => 2,
			'reservation_payment_status' => 0,
		);
		$reservations = $this->Crud->fetch('reservation',$where);
		if ($reservations) {
			foreach ($reservations as $key => $value) {
				$reserved_at = $value->reservation_reserved_at;
				$will_expire_at = date('mdyHis',strtotime('+1 day', $reserved_at));
				$today = date('mdyHis',strtotime('now')); 
				if ($will_expire_at <= $today) {
					$update_data = array('reservation_status' => 4 );
					$where = array('reservation_key' => $value->reservation_key );
					$this->Crud->update('reservation',$update_data,$where);
				}
			} 
		}
	}

	public function viewAboutUs()
	{
		$title = "About us - Virginia and Boy Lodge and Resort";

		$this->load->view('includes/header',compact('title'));
		$this->load->view('about'); 
		$this->load->view('includes/footer');
	}

	public function viewRooms()
	{
		$title = "Rooms - Virginia and Boy Lodge and Resort";

		$this->load->view('includes/header',compact('title'));
		$this->load->view('rooms'); 
		$this->load->view('includes/footer');
	}

	public function viewAmenities()
	{
		$title = "Amenities - Virginia and Boy Lodge and Resort";

		$this->load->view('includes/header',compact('title'));
		$this->load->view('amenities'); 
		$this->load->view('includes/footer');
	}

	public function viewGallery()
	{
		$title = "Gallery - Virginia and Boy Lodge and Resort";

		$this->load->view('includes/header',compact('title'));
		$this->load->view('gallery'); 
		$this->load->view('includes/footer');
	}

	public function contactUs()
	{
		$title = "Contact us - Virginia and Boy Lodge and Resort";

		$this->load->view('includes/header',compact('title'));
		$this->load->view('contactus'); 
		$this->load->view('includes/footer');
	}
}
