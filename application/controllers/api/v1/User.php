<?php
require(APPPATH . '/libraries/REST_Controller.php');
use Restserver\Libraries\REST_Controller;

class User extends Restserver\Libraries\REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("ModelUser");
        //cek Token
        header('Content-Type: application/json');
        if (checkToken() == FALSE) {
            $this->response(["message" => "Silahkan Login Terlebih Dahulu"], 401);
            exit();
        }
    }

	public function index_get($id=null)
	{
		if ($id == null) {
            $dataUser = $this->ModelUser->getAll();
            $result = array(
                "status" => true,
                "message" => "Get All Data Gambar Success",
                "result" => $dataUser
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
            $dataUser = $this->ModelGambar->getByPrimaryKey($id);
            if($dataUser == null){
                $pesan = array(
                    "status" => false,
                    "message" => "Get All Data Gambar Failed",
                );
                $this->response($pesan, 404);
            }else{
                $dataUser->image_url = base_url() . "image/user/" . $dataUser->image_user;
                $this->response($dataUser, 200);
            }
        }
	}

    public function index_post()
    {
        //Proses menambah image
        $stringBase64 = $this->input->post("image_user", true);
        $fileName = md5(date("d-m-Y H:i:s") . rand(1, 100000));
        $fileName .= ".jpg";
        $decode = base64_decode($stringBase64);
        file_put_contents("image/user/$fileName", $decode);

		$imageUrl = base_url() . "image/user/" . $fileName;
		$roleUser = "user";

		//Update Token dan Tanggal Expired dari Token
		$token = md5(date("d M Y H:i:s"));
		$tokenExpired = date('Y-m-d', strtotime(date("Y-m-d"). "+7 days"));

        //Tambah User
        $data = array(
            "name_user" => $this->post("name_user", true),
            "email_user" => $this->post("email_user", true),
            "password_user" => password_hash($this->post("password_user", true), PASSWORD_BCRYPT),
            "phone_user" => $this->post("phone_user", true),
            "role_user" => $roleUser,
            "token_user" => $token,
            "token_expired_user" => $tokenExpired,
            "image_user" => $fileName,
			"image_url" => $imageUrl
        );
        json_encode($data, 201);
		$result = $this->ModelUser->insert($data);
		if($result){
			$pesan = array(
				"status" => true,
				"message" => "Registrasi Berhasil",
				"result" => $data
			);
			$this->response($pesan, 201);
		}else{
			$pesan = array(
				"status" => false,
				"message" => "Registrasi Gagal",
			);
			$this->response($pesan, 404);
		}
    }
}
