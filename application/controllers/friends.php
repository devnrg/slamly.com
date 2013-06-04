<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Friends extends CI_Controller {

	public function request()
	{
		if($this->session->userdata('loggedIn'))
		{
			$this->load->library('form_validation');
			$this->form_validation->set_rules('uuid','to','required|trim|xss_clean');
			$this->form_validation->set_rules('message','message','trim|xss_clean');

			if($this->form_validation->run())
			{
				$source = $this->session->userdata('uuid');
				$destination = $this->input->post('uuid');

				$this->db->where('source',$source);
				$this->db->where('destination',$destination);
				$query = $this->db->get('friend_requests');

				if($query->num_rows() > 0)
				{
					header('Content-type: application/json');
					echo json_encode(array("result" => "alreadySent"));
				}
				else
				{
					$this->load->library('typography');
					if(($this->input->post('message') != null) && ($this->input->post('message') != ""))
						$message = $this->typography->auto_typography($this->input->post('message'));
					else
						$message = "";

					$insert = array(
						'id'			=>	null,
						'source'		=>	$source,
						'destination'	=>	$destination,
						'timestamp'		=>	date('Y-m-d H:i:s'),
						'message'		=>	$message,
						'status'		=>	'active'
					);

					if($this->db->insert('friend_requests',$insert))
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

	public function cancel_request()
	{
		if($this->session->userdata('loggedIn'))
		{
			$this->load->library('form_validation');
			$this->form_validation->set_rules('uuid','uuid','required|trim|xss_clean');
			if($this->form_validation->run())
			{
				$this->load->model('model_friends');
				list($request,$direction) = $this->model_friends->isRequest($this->session->userdata('uuid'),$this->input->post('uuid'));

				if($request)
				{
					if($direction == 'forward')
					{
						$this->db->where('source',$this->session->userdata('uuid'));
						$this->db->where('destination',$this->input->post('uuid'));
						if($this->db->delete('friend_requests'))
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
						echo json_encode(array("result" => "dbError"));
					}
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
}