<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_friends extends CI_Model {
	
	public function isFriend($val1,$val2)
	{
		$this->db->where('source',$val1);
		$this->db->where('destination',$val2);
		$query = $this->db->get('friends');

		if($query->num_rows() > 0)
		{
			return true;
		}
		else
		{
			$this->db->where('source',$val2);
			$this->db->where('destination',$val1);
			$query = $this->db->get('friends');

			if($query->num_rows() > 0)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
	}

	public function isRequest($val1,$val2)
	{
		$this->db->where('source',$val1);
		$this->db->where('destination',$val2);
		$query = $this->db->get('friend_requests');

		if($query->num_rows() > 0)
		{
			return array(true,'forward');
		}
		else
		{
			$this->db->where('source',$val2);
			$this->db->where('destination',$val1);
			$query = $this->db->get('friend_requests');

			if($query->num_rows() > 0)
			{
				return array(true,'backward');
			}
			else
			{
				return array(false,'none');
			}
		}
	}	
}