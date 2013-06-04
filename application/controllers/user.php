<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {

	public function page($uuid)
	{
		if($this->session->userdata('loggedIn'))
		{
			$uuid = trim($uuid);
			$this->db->where('uuid',$uuid);
			$query = $this->db->get('users');

			if($query->num_rows() == 1)
			{
				$user = $query->row();
				$this->db->where('email',$user->email);
				$query = $this->db->get('profile');
				$profile = $query->row();

				$data['title'] = $user->fname . ' ' . $user->lname . ' - Slamly | Create your free online slambook';
				$data['user'] = $user;
				$data['profile'] = $profile;
				
				if($this->session->userdata('email') == $user->email)
				{
					$this->load->view('view_header',$data);
					$this->load->view('view_account_header');
					$this->load->view('view_user_self');
					$this->load->view('view_footer');
				}
				else
				{
					$this->load->model('model_friends');
					$friend = $this->model_friends->isFriend($this->session->userdata('uuid'),$uuid);

					if($friend)
					{
						$data['friend'] = true;
					}
					else
					{
						$data['friend'] = false;
						list($request,$direction) = $this->model_friends->isRequest($this->session->userdata('uuid'),$uuid);
						if($request)
						{
							$data['request'] = $direction;
						}
					}
					
					$this->load->view('view_header',$data);
					$this->load->view('view_account_header');
					$this->load->view('view_user');
					$this->load->view('view_footer');
				}
			}
			else
			{
				redirect('errors/page_missing');
			}

		}
		else
		{
			//Public user page
		}
	}
}