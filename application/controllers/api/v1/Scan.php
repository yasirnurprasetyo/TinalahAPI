<?php
require(APPPATH . '/libraries/REST_Controller.php');

use Restserver\Libraries\REST_Controller;

class Scan extends Restserver\Libraries\REST_Controller
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

    public function index_post()
    {
        //test hasil objek
        $resultObjek = apiRequest("hasil", "GET");
        $body = $resultObjek["body"];
        $dataHasil = $body;

        $poin = 10;
        $userId = $this->input->post('user_id', true);
        $tokenId = $this->input->post('tokengame_id', true);
        //proses tambah image
        $stringBase64 = $this->input->post("gambar_scan", true);
        $fileName = md5(date("d-m-Y H:i:s") . rand(1, 100000));
        $fileName .= ".jpg";
        $decode = base64_decode($stringBase64);
        file_put_contents("image/scan/$fileName", $decode);

        $imageUrl = base_url() . "image/scan/" . $fileName;

        //tambah data scan
        $data = array(
            "gambar_scan" => $fileName,
            "total_skor" => $poin,
            "gambar_scan_url" => $imageUrl,
            "gambar_id" => $dataHasil,
            "user_id" => $userId,
            "tokengame_id" => $tokenId
        );
        json_encode($data, 200);
		$result = $this->ModelScan->insert($data);
		if ($result) {
			$pesan = array(
				"status" => true,
				"message" => "Create Data Scan Berhasil",
				"result" => $data
			);
			$this->response($pesan, 201);
		} else {
			$pesan = array(
				"status" => false,
				"message" => "Create Data Scan Gagal",
			);
			$this->response($pesan, 404);
		}
    }
}
