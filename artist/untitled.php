<html>
<head>
<meta charset="UTF-8">
<title>無題ドキュメント</title>
</head>
<body>

<?php

/*	$key='3j7j5e1iomx2z17lf2c6wi5eh3k298jz8xudrnyxdmolvpa8qdiuw9t52rx348lpb6togwgpnq8g5wimec464acisvkqpbxh5nn488ci6won3f4qvgkuqav2hcj3s52r0phrvh05ztnjld81boqepvmj6ytuyr49y8trq4eyortfdpha57yrse0z4wnod3425j57k4cskb9dr3ghd3t2y0akgkxoiu21m1sabqv1qz37ct3ejkoh7w7hgqmdepoxggfvjmkspadbjqc1dx9xvrqsblonshns21kqwuuvwowzu6fo4j0hji0q1unqizeba2q575n0gvp1w09pdqh9iizd8xw166axt9vfvje6qn8pvzmir0bt9xl6fter6x0p05fe7dltu7f7l4q6pbor2h0di8r8r4kouc811vixbq5bdonczc8440ocokv349hvhwg2lygjmdiqwq7hvve5a2uppy84q0nf1qvxh85jgorvmh8rb0ov3748pq6mpwpoyqytmjfu06llrbl2lght174t4gq6mzlxt7kcz5muoefpngz0qts86tae5gkrn2k1d0tz9byyqysmsxq49oefasp188udajxgvplnavn77d975imv79np87t92l77306told485gvm6fpfkmwc5gsu1rk9ykxgjkceqnuq3sanb26cjygexn9ub5zxcmbu5j71fiocat1eccd4ojgy129a32q3vzqznpd49hxrssxl2rslecds3xu5v6nxixm72hcic999j7xospjydpykq8qgxe9cp1iq5d262djz8ve0l07jhzdmu4hsjxsl7ve99ysoddt8foq757llqvd5a5hxydmiwqd5gzgms36phjw2ae71o0ra3ue49ua1vj6t0xw1orqzxxn1ctwiaog22gu49058xenkhmbrd1rb6s1mbe5c1hl0ccvhqo9b2l0eyvcryhfy2gssm9aix27gv7s1zh579owyh2aoti0aop8ir3eyoz2p3h0xeb28fwx3erh';
	
    $ciphertext = openssl_encrypt("u5cht7ph0tam7hg1y6j18a1f08z98l0azd63znkn61rbu38gfmh01e3n56twlhtclsv360dohj2bgrfpoahqd0nqbq5ji5zedic9auqbuuzpjzrbjae8btcxgindjny7qhgnfuqytiwx177vckapumit0mh643jwlgu3m2cvm3n89jzj8ev57xe4zt28kse7et9pb1c0f1269rkp205u7vhp5u1snlm5v6e03pr971pv4qzhjhndmgjtjtofefcg", 'AES-128-ECB', $key, OPENSSL_RAW_DATA);
	$hex=bin2hex($ciphertext);
	echo($hex);
	//echo('<BR>');
	$apitext = openssl_decrypt(hex2bin($hex), 'AES-128-ECB', $key ,OPENSSL_RAW_DATA);
	//echo($apitext);
	//echo('<BR>');
*/

/*	$key='j3kihic1ryku5pgeqc09o8xsaf27vegssuahc87zguox0d2kb4ug4tr6tji9r8bs8zf205s1rlywk0k1t1e5tt2b6rjtgo6fhe1o3wv1inv0dgl6h9tch1kr7km6yfpmsmblty21s3owamjhijj6oux2sywlnuiov8pl4rusvqcy28niigu4qze570lcki3efgisr2c8jfv4utt9nua98zemr9ycna5t77nd5yoh822r2hj8iskpskl3r0mcpsj550x1jea2oj328y4dj700dbgrsdie6ke8jrpuztfgoood65xi9oj7dx0puttsuqlk755i7sny516v3dwemuqnn6qgerydk4clzdmlq475c31ge6mfqwb7jz9o4gax586ywth2pfgbrq6i2y7foml6yenzre6g3k6m1jaxy78e1rz4p40jkb9z4lxqog48csoxwkq3n9l2xna42igv563zfzi9vom2sftspz12k562u35rnvy3k3moqhgce50f69tdzi4v4upkxtfkig0l5xdjaftm8wiodcuspwev6sa7sjggb5gpbm93rvj66espsqc109kh7l7cz6cyqvibt0k4dh2thqpc9cfqw08m2vucuz7is6t54n77ksmbxa6l447gx4j5bkxr3pfd43qbxvie0pbkvciwliefbrs19nivrnxxa3f1dltaxjsrh4lcogjh117yu6bbft2trax6ahcydveoilqharl2wv08uifyuizptf0tkkix0cn90j6zuc95x3pnq88oplk7j77u4l8hekutlljhik5v81vp494jjp67mu5nz336xce5xrd1ggxo3z4fxpo99czvsyn4b6wqlxaku0w64mpmcvm2jv5c4b9pzwnetiybpxqafed446eu3s72xyog7osk4h11r6ryrkbeotvxz10t2p4c88vrli8s8pk60tkc86c9qp8p4r12wnpiwi51n7yvu8cnclas6zqao5ygggi5iz33ho5x3ssyaf0m669f3f42nrayl0k8';

	echo(hash("sha256", htmlspecialchars('e-art.neko', ENT_QUOTES,'UTF-8') ,FALSE));
	echo('<BR>');
*/	
	/*
    $ciphertext = openssl_encrypt("ftp.7135244fd63eb4a7.lolipop.jp", 'AES-128-ECB', $key, OPENSSL_RAW_DATA);
	$hex=bin2hex($ciphertext);
	echo($hex);
	echo('<BR>');
	$ftp_server = openssl_decrypt(hex2bin($hex), 'AES-128-ECB', $key ,OPENSSL_RAW_DATA);
	echo($ftp_server);
	echo('<BR>');

    $ciphertext = openssl_encrypt("lolipop.jp-7135244fd63eb4a7", 'AES-128-ECB', $key, OPENSSL_RAW_DATA);
	$hex=bin2hex($ciphertext);
	echo($hex);
	echo('<BR>');
	$ftp_user_name = openssl_decrypt(hex2bin($hex), 'AES-128-ECB', $key ,OPENSSL_RAW_DATA);
	echo($ftp_user_name);
	echo('<BR>');

	
    $ciphertext = openssl_encrypt("e-art.neko", 'AES-128-ECB', $key, OPENSSL_RAW_DATA);
	$hex=bin2hex($ciphertext);
	echo($hex);
	echo('<BR>');
	$ftp_user_pass = openssl_decrypt(hex2bin($hex), 'AES-128-ECB', $key ,OPENSSL_RAW_DATA);
	echo($ftp_user_pass);
	echo('<BR>');
	*/

	
	
echo(hash("sha256", htmlspecialchars('greenheaven6151', ENT_QUOTES,'UTF-8') ,FALSE));
	
?>


</body>
</html>