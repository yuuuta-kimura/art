<!DOCTYPE html>
<html>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# article: http://ogp.me/ns/article#">
<title>eART for artist</title>
<meta name="keywords" content="">
<meta name="discription" content="">

<link href="./bootstrap.css" rel="stylesheet" type="text/css">
<link href="./{$css_file}" rel="stylesheet" type="text/css">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>



{include file=$head_tpl}


</head>

<body>


<header>
 {include file=$header_tpl}
</header>

<div id="temp_body">
	{include file=$body_tpl params=$params}
</div>

<footer>
    {include file=$footer_tpl}
</footer>


</body>
</html>
