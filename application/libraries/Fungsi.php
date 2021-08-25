<?php
class Fungsi
{

    protected $ci;

    public function __construct()
    {
        $this->ci = &get_instance();
    }

    function user_login(){
        $this->ci->load->model('ModelUser');
        $user_id = $this->ci->session->userdata('id_user_app');
        // $user_id = "".$uid;
        $user_data = $this->ci->ModelUser->getByPrimaryKey($user_id);
        return $user_data;
    }

    function token_login(){
        $this->ci->load->model('ModelTokenGame');
        $id_token = $this->ci->session->userdata('id_token_app');
        // $id_token = "1";
        $token_data = $this->ci->ModelTokenGame->getByPrimaryKey($id_token);
        return $token_data; 
    }
}
