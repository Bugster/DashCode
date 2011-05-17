<?php
class DashCode{
	private function encode($x){
		$y=ord((string)$x);
		
		$a0 = ($y & 0x0000FF);
		$a1 = ($y & 0x00FF00) >> 8;
		$a2 = ($y & 0xFF0000) >> 16;
				
		return array((int)$a2,(int)$a1,(int)$a0);
	}
	
	//The DashCode decoder hasn't and doesn't really need to be implemented in PHP
	private function decode($a2,$a1,$a0){
		return ($a2 << 16)+($a1 << 8)+$a0;
	}


	public function todc($string){
		$string = str_pad($string,48,"~");
		
		$cs=str_split($string,3);
		$final = array();
		
		$validation=json_decode
			("[
				[255,0,0],
				[255,127,0],
				[255,255,0],
				[0,255,0],
				[0,255,255],
				[0,0,255],
				[127,0,255],
				
				[0,0,255],
				[0,255,255],
				[128,0,0],
				[127,0,255],
				[75,0,130],
				[255,0,0],
				[0,255,0],
				[255,215,0],
				[255,255,0]
			]",true);
		
		$i=0;
		while($i < 16){
			list($r,$g,$b) = $validation[$i];
			$final[]=$validation[$i];
			$final[]=$validation[$i];
			
			
			$s=str_split($cs[$i]);
			foreach($s as $v){
				$final[] = $this->encode($v);
			}
			$i++;
		}
		
		return $final;
	}
	
	private function pngdata($im){
		$cachefile = dirname(__FILE__)."/temp_".time();
		imagepng($im,$cachefile);
		$c=file_get_contents($cachefile);
		unlink($cachefile);
		return $c;
	}
	
	public function dcimg($in){
		$im = imagecreatetruecolor(80,1);
		foreach($in as $k=>$v){
			$c = imagecolorallocate($im,$v[0],$v[1],$v[2]);
			imagesetpixel($im,$k,0,$c);
		}
		
		return $this->pngdata($im);
	}
	
	public function dashoff($t){
		return $this->dcimg($this->todc($t));
	}
}
