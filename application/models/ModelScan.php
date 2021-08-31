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

	//menampilkan highscore
	public function getHighScoreGame(){
		// "select user_id, sum(total_skor) as total_skor from scan group by user_id, tokengame_id order by total_skor desc";
		$this->db->select('sum(total_skor) as total_skor, user_id, u.name_user, t.nama_tokengame');
		$this->db->from('scan');
		$this->db->join('user as u', 'user_id = u.id_user');
		$this->db->join('tokengame as t', 'tokengame_id = t.id_tokengame');
		$this->db->group_by('user_id');
		$this->db->order_by('total_skor');
		$query = $this->db->get();
		return $query->result();
	}

	

	//menampilkan history scan berdasarkan id
	public function getScanUser($id)
	{
		$this->db->select('*');
		$this->db->from('scan as s');
		$this->db->join('user as u', 's.user_id = u.id_user');
		$this->db->join('gambar as g', 's.gambar_id = g.id_gambar');
		$this->db->join('tokengame as tg', 's.tokengame_id = tg.id_tokengame');
		$this->db->where('user_id', $id);
		$query = $this->db->get();
		return $query->result();
	}

	//menampilkan history scan all
	public function getScanAll()
	{
		$this->db->select('*');
		$this->db->from('scan as s');
		$this->db->join('user as u', 's.user_id = u.id_user');
		$this->db->join('gambar as g', 's.gambar_id = g.id_gambar');
		$this->db->join('tokengame as tg', 's.tokengame_id = tg.id_tokengame');
		// $this->db->where('user_id', $id);
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