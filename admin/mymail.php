<?php


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

function MailBody_ok($nickname,$pass,$supportmail) {
	$mail_body = sprintf("%s様", $nickname);
	$mail_body .= PHP_EOL.PHP_EOL;
	$mail_body .= "『e-ART』へのご申請ありがとうございます。".PHP_EOL;
	$mail_body .= "審査の結果、本サービスへの基準を満たしておりましたので、お知らせいたします。".PHP_EOL;
	$mail_body .= "つきましては、下記のマイページよりプロフィールの登録におすすみください".PHP_EOL;
	$mail_body .= PHP_EOL;
	$mail_body .= "【ログイン画面】".PHP_EOL;
	$mail_body .= "http".':'.'//'."e-art".'.'."tokyo"."/artist/artist_login".'.'.'php'.PHP_EOL;
	$mail_body .= "----------------------------------------------------------------".PHP_EOL;	
	$mail_body .= "パスワード：".$pass.PHP_EOL;
	$mail_body .= "----------------------------------------------------------------".PHP_EOL;	
	$mail_body .= PHP_EOL;
	
	//★正式ローンチ後には復活させること->OK
	$mail_body .= "※ログイン後、すぐにパスワードを変更してください。".PHP_EOL;
	$mail_body .= PHP_EOL;
	$mail_body .= "/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/".PHP_EOL;
	$mail_body .= "e-ART 事務局".PHP_EOL;
	$mail_body .= "mail".':  '.$supportmail. PHP_EOL;
	$mail_body .= "/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/".PHP_EOL;

return $mail_body;
}

function MailBody_ng($nickname,$pass,$supportmail) {
	$mail_body = sprintf("%s様", $nickname);
	$mail_body .= PHP_EOL.PHP_EOL;
	$mail_body .= "『e-ART』へのご申請ありがとうございます。".PHP_EOL;
	$mail_body .= "審査の結果、残念ながら本システムの利用はご利用できませんことを、お知らせいたします。".PHP_EOL;
	$mail_body .= PHP_EOL;
	$mail_body .= "/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/".PHP_EOL;
	$mail_body .= "e-ART 事務局".PHP_EOL;
	$mail_body .= "mail".':  '.$supportmail. PHP_EOL;
	$mail_body .= "/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/".PHP_EOL;

return $mail_body;
}

?>
