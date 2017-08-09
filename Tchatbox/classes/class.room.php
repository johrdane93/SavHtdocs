<?php
include('tools/functions.php');
class room {
	private $name = "";
	private $pwd = "";
	private $url = "";
	
	function room($name,$pwd){
		$this->setName($name);
		$this->setPwd($pwd);
		while(true){
			$randomUrl = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyz"),0,6);
			if (!file_exists('../'.$randomUrl)) {
				recurse_copy("tchatbox",$randomUrl);
				$this->setUrl($randomUrl."/");
				$myfile = fopen($randomUrl."/conf.json", "w") or die("Impossible d'ouvrir le fichier !");
				fwrite($myfile, '[{"name":"'.$name.'","pwd":"'.encrypt_decrypt('encrypt',$pwd).'","url":"'.$randomUrl.'"}]');
				fclose($myfile);
				break;
			}
		}
	}
	
	public function getName() {
		return $this->name;
	}
	
	public function setName($var) {
		$this->name = $var;
	}
	
	public function getPwd() {
		return $this->pwd;
	}
	
	public function setPwd($var) {
		$this->pwd = $var;
	}
	
	public function getUrl() {
		return $this->url;
	}
	
	public function setUrl($var) {
		$this->url = $var;
	}
}
?>