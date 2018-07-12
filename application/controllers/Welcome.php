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
	public function index()
	{
		$title = "Virginia and Boy Lodge and Resort";

		$this->load->view('includes/header',compact('title'));
		$this->load->view('index'); 
		$this->load->view('includes/footer');
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
