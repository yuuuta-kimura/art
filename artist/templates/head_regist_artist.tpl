<script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="http://ajaxzip3.googlecode.com/svn/trunk/ajaxzip3/ajaxzip3.js" charset="UTF-8"></script>

<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/prototype.js"></script>

{literal}

<script>

function check_profile(){

	if(window.confirm('実行しても宜しいでしょうか？')){

		var flag = 0;

		if(document.frm_regist_artist.text_kanji_sei.value == ""){
			document.getElementById("error_text_kanji_sei").innerHTML = "※入力されていません";
			flag = 1;
		}else{
			document.getElementById("error_text_kanji_sei").innerHTML = "";
		}

		if(document.frm_regist_artist.text_kanji_mei.value == ""){
			document.getElementById("error_text_kanji_mei").innerHTML = "※入力されていません";
			flag = 1;
		}else{
			document.getElementById("error_text_kanji_mei").innerHTML = "";
		}

		if(document.frm_regist_artist.text_kana_sei.value == ""){
			document.getElementById("error_text_kana_sei").innerHTML = "※入力されていません";
			flag = 1;
		}else{
			document.getElementById("error_text_kana_sei").innerHTML = "";
		}

		if(document.frm_regist_artist.text_kana_mei.value == ""){
			document.getElementById("error_text_kana_mei").innerHTML = "※入力されていません";
			flag = 1;
		}else{
			document.getElementById("error_text_kana_mei").innerHTML = "";
		}
		
		var Mail=document.frm_regist_artist.text_mailaddress.value ;
		if(Mail == "")
		{
			document.getElementById("error_text_mail").innerHTML = "※入力されていません";
			flag = 1;
		}
		else
		{	
			var Seiki=/[!#-9A-~]+@+[a-z0-9]+.+[^.]$/i;
			if(!Mail.match(Seiki))
			{
				document.getElementById("error_text_mail").innerHTML = "※メールアドレスとして正しい形ではありません";
				flag = 1;
			}
			else
			{
				var errorMail=document.getElementById("error_text_mail").innerHTML;
				if(errorMail!="")
				{
					flag = 1;	
				}else{
					document.getElementById("error_text_mail").innerHTML = "";
				}
			}
		}
		
		if(flag){		
			document.getElementById("error_all").innerHTML = "入力されていない項目があります";
			return false; // 送信を中止
		}
		else{	
			document.getElementById("error_all").innerHTML = "";
			return true; // 送信を実行
		}
				
	}else{
		window.alert('キャンセルされました');		
		return false;
	}
}
	

function check_regist(){

	var flag = 0;

	// 設定開始（必須にする項目を設定してください）
			
	if(document.frm_regist_artist.text_kanji_sei.value == ""){
		document.getElementById("error_text_kanji_sei").innerHTML = "※入力されていません";
		flag = 1;
	}else{
		document.getElementById("error_text_kanji_sei").innerHTML = "";
	}

	if(document.frm_regist_artist.text_kanji_mei.value == ""){
		document.getElementById("error_text_kanji_mei").innerHTML = "※入力されていません";
		flag = 1;
	}else{
		document.getElementById("error_text_kanji_mei").innerHTML = "";
	}

	if(document.frm_regist_artist.text_kana_sei.value == ""){
		document.getElementById("error_text_kana_sei").innerHTML = "※入力されていません";
		flag = 1;
	}else{
		document.getElementById("error_text_kana_sei").innerHTML = "";
	}

	if(document.frm_regist_artist.text_kana_mei.value == ""){
		document.getElementById("error_text_kana_mei").innerHTML = "※入力されていません";
		flag = 1;
	}else{
		document.getElementById("error_text_kana_mei").innerHTML = "";
	}


	if(document.frm_regist_artist.slt_gender.value == ""){
		document.getElementById("error_slt_gender").innerHTML = "※入力されていません";
		flag = 1;
	}else{
		document.getElementById("error_slt_gender").innerHTML = "";
	}

	if(document.frm_regist_artist.slt_birth_year.value == ""){
		document.getElementById("error_slt_birth_year").innerHTML = "※入力されていません";
		flag = 1;
	}else{
		document.getElementById("error_slt_birth_year").innerHTML = "";
	}

	if(document.frm_regist_artist.slt_birth_month.value == ""){
		document.getElementById("error_slt_birth_month").innerHTML = "※入力されていません";
		flag = 1;
	}else{
		document.getElementById("error_slt_birth_month").innerHTML = "";
	}

	if(document.frm_regist_artist.slt_birth_day.value == ""){
		document.getElementById("error_slt_birth_day").innerHTML = "※入力されていません";
		flag = 1;
	}else{
		document.getElementById("error_slt_birth_day").innerHTML = "";
	}


	if(document.frm_regist_artist.text_main_record.value == ""){
		document.getElementById("error_text_main_record").innerHTML = "※入力されていません";
		flag = 1;
	}else{
		document.getElementById("error_text_main_record").innerHTML = "";
	}

	if(document.frm_regist_artist.text_sub_record.value == ""){
		document.getElementById("error_text_sub_record").innerHTML = "※入力されていません";
		flag = 1;
	}else{
		document.getElementById("error_text_sub_record").innerHTML = "";
	}


	var Mail=document.frm_regist_artist.text_mailaddress.value ;
	if(Mail == "")
	{
		document.getElementById("error_text_mail").innerHTML = "※入力されていません";
		flag = 1;
	}
	else
	{	
		var Seiki=/[!#-9A-~]+@+[a-z0-9]+.+[^.]$/i;
		if(!Mail.match(Seiki))
		{
			document.getElementById("error_text_mail").innerHTML = "※メールアドレスとして正しい形ではありません";
			flag = 1;
		}
		else
		{
			var errorMail=document.getElementById("error_text_mail").innerHTML;
			if(errorMail!="")
			{
				flag = 1;	
			}else{
				document.getElementById("error_text_mail").innerHTML = "";
			}
		}
	}
	
	if(document.frm_regist_artist.chkbox_doui.checked == false){
		document.getElementById("error_doui").innerHTML = "※規約に同意できない場合は本サービスをご利用できません";
		flag = 1;
	}else{
		document.getElementById("error_doui").innerHTML = "";
	}

	if(flag){		
		document.getElementById("error_all").innerHTML = "入力されていない項目があります";
		return false; // 送信を中止
	}
	else{	
		document.getElementById("error_all").innerHTML = "";
		return true; // 送信を実行
	}
}


function mail_check()
{
	var ArtistId=document.frm_regist_artist.artist_id.value ;
	var Mail=document.frm_regist_artist.text_mailaddress.value ;
	if(Mail != "")
	{
		var Seiki=/[!#-9A-~]+@+[a-z0-9]+.+[^.]$/i;
		if(!Mail.match(Seiki))
		{
			document.getElementById("error_text_mail").innerHTML = "※不正な文字列、またはメールアドレスとして正しい形ではありません";			
		}else
		{
			
			var a = new Ajax.Request( 
					"./ajax/mailcheck.php", 
			{ 
				"method": "post", 
				"parameters": "text_mailaddress="+Mail+"&artist_id="+ArtistId, 
				onComplete: function(request) 
				{ 
					var json; 
					json = JSON.parse(request.responseText);
					
					if(json!="none")	
					{
						document.getElementById("error_text_mail").innerHTML = "※すでに登録しているメールアドレスです";		
					}
					else
					{
						document.getElementById("error_text_mail").innerHTML = "";
					}	
				}
			}); 	
		}
	}
}


</script>

{/literal}
