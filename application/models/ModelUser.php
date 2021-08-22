<?php

class ModelUser extends CI_Model {
	//Definisikan nama table dan primary key nya.
    var $table = "user";
    var $primaryKey = "id_user";

    //Implementasi Crud Function
    public function getAll(){
        return $this->db->get($this->table)->result();
    }

    public function getByPrimaryKey($primaryKey){
        $this->db->where($this->primaryKey, $primaryKey);
        return $this->db->get($this->table)->row();
    }

    public function insert($data){
        return $this->db->insert($this->table, $data);
    }

    public function update($data, $primaryKey){
        $this->db->where($this->primaryKey, $primaryKey);
        return $this->db->update($this->table, $data);
    }

    public function delete($primaryKey){
        $this->db->where($this->primaryKey, $primaryKey);
        return $this->db->delete($this->table);
    }

	public function getAllAdminUser(){
        $this->db->where("role_user", "admin");
		return $this->db->get($this->table)->result();
    }
}
