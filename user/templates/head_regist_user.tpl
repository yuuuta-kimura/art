<script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>

<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/prototype.js"></script>

{literal}

<script>

function set_clickbtn(s_val)
{
	document.frm_regist_user.onbtn.value = s_val;
}


function check(){

	var flag = 0;

	if(document.frm_regist_user.onbtn.value=="regist"){

		// 設定開始（必須にする項目を設定してください）
		if(document.frm_regist_user.text_kanji_sei.value == ""){
			document.getElementById("error_text_kanji_sei").innerHTML = "※選択されていません";
			flag = 1;
		}else{
			document.getElementById("error_text_kanji_sei").innerHTML = "";
		}
	
		if(document.frm_regist_user.text_kanji_mei.value == ""){
			document.getElementById("error_text_kanji_mei").innerHTML = "※選択されていません";
			flag = 1;
		}else{
			document.getElementById("error_text_kanji_mei").innerHTML = "";
		}

		if(document.frm_regist_user.text_kana_sei.value == ""){
			document.getElementById("error_text_kana_sei").innerHTML = "※選択されていません";
			flag = 1;
		}else{
			document.getElementById("error_text_kana_sei").innerHTML = "";
		}
	
		if(document.frm_regist_user.text_kana_mei.value == ""){
			document.getElementById("error_text_kana_mei").innerHTML = "※選択されていません";
			flag = 1;
		}else{
			document.getElementById("error_text_kana_mei").innerHTML = "";
		}
		
		if(document.frm_regist_user.slt_birth_year.value == ""){
			document.getElementById("error_slt_birth_year").innerHTML = "※選択されていません";
			flag = 1;
		}else{
			document.getElementById("error_slt_birth_year").innerHTML = "";
		}

		if(document.frm_regist_user.slt_gender.value == ""){
			document.getElementById("error_slt_gender").innerHTML = "※選択されていません";
			flag = 1;
		}else{
			document.getElementById("error_slt_gender").innerHTML = "";
		}
		
		if(document.frm_regist_user.slt_prefecture.value == ""){
			document.getElementById("error_slt_prefecture").innerHTML = "※選択されていません";
			flag = 1;
		}else{
			document.getElementById("error_slt_prefecture").innerHTML = "";
		}
	
		var Mail=document.frm_regist_user.text_mailaddress.value ;
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
				document.getElementById("error_text_mail").innerHTML = "";
			}
		}
		
		if(document.frm_regist_user.chkbox_doui.checked == false){
			document.getElementById("error_doui").innerHTML = "※規約に同意できない場合は本サービスをご利用できません";
			flag = 1;
		}else{
			document.getElementById("error_doui").innerHTML = "";
		}
	
		if(flag){		
			document.getElementById("error_all").innerHTML = "※入力されていない項目があります";
			return false; // 送信を中止
		}
		else{	
			document.getElementById("error_all").innerHTML = "";
			return true; // 送信を実行
		}
	}else{
		return true; // 送信を実行
	}

}


function mail_check()
{
	var Mail=document.frm_regist_user.text_mailaddress.value ;
	if(Mail != "")
	{
		var Seiki=/[!#-9A-~]+@+[a-z0-9]+.+[^.]$/i;
		if(!Mail.match(Seiki))
		{
			document.getElementById("error_text_mail").innerHTML = "※不正な文字列、またはメールアドレスとして正しい形ではありません";			
		}else
		{
			
			var a = new Ajax.Request( 
					"./ajax/mailcheck_user.php", 
			{ 
				"method": "post", 
				"parameters": "text_mailaddress="+Mail, 
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


function select_city(ctr)
{
	//select_city_base();

	var flg =0;
	if(ctr=='a')
	{
		var select = document.getElementById("slt_prefecture_now").value;
	}else if(ctr=='b'){
		var select = document.getElementById("slt_prefecture_birth").value;
	}else{
		flg=1;
	}
	
	if(flg==0)
	{
		var b = new Ajax.Request( 
				"./ajax/select_city.php", 
		{ 
			"method": "post", 
			"parameters": "pref="+select, 
			//onSuccess: function(request) { 
			//}, 
			onComplete: function(request) { 
				var json; 
				json = JSON.parse(request.responseText);
				var slt_city ="<select id='slt_city_now' name='slt_city_now'>";
				slt_city += '<option value="">選択してください</option>';
				for (i = 0; i < json.length; i = i +1){
						slt_city += '<option value=\" ' +  json[i].name +'\">' + json[i].name + '</option>';
				}
				slt_city +="</select>";
	
				if(ctr=='a')
				{
					document.getElementById("slt_city_now").innerHTML = slt_city;
				}else if(ctr=='b'){
					document.getElementById("slt_city_birth").innerHTML = slt_city;
				}
			}
		}); 
	}
}

</script>

{/literal}
