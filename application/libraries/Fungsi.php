<?php
class Fungsi
{

    protected $ci;

    public function __construct()
    {
        $this->ci = &get_instance();
    }

    function user_login(){
        $this->ci->load->model('UserModel');
        $user_id = $this->ci->session->userdata('id_user_app');
        $user_data = $this->ci->UserModel->getByPrimaryKey($user_id);
        return $user_data;
    }
}
