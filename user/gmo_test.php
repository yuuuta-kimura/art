<?php

ini_set("display_errors",1);

if ($_SERVER['SERVER_NAME']=='localhost') {//ローカルホスト
    $path = '/Applications/MAMP/htdocs/magnolia/user/gmo';
} else {//リモートホスト
    $path = "/home/users/1/velvet.jp-magnolia/web/farm/user/gmo"; 
} 

echo $path;

set_include_path(get_include_path() .PATH_SEPARATOR. $path);

//require_once( './config.php');

if( isset( $_POST['submit'] ) ){


	require_once( 'gmo/com/gmo_pg/client/input/EntryTranInput.php');
	require_once( 'gmo/com/gmo_pg/client/tran/EntryTran.php');
	
	//入力パラメータクラスをインスタンス化します
	$input = new EntryTranInput();/* @var $input EntryTranInput */
	
	//このサンプルでは、ショップID・パスワードはコンフィグファイルで
	//定数defineしています。
	$input->setShopId("tshop00023932");
	//$input->setShopPass("zkez4w7m");
	$input->setShopPass("yuta6151+");
	
	//各種パラメータを設定しています。
	//実際には、処理区分や利用金額、オーダーIDといったパラメータをカード所有者が直接入力することは無く、
	//購買内容を元に加盟店様システムで生成した値が設定されるものと思います。
	$input->setJobCd("AUTH");
	$input->setOrderId('123456789012345678901234599');
	//$input->setItemCode("");
	$input->setAmount('1000');
	$input->setTax('80');
	//$input->setTdFlag("0");
	//$input->setTdTenantName("");
	
	//API通信クラスをインスタンス化します
	$exe = new EntryTran();/* @var $exec EntryTran */
	
	//パラメータオブジェクトを引数に、実行メソッドを呼び、結果を受け取ります。
	$output = $exe->exec( $input );/* @var $output EntryTranOutput */

	//実行後、その結果を確認します。
	

	if( $exe->isExceptionOccured() ){//取引の処理そのものがうまくいかない（通信エラー等）場合、例外が発生します。

		//サンプルでは、例外メッセージを表示して終了します。
		require_once('../sample/display/Exception.php');
		exit();
		
	}else{

		
		//例外が発生していない場合、出力パラメータオブジェクトが戻ります。
	
		if( $output->isErrorOccurred() ){//出力パラメータにエラーコードが含まれていないか、チェックしています。

		
			//サンプルでは、エラーが発生していた場合、エラー画面を表示して終了します。
			//require_once('../sample/display/Error.php');

			require_once('ErrorMessageHandler.php');
			$errorHandle = new ErrorHandler();
			$errorList = $output->getErrList();
			
			foreach( $errorList as  $errorInfo ){/* @var $errorInfo ErrHolder */
				
				echo '<li>'
					. $errorInfo->getErrCode()
					. ':' . $errorInfo->getErrInfo()
					. ':' . $errorHandle->getMessage( $errorInfo->getErrInfo() )
					.'</li>';
			}

			exit();
			
		}
		else{
			echo $output->getAccessId();
			echo "<BR>";
			echo $output->getAccessPass();
			
		}

		//例外発生せず、エラーの戻りもないので、正常とみなします。
		//このif文を抜けて、結果を表示します。
	}
	
}else{

	//EntryTran入力・結果画面
	require_once('../sample/display/EntryTran.php' );
}


?>

<form action="" method="post">
<input type="submit" name="input_btn" value="test" />
</form>
