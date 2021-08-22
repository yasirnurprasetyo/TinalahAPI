<?php
require(APPPATH . '/libraries/REST_Controller.php');

use Restserver\Libraries\REST_Controller;

class Login extends REST_Controller
{
    //Panggil Class ModelLogin
    function __construct()
    {
        parent::__construct();
        $this->load->model("ModelLogin");
    }

    public function index_post()
    {
        $email = $this->input->server("PHP_AUTH_USER");
        $password = $this->input->server("PHP_AUTH_PW");
        $user = $this->ModelLogin->checkUser($email, $password);

        if ($user != null) {
            //Update Token dan Tanggal Expired dari Token
            $token = md5($user->email_user . date("d M Y H:i:s"));
            $tokenExpired = date('Y-m-d', strtotime(date("Y-m-d") . "+7 days"));
            //Menampung data token
            $dataToken = array(
                "token_user" => $token,
                "token_expired_user" => $tokenExpired
            );
            $this->ModelLogin->updateExpiredAndTokenUser($user->id_user, $dataToken);
            $data = array(
                "name_user" => $user->name_user,
                "email_user" => $user->email_user,
                "phone_user" => $user->phone_user,
                "image_user" => $user->image_user,
                "token_user" => $token,
                "token_expired_user" => $tokenExpired
            );
            $result = array(
                "status" => true,
                "message" => "Login Sukses",
                "token" => $token,
                "result" => $data
            );
            $this->response($result, 200);
        } else {
            $pesan = array(
                "status" => false,
                "message" => "Login Gagal, Email atau Password tidak ditemukan"
            );
            $this->response($pesan, 401);
        }
    }
}
