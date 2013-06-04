<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Feed extends CI_Controller {

	public function index()
	{
		if($this->session->userdata('loggedIn'))
		{
			$data['title'] = 'Feed - Slamly | Create your free online slambook';
			$data['nav'] = 1;
			$this->load->view('view_header',$data);
			$this->load->view('view_account_header');
			$this->load->view('view_feed');
			$this->load->view('view_footer');
		}
		else
		{
			redirect('home/');
		}
	}
}