<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Account extends CI_Controller {

	public function index()
	{
		if($this->session->userdata('loggedIn'))
		{
			$email = $this->session->userdata('email');
			$this->db->where('email',$email);
			$query = $this->db->get('users');
			$user = $query->row();

			$this->db->where('email',$email);
			$query = $this->db->get('profile');
			$profile = $query->row();

			$data['countries'] = $this->db->get('countries');
			$data['email'] = $email;
			$data['user'] = $user;
			$data['profile'] = $profile;

			$data['title'] = 'Settings - Slamly | Create your free online slambook';
			$this->load->view('view_header',$data);
			$this->load->view('view_account_header');
			$this->load->view('view_account');
			$this->load->view('view_footer');
		}
		else
		{
			redirect('home/');
		}
	}

	public function signup()
	{

		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<p class="text-error">', '</p>');

		$this->form_validation->set_rules('fname','first name','required|trim|xss_clean|alpha');
		$this->form_validation->set_rules('lname','last name','required|trim|xss_clean|alpha');
		$this->form_validation->set_rules('password','password','required|trim|xss_clean');
		$this->form_validation->set_rules('cpassword','confirm password','required|trim|xss_clean|matches[password]');
		$this->form_validation->set_rules('email','email address','required|trim|xss_clean|valid_email|callback_validate_email');
		$this->form_validation->set_rules('dob','date of birth','required|trim|xss_clean|alpha_dash');

		if($this->form_validation->run())
		{
			$dob = new DateTime($this->input->post('dob'));
			$this->load->library('uuid');

			$user_insert = array(
				'id'		=>		null,
				'uuid'		=>		$this->uuid->v4(),
				'timestamp'	=>		date('Y-m-d H:i:s'),
				'email'		=>		$this->input->post('email'),
				'password'	=>		md5($this->input->post('password')),
				'fname'		=>		ucwords(strtolower($this->input->post('fname'))),
				'lname'		=>		ucwords(strtolower($this->input->post('lname'))),
				'sex'		=>		$this->input->post('sex'),
				'dob'		=>		$dob->format('Y-m-d')	
			);

			if($this->input->post('sex') == 'male')
			{
				$picture_256 = 'includes/img/profile_placeholders/male_placeholder_256.jpg';
				$picture_64 = 'includes/img/profile_placeholders/male_placeholder_64.jpg';
				$picture_32 = 'includes/img/profile_placeholders/male_placeholder_32.jpg';
			}
			else
			{
				$picture_256 = 'includes/img/profile_placeholders/female_placeholder_256.jpg';
				$picture_64 = 'includes/img/profile_placeholders/female_placeholder_64.jpg';
				$picture_32 = 'includes/img/profile_placeholders/female_placeholder_32.jpg';
			}

			$profile_insert = array(
				'email'					=>		$this->input->post('email'),
				'profile_picture_256'	=>		$picture_256,
				'profile_picture_64'	=>		$picture_64,
				'profile_picture_32'	=>		$picture_32	
			);

			if($this->db->insert('users',$user_insert) && $this->db->insert('profile',$profile_insert))
			{
				$params = array('token'	=>	'cff59a7c-250f-4ed2-9612-df51dc7e07e0');
				$this->load->library('logger',$params);
				$this->logger->Info($this->input->post('email') . ' signed up');

				$data['title'] = 'Thank you for signing up - Slamly | Create your free online slambook';
				$this->load->view('view_header',$data);
				$this->load->view('view_signup_success');
				$this->load->view('view_footer');
			}
			else
			{
				$params = array('token'	=>	'cff59a7c-250f-4ed2-9612-df51dc7e07e0');
				$this->load->library('logger',$params);
				$this->logger->Error($this->input->post('email') . ' tried signing up. DB error.');

				$data['title'] = 'Sorry your sign up failed - Slamly | Create your free online slambook';
				$this->load->view('view_header',$data);
				$this->load->view('view_signup_failure');
				$this->load->view('view_footer');
			}
		}
		else
		{
			$data['title'] = 'Slamly | Create your free online slambook';

			$this->load->view('view_header',$data);
			$this->load->view('view_home');
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
			$query = $this->db->get('users');
			$row = $query->row();
			$fname = $row->fname;
			$lname = $row->lname;
			$uuid = $row->uuid;

			$this->db->where('email',$email);
			$query = $this->db->get('profile');
			$profile = $query->row();

			if($profile->profile_picture_32 == 'includes/img/profile_placeholders/male_placeholder_32.jpg' || $profile->profile_picture_32 == 'includes/img/profile_placeholders/female_placeholder_32.jpg')
				$profile_picture_32 = base_url() . $profile->profile_picture_32;

			if($profile->profile_picture_64 == 'includes/img/profile_placeholders/male_placeholder_64.jpg' || $profile->profile_picture_64 == 'includes/img/profile_placeholders/female_placeholder_64.jpg')
				$profile_picture_64 = base_url() . $profile->profile_picture_64;

			if($profile->profile_picture_256 == 'includes/img/profile_placeholders/male_placeholder_256.jpg' || $profile->profile_picture_256 == 'includes/img/profile_placeholders/female_placeholder_256.jpg')
				$profile_picture_256 = base_url() . $profile->profile_picture_256;

			$update = array('last_login'	=>	date('Y-m-d H:i:s'));
			$this->db->where('email',$email);
			$this->db->update('users',$update);

			$data = array(
				'email' 			=> $email,
				'fname' 			=> $fname,
				'lname'				=> $lname,
				'profile_picture_32'	=> $profile_picture_32,
				'profile_picture_64'	=> $profile_picture_64,
				'profile_picture_256'	=> $profile_picture_256,
				'uuid'					=> $uuid,
				'loggedIn'	=> 1
			);

			$params = array('token'	=>	'f53d9858-7f0b-40bf-b488-be67c3c89aef');
			$this->load->library('logger',$params);
			$this->logger->Info($email . ' logged in');

			$this->session->set_userdata($data); //set the session cookie
			redirect('feed/');
		}
		else
		{
			$data['title'] = 'Slamly | Create your free online slambook';
			$this->load->view('view_header',$data);
			$this->load->view('view_home');
			$this->load->view('view_footer');
		}
	}

	public function logout()
	{
		$params = array('token'	=>	'f53d9858-7f0b-40bf-b488-be67c3c89aef');
		$this->load->library('logger',$params);
		$this->logger->Info($this->session->userdata('email') . ' logged out');

		$this->session->sess_destroy(); //destroys the session and redirects to login
		redirect('home/');
	}

	public function edit()
	{
		if($this->session->userdata('loggedIn'))
		{
				$this->load->library('form_validation');

				$this->form_validation->set_rules('fname','first name','required|trim|xss_clean|alpha');
				$this->form_validation->set_rules('lname','last name','required|trim|xss_clean|alpha');
				$this->form_validation->set_rules('dob','date of birth','required|trim|xss_clean|alpha_dash');

				if($this->form_validation->run())
				{
					$email = $this->session->userdata('email');
					$dob = new DateTime($this->input->post('dob'));
					$update = array(
						'fname'			=>		ucwords(strtolower($this->input->post('fname'))),
						'lname'			=>		ucwords(strtolower($this->input->post('lname'))),
						'dob'			=>		$dob->format('Y-m-d'),
						'sex'			=>		$this->input->post('sex')
					);
					$this->db->where('email',$email);

					if($this->db->update('users',$update))
					{
						$data = array(
							'email' 		=> $this->session->userdata('email'),
							'fname' 		=> ucwords(strtolower($this->input->post('fname'))),
							'lname'			=> ucwords(strtolower($this->input->post('lname'))),
							'loggedIn'	=> 1
						);

						$this->session->set_userdata($data);
						header('Content-type: application/json');
						echo json_encode(array("result" => "success"));
					}
					else
					{
						header('Content-type: application/json');
						echo json_encode(array("result" => "dbError"));
					}
				}
				else
				{
					header('Content-type: application/json');
					echo json_encode(array("result" => "validationError"));
				}
		}
		else
		{
			redirect('home/');
		}
	}

	public function password()
	{
		if($this->session->userdata('loggedIn'))
		{
			$this->load->library('recaptcha');
			$data['recaptcha_html'] = $this->recaptcha->recaptcha_get_html();
			$data['title'] = 'Change password - Slamly | Create your free online slambook';
			$data['flag'] = 'change';
			$this->load->view('view_header',$data);
			$this->load->view('view_account_header');
			$this->load->view('view_change_password');
			$this->load->view('view_footer');
		}
		else
		{
			redirect('home/');
		}	
	}

	public function change_password()
	{
		if($this->session->userdata('loggedIn'))
		{
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('<p class="text-error">', '</p>');
			$this->load->library('recaptcha');

			$this->form_validation->set_rules('currentPassword','current password','required|trim|xss_clean|callback_validate_password');
			$this->form_validation->set_rules('newPassword','new password','required|trim|xss_clean');
			$this->form_validation->set_rules('confirmPassword','confirmation password','required|trim|xss_clean|matches[newPassword]');
			$this->form_validation->set_rules('recaptcha_challenge_field','recaptcha challenge field','required|trim|xss_clean');
			$this->form_validation->set_rules('recaptcha_response_field','recaptcha response field','required|trim|xss_clean');

			if($this->form_validation->run())
			{
				$this->recaptcha->recaptcha_check_answer($_SERVER['REMOTE_ADDR'],$this->input->post('recaptcha_challenge_field'),$this->input->post('recaptcha_response_field'));
				if($this->recaptcha->getIsValid())
				{
					$email = $this->session->userdata('email');
					$password = md5($this->input->post('newPassword'));
					$currentPassword = md5($this->input->post('currentPassword'));

					$update = array(
						'password'		=>	$password
					);
					$this->db->where('email',$email);
					$this->db->where('password',$currentPassword);
					if($this->db->update('users',$update))
					{
						$data['title'] = 'Change password - Slamly | Create your free online slambook';
						$data['flag'] = 'success';
						$this->load->view('view_header',$data);
						$this->load->view('view_account_header');
						$this->load->view('view_change_password');
						$this->load->view('view_footer');
					}
					else
					{
						$data['title'] = 'Change password - Slamly | Create your free online slambook';
						$data['flag'] = 'error';
						$this->load->view('view_header',$data);
						$this->load->view('view_account_header');
						$this->load->view('view_change_password');
						$this->load->view('view_footer');
					}
				}
				else
				{
					$data['title'] = 'Change password - Slamly | Create your free online slambook';
					$data['flag'] = 'change';
					$data['recaptcha_html'] = $this->recaptcha->recaptcha_get_html();
					$data['captcha'] = 1;
					$this->load->view('view_header',$data);
					$this->load->view('view_account_header');
					$this->load->view('view_change_password');
					$this->load->view('view_footer');
				}
			}
			else
			{
				$data['title'] = 'Change password - Slamly | Create your free online slambook';
				$data['flag'] = 'change';
				$data['recaptcha_html'] = $this->recaptcha->recaptcha_get_html();
				$this->load->view('view_header',$data);
				$this->load->view('view_account_header');
				$this->load->view('view_change_password');
				$this->load->view('view_footer');
			}
		}
		else
		{
			redirect('home/');
		}
	}

	public function location()
	{
		if($this->session->userdata('loggedIn'))
		{
			$this->load->library('form_validation');
			$this->form_validation->set_rules('phone','phone','required|trim|xss_clean|numeric');
			$this->form_validation->set_rules('address_1','address line 1','required|trim|xss_clean');
			$this->form_validation->set_rules('address_2','address line 2','required|trim|xss_clean');
			$this->form_validation->set_rules('city','city','required|trim|xss_clean');
			$this->form_validation->set_rules('state','state','required|trim|xss_clean');
			$this->form_validation->set_rules('zip','zip','required|trim|xss_clean|numeric');
			$this->form_validation->set_rules('country','country','required|trim|xss_clean');

			if($this->form_validation->run())
			{
				$address = $this->input->post('address_1');
				$address .= ' ' . $this->input->post('address_2');
				$address .= ' ' . $this->input->post('city');
				$address .= ' ' . $this->input->post('state');
				$address .= ' ' . $this->input->post('zip');
				$address .= ' ' . $this->input->post('country');

				$url = 'https://maps.googleapis.com/maps/api/geocode/json?sensor=true&address=';
				$result = file_get_contents($url . urlencode($address));
				$coords = json_decode($result);

				if($coords->status == "OK")
				{
					$lat = $coords->results[0]->geometry->location->lat;
					$lng = $coords->results[0]->geometry->location->lng;
				}
				else
				{
					$address = $this->input->post('city');
					$address .= ' ' . $this->input->post('state');
					$address .= ' ' . $this->input->post('country');
					$result = file_get_contents($url . urlencode($address));
					$coords = json_decode($result);

					if($coords->status == "OK")
					{
						$lat = $coords->results[0]->geometry->location->lat;
						$lng = $coords->results[0]->geometry->location->lng;
					}
					else
					{
						$lat = 0.0;
						$lng = 0.0;
					}
				}

				$email = $this->session->userdata('email');
				$update = array(
					'phone'				=>	$this->input->post('phone'),
					'address_line_1'	=>	ucwords(strtolower($this->input->post('address_1'))),
					'address_line_2'	=>	ucwords(strtolower($this->input->post('address_2'))),
					'city'				=>	ucwords(strtolower($this->input->post('city'))),
					'state'				=>	ucwords(strtolower($this->input->post('state'))),
					'zip'				=>	$this->input->post('zip'),
					'country'			=>	$this->input->post('country'),
					'latitude'			=>	$lat,
					'longitude'			=>	$lng	
				);

				$this->db->where('email',$email);

				if($this->db->update('profile',$update))
				{
					header('Content-type: application/json');
					echo json_encode(array("result" => "success"));
				}
				else
				{
					header('Content-type: application/json');
					echo json_encode(array("result" => "dbError"));
				}
			}
			else
			{
				header('Content-type: application/json');
				echo json_encode(array("result" => "validationError"));
			}
		}
		else
		{
			redirect('home/');
		}

	}

	public function work()
	{
		if($this->session->userdata('loggedIn'))
		{
			$this->load->library('form_validation');
			$this->form_validation->set_rules('designation','designation','required|trim|xss_clean');
			$this->form_validation->set_rules('organization','organization','required|trim|xss_clean');

			if($this->form_validation->run())
			{
				$update = array(
					'designation'	=>	ucwords(strtolower($this->input->post('designation'))),
					'organization'	=>	ucwords(strtolower($this->input->post('organization')))
				);

				$email = $this->session->userdata('email');
				$this->db->where('email',$email);
				if($this->db->update('profile',$update))
				{
					header('Content-type: application/json');
					echo json_encode(array("result" => "success"));
				}
				else
				{
					header('Content-type: application/json');
					echo json_encode(array("result" => "dbError"));
				}
			}
			else
			{
				header('Content-type: application/json');
				echo json_encode(array("result" => "validationError"));
			}
		}
		else
		{
			redirect('home/');
		}	
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

	public function validate_password()
	{
		$password = md5($this->input->post('currentPassword'));
		$email = $this->session->userdata('email');

		$this->db->where('email',$email);
		$this->db->where('password',$password);
		$records = $this->db->get('users');

		if($records->num_rows() == 1)
		{
			return true;
		}
		else
		{
			$this->form_validation->set_message('validate_password', 'Your current password is incorrect');
			return false;
		}
	}
}