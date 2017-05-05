<?php

require_once 'ThumbLib.inc.php';

class Upload {
	
	// Biến lưu trữ tên tập tin
	private $_fileName;
	
	// Biến lưu trữ kích thước tập tin
	private $_fileSize;
	
	// Biến lưu trữ phần mở rộng tập tin
	private $_fileExtension;
	
	// Biến lưu trữ đường dẫn thư mục tạm
	private $_fileTmp;
	
	// Biến lưu trữ lỗi
	private $_errors;
	
	// Biến lưu trữ đường dẫn upload
	private $_uploadDir;
	
	// Phương thức khởi tạo
	public function __construct($fileName){
		$fileInfo				= $_FILES[$fileName];
		$this->_fileName 		= $fileInfo['name'];
		$this->_fileSize 		= $fileInfo['size'];
		$this->_fileExtension 	= $this->getFileExtension();
		$this->_fileTmp 		= $fileInfo['tmp_name'];
		
	}
	
	// Phương thức lấy phần mở rộng
	private function getFileExtension(){
		$ext	= pathinfo($this->_fileName, PATHINFO_EXTENSION);
		return $ext;
	}
	
	// Phương thức thiết lập phần mở rộng jpge jpg png doc zip
	public function setFileExtension($arrExtension){
		if(in_array(strtolower($this->_fileExtension), $arrExtension) == false){
			$this->_errors[]	= 'Phần mở rộng không đúng quy định';
		}
	}
	
	// Phương thức thiết lập kích thước tối thiểu và kích thước tối đa được cho phép
	public function setFileSize($min, $max){
		if($this->_fileSize < $min || $this->_fileSize > $max){
			$this->_errors[]	= 'Kích thước không đúng quy định';
		}
	}
	
	// Phương thức thiết lập đường dẫn đến foleder upload
	public function setUploadDir($value){
		if(file_exists($value)){
			$this->_uploadDir = $value;
		}else{
			$this->_errors[]	= 'Đường dẫn không tồn tại';
		}
		
		
		
	}
	
	// Phương thức kiểm tra điều kiện upload của tập tin
	public function isValid(){
		$flag	= count(($this->_errors)) > 0 ? false : true;
		return $flag;
	}
	
	// Phương thức hiển thị lỗi
	public function showError(){
		$xhtml = '';
		if(!empty($this->_errors)){
			$xhtml = '<ul class="alert alert-danger">';
			foreach ($this->_errors as $error){
				$xhtml .= '<li>'.$error.'</li>';
			}
			$xhtml .= '</ul>';
		}
		return $xhtml;
	}
	
	// Phương thức upload tập tin
	public function upload($rename = true){
		if($rename == true){
			$fileName	 = $this->randomString();
			$destination = $this->_uploadDir . $fileName;
		}else{
			$destination = $this->_uploadDir . $this->_fileName;
		}
		
		@move_uploaded_file($this->_fileTmp, $destination);
		
		$fileName	= pathinfo($destination, PATHINFO_FILENAME);
		
		// 125 x 125
		
		$thumb	= PhpThumbFactory::create($destination);
		$thumb->resize(125, 125);
		$thumb->save($this->_uploadDir . '125-' . $fileName . '.' . $this->_fileExtension);
		 
		// 450 x 450
		
		$thumb	= PhpThumbFactory::create($destination);
		$thumb->resize(450, 450);
		$thumb->save($this->_uploadDir . '450-' . $fileName . '.' . $this->_fileExtension);
		
	}
	
	private function randomString($length = 5){
		$arrCharacter	= array_merge(range('A', 'Z'), range('a','z'), range(0,9));
		$arrCharacter	= implode($arrCharacter, ''); 
		$arrCharacter	= str_shuffle($arrCharacter);
		
		$result			= substr($arrCharacter, 0, $length) . '.' . $this->_fileExtension;
		return $result;	
	}
	
	
	
}













