<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

	public function index()
	{
		if(!$this->session->userdata('loggedIn'))
		{
			$data['title'] = 'Slamly | Create your free online slambook';

			$this->load->view('view_header',$data);
			$this->load->view('view_home');
			$this->load->view('view_footer');
		}
		else
			redirect('feed/');
	}

	public function about()
	{
		$data['title'] = 'About Slamly | Create your free online slambook';
		$this->load->view('view_header',$data);
		$this->load->view('view_about');
		$this->load->view('view_footer');
	}

	public function terms()
	{
		$data['title'] = 'Terms of Use - Slamly | Create your free online slambook';
		$this->load->view('view_header',$data);
		$this->load->view('view_terms');
		$this->load->view('view_footer');
	}
}