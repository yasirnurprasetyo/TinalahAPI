<?php
require(APPPATH . '/libraries/REST_Controller.php');

use Restserver\Libraries\REST_Controller;

class History extends Restserver\Libraries\REST_Controller
{
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

    public function index_get($id = null)
    {
        if ($id == null) {
            $dataHistory = $this->ModelScan->getScanAll();
            $result = array(
                "status" => true,
                "message" => "Get All History Scan Success",
                "result" => $dataHistory
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
        } else {
            $dataHistory = $this->ModelScan->getScanUser($id);
            $result = array(
                "status" => true,
                "message" => "Get All History By User ID Success",
                "result" => $dataHistory
            );
            if ($dataHistory == null) {
                $pesan = array(
                    "status" => false,
                    "message" => "Get All Data Gambar Failed",
                );
                $this->response($pesan, 404);
            } else {
                $pesan = array(
                    "status" => true,
                    "message" => "Get All History By User ID Success",
                    "result" => $dataHistory
                );
                // $dataHistory->image_url = base_url() . "image/user/" . $dataHistory->image_user;
                $this->response($pesan, 200);
            }
        }
    }
}
