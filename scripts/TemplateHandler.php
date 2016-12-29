<?php
	class TemplateHandler{
		protected $htmlFile;
		protected $cssFile;
		protected $html;
		protected $htmlDoc;
		protected $css;

		public function __construct($htmlFile, $cssFile) {
			$this->htmlFile = $htmlFile;
			$this->cssFile = $cssFile;
		}
		
		public function init(){
			if (!file_exists($this->htmlFile) || !file_exists($this->cssFile) ) {
				return "Error loading html/css templates ($this->htmlFile, $this->cssFile).";
			}
			$this->html = file_get_contents($this->htmlFile);
			$this->css = file_get_contents($this->cssFile);
			$this->html = preg_replace('/\r\n/', "\n", $this->html);
		}
	  
		public function loadSubTemplates($subTemplates) {
		  
			foreach ($subTemplates as $tplDir => $tplContent) {
				$tagToReplace = "[$tplDir]";
				if(pathinfo($tplDir)['extension'] == "htpl")
					$this->html = str_replace($tagToReplace, $tplContent, $this->html);
				else
				$this->css = str_replace($tagToReplace, $tplContent, $this->css);
			}
		}
		
		public function addTextToElement($tag, $text){
			$this->htmlDoc->getElementById($tag)->appendChild($this->htmlDoc->createTextNode($text));
		}

		public function addCssToElement($tag, $value){
			$pattern = '@[#.]{0,1}\b'.$tag.'\b *{@';
			if(preg_match($pattern, $this->css, $matches_out, PREG_OFFSET_CAPTURE)){
				$tagLength = strlen($matches_out[0][0]);
				$tagPosition = $matches_out[0][1] + $tagLength;
				$this->css = substr_replace($this->css, "\r\n" . $value, $tagPosition, 0 );
			}
			else return "No $pattern found in css file.";
		}
		
		public function prepare(){
			$this->htmlDoc = new DOMDocument();
			$this->htmlDoc->loadHTML($this->html, LIBXML_HTML_NOIMPLIED|LIBXML_HTML_NODEFDTD);
		}

		public function save($htmlPath, $cssPath){
			$this->htmlDoc->saveHTMLFile($htmlPath);
			file_put_contents($cssPath, $this->css);
		}
	}
?>