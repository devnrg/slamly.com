<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ninja extends CI_Controller {

	public function index()
	{
		if($this->session->userdata('loggedIn'))
		{
			if($this->session->userdata('ninja'))
			{
				$data['title'] = 'Slamly | Ninja dashboard';
				$data['nav'] = 1;
				$data['users'] = $this->db->count_all('users');
				$data['slams'] = $this->db->count_all('slams');
				$data['responses'] = $this->db->count_all('responses');

				$this->db->where('DATE(timestamp)', date('Y-m-d'));
				$data['new_users'] = $this->db->count_all_results('users');

				$this->db->where('DATE(last_login)', date('Y-m-d'));
				$data['new_logins'] = $this->db->count_all_results('users');

				$this->db->where('DATE(timestamp)', date('Y-m-d'));
				$data['new_responses'] = $this->db->count_all_results('responses');

				$this->load->view('view_ninja_header',$data);
				$this->load->view('view_ninja_dashboard_header');
				$this->load->view('view_ninja_dashboard');
				$this->load->view('view_footer');
			}
			else
				redirect('home/forbidden');
		}
		else
		{
			$data['title'] = 'Slamly | Ninja dashboard';

			$this->load->view('view_ninja_header',$data);
			$this->load->view('view_ninja_login');
			$this->load->view('view_footer');
		}
	}

	public function login() //the login form posts back here
	{
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<p class="text-error">', '</p>');
		
		$this->form_validation->set_rules("email","email","required|trim|xss_clean|valid_email|callback_validate_credentials");
		$this->form_validation->set_rules("password","password","required|trim|xss_clean");
		
		if($this->form_validation->run())
		{
			$email = $this->input->post('email');

			$this->db->where('email',$email);
			$query = $this->db->get('ninjas');
			$row = $query->row();
			$fname = $row->fname;

			$update = array('last_login'	=>	date('Y-m-d H:i:s'));
			$this->db->where('email',$email);
			$this->db->update('ninjas',$update);

			$data = array(
				'email' 		=> $email,
				'fname' 		=> $fname,
				'ninja'			=> true,
				'loggedIn'		=> 1
			);

			$this->session->set_userdata($data); //set the session cookie
			redirect('ninja/');
		}
		else
		{
			$data['title'] = 'Slamly | Ninja dashboard';

			$this->load->view('view_ninja_header',$data);
			$this->load->view('view_ninja_login');
			$this->load->view('view_footer');
		}
	}

	public function logout()
	{
		$this->session->sess_destroy(); //destroys the session and redirects to login
		redirect('ninja/');
	}

	public function validate_email()
	{
		$email = $this->input->post('email');
		$this->db->where('email',$email);
		$records = $this->db->get('users');

		if($records->num_rows() > 0)
		{
			$this->form_validation->set_message('validate_email', 'Sorry, an account for that email address already exists');
			return false;
		}
		else
			return true;
	}

	public function validate_credentials()
	{
		$email = $this->input->post('email');
		$password = md5($this->input->post('password'));

		$this->db->where('email',$email);
		$this->db->where('password',$password);
		$records = $this->db->get('users');

		if($records->num_rows() == 1)
		{
			return true;
		}
		else
		{
			$this->form_validation->set_message('validate_credentials', 'Your username or password is incorrect');
			return false;
		}
	}
}