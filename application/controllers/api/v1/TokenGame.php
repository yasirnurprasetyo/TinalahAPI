<?php
require (APPPATH.'/libraries/REST_Controller.php');
use Restserver\Libraries\REST_Controller;

class TokenGame extends Restserver\Libraries\REST_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model("ModelTokenGame");
		//cek Token
		header('Content-Type: application/json');
		if (checkToken() == FALSE) {
			$this->response("Silahkan Login Terlebih Dahulu");
			exit();
		}
	}

    public function index_get()
    {
        $dataGame = $this->ModelTokenGame->getAll();
		$result = array(
			"status" => true,
			"message" => "Get All Data Game Success",
			"result" => $dataGame
		);

		if ($result) {
			echo json_encode($result, 200);
		} else {
			$pesan = array(
				"status" => false,
				"message" => "Get All Data Game Failed",
			);
			$this->response($pesan, 404);
		}
    }

    public function index_post()
    {
        $tokenGame = randomToken(5);
		$isActive = "1";
		$tokenExpired = date('Y-m-d', strtotime(date("Y-m-d"). "+1 days"));

        $dataGame = array(
			"nama_tokengame" => $this->input->POST("nama_tokengame", TRUE),
			"catatan_tokengame" => $this->input->POST("catatan_tokengame", TRUE),
			"token_game" => $tokenGame,
			"is_active_tokengame" => $isActive,
			"token_game_expired" => $tokenExpired
		);
        json_encode($dataGame, 201);
        $result = $this->ModelTokenGame->insert($dataGame);
		if ($result) {
			$pesan = array(
				"status" => true,
				"message" => "Create Data Game Berhasil",
				"result" => $dataGame
			);
			$this->response($pesan, 201);
		} else {
			$pesan = array(
				"status" => false,
				"message" => "Create Data Game Gagal",
			);
			$this->response($pesan, 404);
		}
    }
}