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

	public function delete($primaryKey)
	{
		$this->db->where($this->primaryKey, $primaryKey);
        return $this->db->delete($this->table);
	}

	function checkTokenGame($token)
	{
		$syarat = array("token_game" => $token, "is_active" => "1");
		$this->db->where($syarat);
		$verifiyToken = $this->db->get("game")->row();
		if (!$verifiyToken) {
			return false;
		}
		return $verifiyToken;
	}
}
