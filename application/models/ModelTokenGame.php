<?php

class ModelTokenGame extends CI_Model{
	var $table = "tokengame";
	var $primaryKey = "id_tokengame";

	public function getAll()
	{
		return $this->db->get($this->table)->result();
	}

	public function getByPrimaryKey($primaryKey)
	{
		$this->db->where($this->primaryKey, $primaryKey);
        return $this->db->get($this->table)->row();
	}

	public function insert($data)
	{
		return $this->db->insert($this->table, $data);
	}

	public function update($data, $primaryKey)
	{
		$this->db->where($this->primaryKey, $primaryKey);
        return $this->db->update($this->table, $data);
	}

	public function delete($id)
	{
		$this->db->where($this->primaryKey, $id);
		return $this->db->update($this->table, array("is_active_tokengame" => 0));
	}

	function checkTokenGame($token)
	{
		$syarat = array("token_game" => $token, "is_active_tokengame" => "1");
		$this->db->where($syarat);
		$verifiyToken = $this->db->get("tokengame")->row();
		if (!$verifiyToken) {
			return false;
		}
		return $verifiyToken;
	}
}
