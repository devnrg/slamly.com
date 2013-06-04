<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Errors extends CI_Controller {

	public function page_missing()
	{
		$data['title'] = 'Slamly | Create your free online slambook';

		$this->load->view('view_header',$data);
		$this->load->view('view_404');
		$this->load->view('view_footer');
	}
}