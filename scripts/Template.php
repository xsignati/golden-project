<?php
class Template
{
   private $hypertext;
   private $hVars;
   private $sheet;
   private $sVars;
   
   function load($hypertextPath, $sheetPath){
      $this->hypertext = $hypertextPath;
	  $this->sheet = file_get_contents($sheetPath);
   }
   
   function replace($var, $content){
      $this->hVars[$var] = $content;
   }
   
   function add($var, $content){
	   $this->sVars[$var] = $content;
   }
   
	function parseSheet($key, $value){
		$pattern = '@[#.]{0,1}\b'.$key.'\b *{@';
		$endl = "\r\n";
		if(preg_match($pattern, $this->sheet, $matches_out, PREG_OFFSET_CAPTURE)){
			$tagLength = strlen($matches_out[0][0]);
			$tagPosition = $matches_out[0][1] + $tagLength;
			$this->sheet = substr_replace($this->sheet, $endl. $value, $tagPosition, 0 );
		}
		else{
			//todo tag sign
			$this->sheet = $this->sheet.$endl.$endl.$key."{".$endl.$value.$endl."}";
		}
	}

	function push($sheetTarget){
		if(is_array($this->sVars) || is_object($this->sVars)){
		   foreach($this->sVars as $key => $value){
			  $this->parseSheet($key, $value);
		   }
		}
		file_put_contents($sheetTarget, $this->sheet);
	   
	   extract($this->hVars);
       include($this->hypertext);
   }
}
?>