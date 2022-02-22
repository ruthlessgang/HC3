<?php 
class Category{
	private $db;
	public function __construct($database)
	{   $this->db = $database; }	
	public function cat_exists($catid) 
	{	$query = $this->db->prepare("SELECT COUNT(`catid`) FROM `table_case_category` WHERE `namacat`= ?");
		$query->bindValue(1, $catid);
		try
		{	$query->execute();
			$rows = $query->fetchColumn();
			if($rows == 1){
				return true;
			}else{
				return false;
			}
		} catch (PDOException $e){
			die($e->getMessage());
		}
	}
	public function add_cat($catid,$namacat,$sub_cat,$ketcat)
	{	$querystring = "INSERT INTO `table_case_category` (`catid`,`namacat`, `sub_cat`, `ketcat`) VALUES (?, ?, ?, ?, ?)";
		$query 	= $this->db->prepare($querystring);
	 	$query->bindValue(1, $catid);
		$query->bindValue(2, $namacat);
		$query->bindValue(3, $sub_cat);
		$query->bindValue(4, $ketcat);
	 	try{
			$query->execute();
	 	}catch(PDOException $e){
			die($e->getMessage());
		}
	}
	public function update_cat($catid,$namacat,$responsetime,$sub_cat,$ketcat)
	{	$querystring = "UPDATE `table_case_category` SET `namacat` = ? ,  `sub_cat` = ?, `ketcat` = ?  WHERE `catid` = ?";
		$query 	= $this->db->prepare($querystring);
	 	$query->bindValue(1, $namacat);
		$query->bindValue(2, $sub_cat);
		$query->bindValue(3, $ketcat);
		$query->bindValue(4, $catid);
	 	try{
			$query->execute();
		}
		catch(PDOException $e){
			die($e->getMessage());
		}
	
	}
	public function delete($id){
		$sql="DELETE FROM `table_case_category` WHERE `catid` = ?";
		$query = $this->db->prepare($sql);
		$query->bindValue(1, $id);
		try{
			$query->execute();
		}
		catch(PDOException $e){
			die($e->getMessage());
		}
	}
	public function cat_data($catid)
	{	$query = $this->db->prepare("SELECT * FROM `table_case_category` WHERE `catid`= ?");
		$query->bindValue(1, $catid);
		try{
			$query->execute();
			return $query->fetch();
		} catch(PDOException $e){
			die($e->getMessage());
		}
	} 
	public function get_cat()
	{	$query = $this->db->prepare("SELECT * FROM `table_case_category` ORDER BY `namacat` ASC");
		try{
			$query->execute();
		}catch(PDOException $e){
			die($e->getMessage());
		}
		return $query->fetchAll();
	}
}