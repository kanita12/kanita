<?php
class News_image_model extends CI_Model
{
	private $table = "news_image";
	public function __construct()
	{
		parent::__construct();
	}
	public function insert($data)
	{
		$this->db->insert($this->table,$data);
		return $this->db->insert_id();
	}
	# use
	public function get_list_by_news_id($news_id)
	{
		$this->db->select("newsimage_id,newsimage_news_id,newsimage_filepath,newsimage_filename");
		$this->db->from($this->table);
		$this->db->where("newsimage_news_id",$news_id);
		return $this->db->get();
	}
	public function delete_by_id($newsimage_id)
	{
		$this->db->where("newsimage_id",$newsimage_id);
		$this->db->delete($this->table);
		return $this->db->affected_rows();
	}
}