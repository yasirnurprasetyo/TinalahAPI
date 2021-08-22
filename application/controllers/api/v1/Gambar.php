<?php
require(APPPATH . '/libraries/REST_Controller.php');

use Restserver\Libraries\REST_Controller;

class Gambar extends Restserver\Libraries\REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("ModelGambar");
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
            $dataGambar = $this->ModelGambar->getAll();
            $result = array(
                "status" => true,
                "message" => "Get All Data Gambar Success",
                "result" => $dataGambar
            );
            if ($result) {
                echo json_encode($result, 200);
            } else {
                $pesan = array(
                    "status" => false,
                    "message" => "Get All Data Gambar Failed",
                );
                $this->response($pesan, 404);
            }
        }else{
            $dataGambar = $this->ModelGambar->getByPrimaryKey($id);
            if($dataGambar == null){
                $pesan = array(
                    "status" => false,
                    "message" => "Get All Data Gambar Failed",
                );
                $this->response($pesan, 404);
            }else{
                $dataGambar->gambar_url = base_url() . "image/gambar/" . $dataGambar->gambar;
                $this->response($dataGambar, 200);
            }
        }
    }

    public function index_post()
    {
        //Proses menambah image
        $stringBase64 = $this->input->POST("gambar", TRUE);
        $fileName = md5(date("d-m-Y H:i:s") . rand(1, 100000));
        $fileName .= ".jpg";
        $decode = base64_decode($stringBase64);
        file_put_contents("image/gambar/$fileName", $decode);

        $imageUrl = base_url() . "image/gambar/" . $fileName;

        $dataGambar = array(
            "nama_gambar" => $this->input->POST("nama_gambar", TRUE),
            "gambar" => $fileName,
            "kategori_gambar" => $this->input->POST("kategori_gambar", TRUE),
            "deskripsi_gambar" => $this->input->POST("deskripsi_gambar", TRUE),
            "gambar_url" => $imageUrl
        );

        json_encode($dataGambar, 201);
        $result = $this->ModelGambar->insert($dataGambar);
        if ($result) {
            $pesan = array(
                "status" => true,
                "message" => "Create Data Gambar Berhasil",
                "result" => $dataGambar
            );
            $this->response($pesan, 201);
        } else {
            $pesan = array(
                "status" => false,
                "message" => "Create Data Gambar Gagal",
            );
            $this->response($pesan, 404);
        }
    }

    public function index_put()
    {
        $gambar = json_decode(file_get_contents("php://input"));
        //Hapus gambar lama terlebih dahulu
        if (file_exists("image/gambar/$gambar->gambar")) {
            unlink("image/gambar/$gambar->gambar");
        }
        //Update Gambar Baru dan Data gambar Baru
        $stringBase64 = $gambar->gambar;
        $fileName = md5(date("d-m-Y H:i:s") . rand(1, 100000));
        $fileName .= ".jpg";
        $decode = base64_decode($stringBase64);
        file_put_contents("image/gambar/$fileName", $decode);
        $imageUrl = base_url() . "image/gambar/" . $fileName;
        //Update data gambar
        $data = array(
            "nama_gambar" => $gambar->nama_gambar,
            "gambar" => $fileName,
            "kategori_gambar" => $gambar->kategori_gambar,
            "deskripsi_gambar" => $gambar->deskripsi_gambar,
            "gambar_url" => $imageUrl
        );
        $result = $this->ModelGambar->update($data, $gambar->id_gambar);
        if ($result) {
            $pesan = array(
                "status" => true,
                "message" => "Data Gambar Berhasil di Update",
                "result" => $result
            );
            $this->response($pesan, 200);
        } else {
            $pesan = array(
                "status" => false,
                "message" => "Data Gambar Gagal di Update"
            );
            $this->response($pesan, 404);
        }
    }
}
