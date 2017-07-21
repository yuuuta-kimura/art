<?php

//////////////////////////////////////
// artist/mymail.php
//////////////////////////////////////


function MailBody_first($nickname,$supportmail,$naiyo) {
	$mail_body = sprintf("%s様", $nickname);
	$mail_body .= PHP_EOL.PHP_EOL;
	$mail_body .= "『e-ART』へのご申請ありがとうございます。".PHP_EOL;
	$mail_body .= "後日、当社担当より、詳しい内容をお伺いするため、メールにてご返信させていただきます。".PHP_EOL;
	$mail_body .= "その上で、本サービスへの登録の認可が判断されますので、予めご了承ください。".PHP_EOL.PHP_EOL;
		$mail_body .= PHP_EOL.PHP_EOL;
	$mail_body .= "*****************************************************************************".PHP_EOL;
	$mail_body .= $naiyo.PHP_EOL;
	$mail_body .= "*****************************************************************************".PHP_EOL;
	$mail_body .= PHP_EOL.PHP_EOL;
	$mail_body .= "なお、ご登録していただくことにより、下記の規約に同意いただいたものとみなしますので、必ず規約を確認をしてください。".PHP_EOL;
	$mail_body .= PHP_EOL.PHP_EOL;
	$mail_body .= "*****************************************************************************".PHP_EOL;
	$mail_body .= file_get_contents('kiyaku.txt').PHP_EOL.PHP_EOL;
	$mail_body .= "*****************************************************************************".PHP_EOL;
	$mail_body .= PHP_EOL;
	$mail_body .= "/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/".PHP_EOL;
	$mail_body .= "e-ART 事務局".PHP_EOL;
	$mail_body .= "mail".':  '.$supportmail. PHP_EOL;
	$mail_body .= "/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/".PHP_EOL;

return $mail_body;
}

function MailBody_user($nickname,$supportmail,$naiyo) {
	$mail_body = sprintf("%s様", $nickname);
	$mail_body .= PHP_EOL.PHP_EOL;
	$mail_body .= "『e-ART』へのご登録ありがとうございます。".PHP_EOL;
	$mail_body .= "引き続き『e-ART』をどうぞよろしくお願いいたします。".PHP_EOL;
	$mail_body .= PHP_EOL.PHP_EOL;
	$mail_body .= "*****************************************************************************".PHP_EOL;
	$mail_body .= $naiyo.PHP_EOL;
	$mail_body .= "*****************************************************************************".PHP_EOL;
	$mail_body .= PHP_EOL.PHP_EOL;
	$mail_body .= "ご申請していただくことにより、下記の一般向け利用規約、プライバシーポリシー、特定商取引に関する表示に同意いただいたものとみなしますので、必ず規約を確認をしてください。".PHP_EOL;
	$mail_body .= PHP_EOL.PHP_EOL;
	$mail_body .= "*****************************************************************************".PHP_EOL;
	$mail_body .= file_get_contents('kiyaku_user.txt').PHP_EOL.PHP_EOL;
	$mail_body .= "*****************************************************************************".PHP_EOL;
	$mail_body .= PHP_EOL;
	$mail_body .= "/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/".PHP_EOL;
	$mail_body .= "e-ART 事務局".PHP_EOL;
	$mail_body .= "mail".':  '.$supportmail. PHP_EOL;
	$mail_body .= "/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/".PHP_EOL;

return $mail_body;
}


function MailBody_password($nickname,$pass,$supportmail) {

	$mail_body = sprintf("%s様", $nickname);
	$mail_body .= PHP_EOL.PHP_EOL;
	$mail_body .= "『e-ART』へのログインパスワードを再作成しました。".PHP_EOL;
	$mail_body .= PHP_EOL;
	$mail_body .= "下記の新しいパスワードでログインしてください。".PHP_EOL;
	$mail_body .= PHP_EOL;
	$mail_body .= 'https://lolipop-7135244fd63eb4a7.ssl-lolipop.jp/art/artist/artist_login.php'.PHP_EOL;
	$mail_body .= "----------------------------------------------------------------".PHP_EOL;	
	$mail_body .= "パスワード：".$pass.PHP_EOL;
	$mail_body .= "----------------------------------------------------------------".PHP_EOL;	
	$mail_body .= PHP_EOL;
	$mail_body .= "※ログイン後、すぐにパスワードを変更してください。".PHP_EOL;
	$mail_body .= PHP_EOL;
    $mail_body .= PHP_EOL;
	$mail_body .= "それでは引き続き、『e-ART』をお楽しみください。".PHP_EOL;
	$mail_body .= PHP_EOL.PHP_EOL.PHP_EOL;		
	$mail_body .= "/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/".PHP_EOL;
	$mail_body .= "e-ART 事務局".PHP_EOL;
	$mail_body .= "mail".':  '.$supportmail. PHP_EOL;
	$mail_body .= "/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/".PHP_EOL;
	
	return $mail_body;
}

function MailBody_password_change($nickname,$pass,$supportmail) {

	$mail_body = sprintf("%s様", $nickname);
	$mail_body .= PHP_EOL.PHP_EOL;
	$mail_body .= "『e-ART』へのログインパスワードを変更しました。".PHP_EOL;
	$mail_body .= PHP_EOL;
	$mail_body .= "下記の新しいパスワードでログインしてください。".PHP_EOL;
	$mail_body .= PHP_EOL;
	$mail_body .= "----------------------------------------------------------------".PHP_EOL;	
	$mail_body .= $pass.PHP_EOL;
	$mail_body .= "----------------------------------------------------------------".PHP_EOL;	
	$mail_body .= PHP_EOL;
    $mail_body .= PHP_EOL;
	$mail_body .= "それでは引き続き、『e-ART』をお楽しみください。".PHP_EOL;
	$mail_body .= PHP_EOL.PHP_EOL.PHP_EOL;		
	$mail_body .= "/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/".PHP_EOL;
	$mail_body .= "e-ART 事務局".PHP_EOL;
	$mail_body .= "mail".':  '.$supportmail. PHP_EOL;
	$mail_body .= "/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/".PHP_EOL;
	
	return $mail_body;
}


function MySendMail($addr, $title, $body, $from) {

	mb_language("ja");
	mb_internal_encoding("UTF-8");

    //Fromに日本語は入れない

	return mb_send_mail($addr,$title,$body,$from);
}


function MySendMailandCC($addr, $title, $body, $from, $cc) {

	mb_language("ja");
	mb_internal_encoding("UTF-8");

	$from.="\n";
	$from.="Cc:".$cc;

    //Fromに日本語は入れない

	return mb_send_mail($addr,$title,$body,$from);
}

?>
