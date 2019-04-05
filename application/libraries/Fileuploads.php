<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once dirname(__FILE__) .'/Fileuploads/Fileuploader.php';
class Fileuploads extends Fileuploader {
        
//        function __construct($params)
//       {    
//           $name = 'files';
//           $options = array(
//                        'limit' => null,
//                        'maxSize' => null,
//                        'fileMaxSize' => null,
//                        'extensions' => null,
//                        'required' => false,
//                        'uploadDir' => COMPANY_LOGO,
//                        'title' => 'name',
//                        'replace' => false,
//                        'listInput' => true,
//                        'files' => null
//                    );
//           parent::__construct($name,$options);
//       }
        public function some_method()
        {
            echo 'okokok';
        }
        public function upload_all($name,$upload_dir,$files=null,$title='name',$limit=null,$max_size=null,$file_max_size=null,$extentions=null,$replace=false,$list_input=true)
        { 
            $options = array(
                         'limit' => $limit,
                         'maxSize' => $max_size,
                         'fileMaxSize' => $file_max_size,
                         'extensions' => $extentions,
                         'required' => false,
                         'uploadDir' => $upload_dir,
                         'title' => $title,
                         'replace' => $replace,
                         'listInput' => $list_input,
                         'files' => $files
                     );
             $this->initialize($name, $options);
              

                // call to upload the files
            $data = $this->upload();

            // if uploaded and success
            if($data['isSuccess'] && count($data['files']) > 0) {
                // get uploaded files
                $uploadedFiles = $data['files'];
            }
            // if warnings
                if($data['hasWarnings']) {
                $warnings = $data['warnings'];

                        echo '<pre>';
                print_r($warnings);
                        echo '</pre>';
            }

                // unlink the files
                // !important only for appended files
                // you will need to give the array with appendend files in 'files' option of the fileUploader
                foreach($this->getRemovedFiles('file') as $key=>$value) {
                        unlink($upload_dir . $value['name']);
                }

                // get the fileList
                $fileList = $this->getFileList();
                return $fileList;
                // show
//                echo '<pre>';
//                print_r($fileList);
//                echo '</pre>';
        }
}