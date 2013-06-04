<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fill extends CI_Controller {

	public function submit()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<p class="text-error">', '</p>');

		$this->form_validation->set_rules('name','name','required|trim|xss_clean|alpha');
		$this->form_validation->set_rules('nickname','nickname','required|trim|xss_clean|alpha');
		$this->form_validation->set_rules('dob','dob','required|trim|xss_clean|alpha_dash');
		$this->form_validation->set_rules('sun_sign','sun_sign','required|trim|xss_clean');
		$this->form_validation->set_rules('email','email','required|trim|xss_clean|valid_email');
		$this->form_validation->set_rules('mobile','mobile','required|trim|xss_clean|numeric');
		$this->form_validation->set_rules('address','address','required|trim|xss_clean');
		$this->form_validation->set_rules('self_description','describe yourself','required|trim|xss_clean');
		$this->form_validation->set_rules('description','describe me','required|trim|xss_clean');
		$this->form_validation->set_rules('secret','secret','required|trim|xss_clean');
		$this->form_validation->set_rules('ambition','ambition','required|trim|xss_clean');
		$this->form_validation->set_rules('strengths','strengths','required|trim|xss_clean');
		$this->form_validation->set_rules('weaknesses','weaknesses','required|trim|xss_clean');
		$this->form_validation->set_rules('crush','crush','required|trim|xss_clean');
		$this->form_validation->set_rules('pride','pride','required|trim|xss_clean');
		$this->form_validation->set_rules('life','life','required|trim|xss_clean');
		$this->form_validation->set_rules('friendship','friendship','required|trim|xss_clean');
		$this->form_validation->set_rules('website','website','required|trim|xss_clean');
		$this->form_validation->set_rules('message','message','required|trim|xss_clean');

		if($this->form_validation->run())
		{
			$this->load->library('typography');
			$dob = new DateTime($this->input->post('dob'));

			$insert = array(
				'id'			=>	null,
				'slam'			=>	$this->input->post('slam'),
				'timestamp'		=>	date('Y-m-d H:i:s'),
				'name'			=>	$this->input->post('name'),
				'nickname'		=>	$this->input->post('nickname'),
				'dob'			=>	$dob->format('Y-m-d'),
				'mobile'		=>	$this->input->post('mobile'),
				'sun_sign'		=>	$this->input->post('sun_sign'),
				'address'		=>	$this->typography->auto_typography($this->input->post('address')),
				'self_description'	=>	$this->input->post('self_description'),
				'email'			=>	$this->input->post('email'),
				'my_description'=>	$this->typography->auto_typography($this->input->post('description')),
				'secret'		=>	$this->input->post('secret'),
				'ambition'		=>	$this->typography->auto_typography($this->input->post('ambition')),
				'strengths'		=>	$this->typography->auto_typography($this->input->post('strengths')),
				'weaknesses'	=>	$this->typography->auto_typography($this->input->post('weaknesses')),
				'crush'			=>	$this->typography->auto_typography($this->input->post('crush')),
				'pride'			=>	$this->typography->auto_typography($this->input->post('pride')),
				'life'			=>	$this->typography->auto_typography($this->input->post('life')),
				'friendship'	=>	$this->typography->auto_typography($this->input->post('friendship')),
				'website'		=>	$this->input->post('website'),
				'message'		=>	$this->typography->auto_typography($this->input->post('message'))
			);

			if($this->db->insert('responses',$insert))
			{
				$data['title'] = 'Slamly | Create your free online slambook';

				$data['name'] = $this->input->post('name');
				$this->load->view('view_header',$data);
				$this->load->view('view_fill_success');
				$this->load->view('view_footer');
			}
		}
		else
		{
			$data['title'] = 'Slamly | Create your free online slambook';
			$data['slam'] = $this->input->post('slam');

			$data['fname'] = $this->input->post('fname');
			$this->load->view('view_header',$data);
			$this->load->view('view_slam');
			$this->load->view('view_footer');
		}

	}
}