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
        file_put_contents("image/identify/$fileName", $decode); // ("nama_file yg akan ditulis", "isi data yg ada dalam file")

        $imageUrl = base_url() . "image/scan/" . $fileName;

        if($fileName != null){
            $config['image_library']='gd2';
            $config['source_image'] = './image/identify/'.$fileName;
            $config['create_thumb']= FALSE;
            $config['maintain_ratio']= TRUE;
            $config['width']= 200;
            $config['height']= 200;
            $this->load->library('image_lib', $config);
            $this->image_lib->resize();
        }else{
            echo "error";
        }

        $gambarId = "1";

        $data = array(
            "gambar_identify" => $fileName,
            "gambar_identify_url" => $imageUrl,
            "gambar_id_identify" => $gambarId,
            "user_id_identify" => $userId
        );
        echo var_dump($fileName);
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
