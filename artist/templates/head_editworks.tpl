<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script type="text/javascript" src="js/prototype.js"></script>

{literal}

<script>

function check(){

	var flag = 0;
	if(document.frm_EditWork.text_zaiko_num.value == "" || document.frm_EditWork.text_zaiko_num.value < 1){
		document.getElementById("error_text_zaiko_num").innerHTML = "※1個以上を入力してください";
		flag = 1;
	}else{
		document.getElementById("error_text_zaiko_num").innerHTML = "";
	}
	
	if(flag == 0)
	{
		if(window.confirm('実行しても宜しいでしょうか？')){
			return true;
		}else{
			window.alert('キャンセルされました');		
			return false;
		}
	}else{
		return false;		
	}
}
	
function uploadpicture(pic){

	var flg =0;

	switch(pic)
	{
		case 'mainpic':
		Path=document.frm_EditWork.mainpic.value;
		error_btn="error_mainpic_btn";		
		document.getElementById("upload_btn_no").innerHTML="<input type='hidden' name='upload_btn' id='upload_btn' value='mainpic'/>";
		break;
		
		case 'basepic':
		Path=document.frm_EditWork.basepic.value;
		error_btn="error_basepic_btn";		
		document.getElementById("upload_btn_no").innerHTML="<input type='hidden' name='upload_btn' id='upload_btn' value='basepic'/>";
		break;
	}
	if(Path==""){		
		document.getElementById(error_btn).innerHTML = "アップロード先が指定されていません";	
		flg =1;
	}

	
	if(flg==0)
	{	

		// ------------------------------------------------------------
		// FormData オブジェクトを作成する
		// ------------------------------------------------------------
		var form_data = new FormData(frm_EditWork);
	
		// ------------------------------------------------------------
		// XMLHttpRequest オブジェクトを作成
		// ------------------------------------------------------------
		var xhr = new XMLHttpRequest();
	
		// ------------------------------------------------------------
		// XHR 通信に成功すると実行されるイベント
		// ------------------------------------------------------------
		xhr.onload = function (e){
			// レスポンスボディを取得する
			console.log(xhr.responseText );

  			if (xhr.readyState == 4) {if (xhr.status == 200) {

				var json; 
				json = eval("(" + xhr.responseText + ")");

				switch (json.error)
				{
				
					case "-1":
						document.getElementById(error_btn).innerHTML="ファイルがありません";
						break;
					case "-2":
						document.getElementById(error_btn).innerHTML="アップロードできませんでした（ファイル移動）";
						break;
					case "-3":
						document.getElementById(error_btn).innerHTML="アップロードできませんでした（パラメーター）";
						break;
					case "-4":
						document.getElementById(error_btn).innerHTML="アップロードできませんでした（拡張子）";
						break;
					case "-5":
						document.getElementById(error_btn).innerHTML="アップロードできませんでした（転送）";
						break;
					default:

						document.getElementById(error_btn).innerHTML="アップロード完了";
						var imagetag = '';
	
						imagetag = '<img src="'+json[0].url;
			
						switch(pic)
						{
							case 'mainpic':
							imagetag += '" class="mainpic">';
							document.getElementById("main_pic").innerHTML = imagetag;
							break;

							case 'basepic':
							imagetag += '" class="basepic">';
							document.getElementById("base_pic").innerHTML = imagetag;
							break;
						}
						break;
				}
			}}
		};

		// ------------------------------------------------------------
		// 送信が失敗したときに実行されるイベント
		// ------------------------------------------------------------
		xhr.upload.onerror = function(e){
			console.log("送信に失敗");
			document.getElementById(error_btn).innerHTML = "アップロード失敗";
		};
	
		// ------------------------------------------------------------
		// 送信中に XHR 通信を中止すると実行されるイベント
		// ------------------------------------------------------------
		xhr.upload.onabort = function(e){
			console.log("XHR 通信を中止");
			document.getElementById(error_btn).innerHTML = "アップロード中止";
		};
	
		// ------------------------------------------------------------
		// 送信中にタイムアウトエラーが発生すると実行されるイベント
		// ------------------------------------------------------------
		xhr.upload.ontimeout = function(e){
			console.log("タイムアウトエラーが発生");
			document.getElementById(error_btn).innerHTML = "タイムアウトエラー発生";
		};

		// ------------------------------------------------------------
		// XHR 送信が失敗したときに実行されるイベント
		// ------------------------------------------------------------
		xhr.onerror = function(e){
			console.log("受信に失敗");
			document.getElementById(error_btn).innerHTML = "アップロード失敗";
		};
		
		// ------------------------------------------------------------
		// XHR 通信を中止すると実行されるイベント
		// ------------------------------------------------------------
		xhr.onabort = function(e){
			console.log("XHR 通信を中止");
			document.getElementById(error_btn).innerHTML = "アップロード中止";
		};
		
		// ------------------------------------------------------------
		// タイムアウトエラー発生時に実行されるイベント
		// ------------------------------------------------------------
		xhr.ontimeout = function(e){
			console.log("タイムアウトエラーが発生");
			document.getElementById(error_btn).innerHTML = "タイムアウトエラー発生";
		};
			
		// ------------------------------------------------------------
		// 「POST メソッド」「接続先 URL」を指定
		// ------------------------------------------------------------
		xhr.open("POST" , "ajax/uploadpicture.php?type=json");
	
		// ------------------------------------------------------------
		// 「送信データに FormData を指定」「XHR 通信を開始する」
		// ------------------------------------------------------------
		xhr.send(form_data);
		document.getElementById(error_btn).innerHTML = "アップロード開始";
	
	}

}



</script>


{/literal}
