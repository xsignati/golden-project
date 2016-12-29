<?php
	include("TemplateHandler.php");
	include 'Database.php';
	class TemplateEngine{
		protected $serverName;
		protected $userName;
		protected $password;
		protected $dbName;
		protected $database;
		protected $connection;
		protected $subTemplates;

		public function run(){
			include('databaseInfo.php');
			$this->database = new Database($serverName, $userName, $password, $dbName);
				if($this->database->connectDatabase()){
					$this->connection = $this->database->getConnection();
				}
				else return false;
				$this->createWebsite();
		}
		
		public function createWebsite(){
			//merge templates
			$tplDir = '../tpl/';
			$dirs = array_diff(scandir($tplDir), array('.', '..'));
			foreach($dirs as $dir){
				$this->subTemplates[$dir] = file_get_contents("$tplDir"."$dir");
			}
			$htmlFile = "$tplDir" . "main-template.htpl";
			$cssFile = "$tplDir" . "main-template_css.ctpl"; 
			$templateHandler = new TemplateHandler($htmlFile, $cssFile);
			$templateHandler->init();
			$templateHandler->loadSubTemplates($this->subTemplates);
			$templateHandler->prepare();

			//get content from database
			if ($this->database->connectDatabase()){
				$connection = $this->database->getConnection();
				$query = "SELECT 
				index_texts.type, index_texts.content, index_texts.path
				FROM index_texts
				LEFT JOIN
				images
				ON index_texts.type = images.type";
				$result = $connection->query($query);
				while($resultSet = mysqli_fetch_assoc($result)) {
					if($resultSet['content'] != null){
						$templateHandler->addTextToElement($resultSet['type'],$resultSet['content']);
					}
					if($resultSet['path'] != null){
						$cssPath = "\t" . "background-image: url(\"" . $resultSet['path'] . "\");";
						$templateHandler->addCssToElement($resultSet['type'], $cssPath);
					}
				}
			}
			$templateHandler->save("../index.html","../css/index.css");
		}
	}
?>