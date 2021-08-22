<?php

class ModelGambar extends CI_Model {
	var $table = "gambar";
	var $primaryKey = "id_gambar";

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
}
