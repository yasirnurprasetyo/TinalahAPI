<?php
require(APPPATH . '/libraries/REST_Controller.php');

use Restserver\Libraries\REST_Controller;

class Identify extends Restserver\Libraries\REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("ModelIdentify");
        $this->load->library('upload');
        
        //cek Token
        header('Content-Type: application/json');
        if (checkToken() == FALSE) {
            $this->response(["message" => "Silahkan Login Terlebih Dahulu"], 401);
            exit();
        }
    }

    public function index_get()
    {
        $dataIdentify = $this->ModelIdentify->getDetailIdentify();
        $result = array(
            "status" => true,
            "message" => "Get All Identify Success",
            "result" => $dataIdentify
        );
        // echo var_dump($dataIdentify);
        if ($result) {
            echo json_encode($result, 200);
        } else {
            $pesan = array(
                "status" => false,
                "message" => "Get All Identify Failed",
            );
            $this->response($pesan, 404);
        }
    }

    public function index_post()
    {
        //test hasil objek
        $resultObjek = apiRequest("hasil", "GET");
        $body = $resultObjek["body"];
        $dataHasil = $body;

        $userId = $this->input->post('user_id_identify', true); //user id

        //proses tambah image
        $stringBase64 = $this->input->post("gambar_identify", true);
        $fileName = md5(date("d-m-Y H:i:s") . rand(1, 100000));
        $fileName .= ".jpg";
        $decode = base64_decode($stringBase64);
        file_put_contents("image/identify/$fileName", $decode);

        $imageUrl = base_url() . "image/scan/" . $fileName;

        $config['encrypt_name'] = TRUE;

        $data = array(
            "gambar_identify" => $fileName,
            "gambar_identify_url" => $imageUrl,
            "gambar_id_identify" => $dataHasil,
            "user_id_identify" => $userId
        );
        // echo var_dump($image);
        json_encode($data, 200);
        $result = $this->ModelIdentify->insert($data);
        if ($result) {
            $pesan = array(
                "status" => true,
                "message" => "Create Data Identify Berhasil",
                "result" => $data
            );
            $this->response($pesan, 201);
        } else {
            $pesan = array(
                "status" => false,
                "message" => "Create Data Identify Gagal",
            );
            $this->response($pesan, 404);
        }
    }
}
