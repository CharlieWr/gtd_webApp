<?php
    require_once "../Model/TagModel.php";

    
    class TagControl {
        
        public function getTagByStuffId($idStuff){
            if(!is_numeric($idStuff)){
                die("El Id Stuff debe ser de tipo entero valido");
            }
            else{
            $tagModel = new TagModel();
            
            $tagList = $tagModel->selectTagByStuffId($idStuff);
            
            return $tagList;
                    
            }
            
        }
    }
?>
