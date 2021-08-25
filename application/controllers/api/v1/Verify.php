<?php
require (APPPATH.'/libraries/REST_Controller.php');
use Restserver\Libraries\REST_Controller;

class Verify extends Restserver\Libraries\REST_Controller{
    public function __construct()
	{
		parent::__construct();
		$this->load->model("ModelTokenGame");
		//cek Token
		header('Content-Type: application/json');
		if (checkToken() == FALSE) {
			$this->response(["message" => "Silahkan Login Terlebih Dahulu"], 401);
			exit();
		}
	}

    public function index_post()
    {
        $token = $this->post("token_game", true);
		$game = $this->ModelTokenGame->checkTokenGame($token);
		$dataSession = array(
			"id_token_app" => $game->id_tokengame
		);
		$this->session->set_userdata($dataSession);
		// echo var_dump($dataSession);

		if($game != null){
			$data = array(
				"id_tokengame" => $game->id_tokengame,
				"nama_tokengame" => $game->nama_tokengame,
				"is_active_tokengame" => $game->is_active_tokengame
			); 

			$result = array(
				"status" => true,
				"message" => "Verification Success",
				"result" => $data
			);
            $this->response($result, 200);
		}else {
            $pesan = array(
				"status" => false,
                "message" => "Token salah atau tidak terdaftar"
            );
            $this->response($pesan, 401);
        }
    }
}