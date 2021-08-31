<?php
require(APPPATH . '/libraries/REST_Controller.php');

use Restserver\Libraries\REST_Controller;

class Highscore extends Restserver\Libraries\REST_Controller{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("ModelScan");
        //cek Token
        header('Content-Type: application/json');
        if (checkToken() == FALSE) {
            $this->response(["message" => "Silahkan Login Terlebih Dahulu"], 401);
            exit();
        }
    }

    public function index_get()
    {
        $dataScore = $this->ModelScan->getHighScoreGame();
        $result = array(
            "status" => true,
            "message" => "Get Highscore Success",
            "result" => $dataScore
        );
        if ($result) {
            echo json_encode($result, 200);
        } else {
            $pesan = array(
                "status" => false,
                "message" => "Get All Data History Failed",
            );
            $this->response($pesan, 404);
        }
    }
}