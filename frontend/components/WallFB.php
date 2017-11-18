<?php
    namespace frontend\components;
    
    class WallFB
    {
        public $group_id;
        public $at;
        public function __construct($name)
        {
            $this->at="573815686124177|gEwY_inZ-n_4MVZStgQZ6cHKuRM";
            $pos=strripos($name, '.com');
            $name=substr($name, $pos+5);
            if($name{strlen($name)-1}=='/')
                $name=substr($name, 0, -1);
            $group_id=file_get_contents("https://graph.facebook.com/".$name."?access_token=$this->at");
            $group_id=json_decode($group_id);
            $this->group_id=$group_id->id;                
        }
        
        public function getWall()
        {            
            $g=  (file_get_contents("https://graph.facebook.com/".$this->group_id."/feed?access_token=$this->at&limit=10"));
            $g=json_decode($g);
            return $g->data;
        }
        
    }
?>