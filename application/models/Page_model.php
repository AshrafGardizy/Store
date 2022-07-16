<?php

class Page_model extends CI_Model
{
    // getting settings data
    public function settings()
    {
        $query = $this->db->get('settings');
        return $query->row();
    }

    public function login($username, $password)
    {
        $this->db->where('username', $username);
        $this->db->where('password', $password);
        $query = $this->db->get('settings');
        if (empty($query->num_rows())) {
            return false;
        }
        return $query->row();
    }
}
