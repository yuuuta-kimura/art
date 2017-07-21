<?php

//////////////////////////////////////
// admin/func_login_admin.php
//////////////////////////////////////


function admin_login($mail, $randpass){

require('../qwertyu.php');

	$hit=0;

	if($randpass==$superpass && $mail='grhkimurayu@gmail.com'){
		return 1;
	}else{
		return 0;		
	}
		
}

function admin_login_session($randpass){

require('../qwertyu.php');

	$hit=0;

	if($randpass==$superpass){
		return 1;
	}else{
		return 0;		
	}
		
}


?>