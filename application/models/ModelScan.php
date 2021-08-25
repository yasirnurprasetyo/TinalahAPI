<?php

class ModelScan extends CI_Model
{
	var $table = "scan";
	var $primaryKey = "id_scan";

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

	public function getScanUser()
	{
		// $id = $this->session->userdata['id_user_app']['id_user']; // dapatkan id user yg login
		// $this->db->select('s.*,u.*','g.*');
		// $id = $this->session->userdata('id_user_app');
		$id = "1";
		$this->db->select('*');
		$this->db->from('scan as s');
		$this->db->join('user as u', 's.user_id = u.id_user');
		$this->db->join('gambar as g', 's.gambar_id = g.id_gambar');
		$this->db->where('user_id', $id);
		$query = $this->db->get();
		return $query->result();
	}

	public function getAllJoinGambar()
	{
		$this->db->select("s.*,g.*")
			->from("scan as s")
			->join("gambar as g", "s.gambar_id = g.id_gambar");
		return $this->db->get()->result();
	}
}