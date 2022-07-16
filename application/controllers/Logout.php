<?php
class Logout extends CI_Controller
{
    public function index()
    {
        // clear remember-me cookie
        $this->load->helper('cookie');
        delete_cookie('remember-me');
        // clear all sessions
        $this->session->unset_userdata('logged_in');
        // redirect
        redirect(base_url());
    }
}
