<?php

class ModelIdentify extends CI_Model{
    var $table = "identify";
    var $primaryKey = "id_identify";

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

	public function getDetailIdentify()
	{
		$this->db->select("*");
		$this->db->from('identify');
		$this->db->order_by('id_identify', 'desc');
		$this->db->limit(1);
		$query = $this->db->get();
		return $query->result();
	}
}