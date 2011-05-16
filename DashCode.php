<?php
// red orange yellow green cyan blue violet
class DashCode{
	public function encode($x){
		$a0 = ($x & 0x0000FF);
		$a1 = ($x & 0x00FF00) >> 8;
		$a2 = ($x & 0xFF0000) >> 16;

		return array($a,$a1,$a2);
	}

	public function decode($a0,$a1,$a2){
		return ($a2 << 16)+($a1 << 8)+$a0;
	}


	public function todc($string){
		$string = str_pad($string,48,"~");
		/*$cs=array();
		foreach(str_split($string) as $v){
			$cs[]=chr($v);
		}*/
		
		$cs=str_split($string,3);
		
		$final = array();
		
		$i=0;
		
		foreach($cs as $v){
		
		}
		
	}
}

$d=new DashCode();

echo "Red: ".$d.decode(255,0,0)."\n";