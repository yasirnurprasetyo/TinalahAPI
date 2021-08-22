<?php

class ModelLogin extends CI_Model {
    //put your code here
    function checkUser($email, $password){
        
        $this->db->select("*");
        $this->db->from("user");
        $this->db->where("email_user", $email);
        $user = $this->db->get()->row();
        if($user != null){
            if(password_verify($password, $user->password_user)){
                return $user;
            }
        }
        return null;
    }
    function updateExpiredAndTokenUser($id,$data){
        $this->db->where("id_user",$id);
        return $this->db->update("user",$data);
    }
}