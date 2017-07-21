<?php

require_once( "smarty/libs/Smarty.class.php");

class MySmarty extends Smarty{

public function _construct(){

	$this->Smarty();
	$this->template_dir = "./templates";
	$this->compile_dir = "./templates_c";
	$this->plugins_dir = "./smarty/libs/plugins";

}


}

?>