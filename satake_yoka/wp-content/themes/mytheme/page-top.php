<?php
/*
Template Name: トップページ
*/
ini_set("display_errors",1);
error_reporting(E_ALL);


require('dbconnect.php');
require('pdosql.php');


?>

<?php get_header(); ?>
<div id="pankuzu" style="margin-left:35px;">e-ART><?php if ( function_exists( 'bcn_display' ) ) { bcn_display(); }//パンくずリストを表示 ?></div>


<div class="container">


<!-- トップ画像 -->
<div class="row" style="text-align: center; background-color:#FFFFFF;">

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<img src="<?php bloginfo( 'template_directory' );?>/img/penname.png" width="60%">
	</div>

</div>


<!-- プロフィール -->
<div class="row">
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div id="top_prof">
		<div id="top_prof_img">
			<img src="<?php bloginfo( 'template_directory' );?>/img/prof.png">
		</div>
		<div id="top_prof_text">
			<div id="top_prof_name">佐竹 燿華 | satake yoka</div>
			<div id="top_prof_detail">
				<p>
				ネット上で教室を開くなど、新しい道を切り開く書道家<br>
				第49回国際書法芸術「王羲之賞」受賞<br>
				海外交流の舞台にも積極的に参加し、台湾やベトナムなどで書道パフォーマンスを行っている<br>
				</p>
			</div>
		</div>
	</div>
</div>
</div>


<div class="row" style="margin-top:50px;">
	<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
		<div id="top_detail">
	<!-- Event -->

		<div id="top_detail_title">
		<!--<span class="glyphicon glyphicon-globe"></span>-->
		Event & News 
		</div>
		<a href="<?php bloginfo( 'template_directory' );?>/eventnewslist" style="decoration:none; color: #000000;">
		<div id="more">
		more
		</div>
		</a>		

		<?php $args = array(
            'numberposts' => 2,       //表示（取得）する記事の数
            'post_type' => 'event'    //投稿タイプの指定
        );
        $customPosts = get_posts($args);
        if($customPosts) : foreach($customPosts as $post) : setup_postdata( $post ); ?>
                <div style="clear:both; float:left; width:130px; margin:0 0 20px 20px;"><a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('mobile_thumbnail'); ?></a></div>
                
				<div class  ="visible-xs visible-sm">
                <div style="float:left; width:50%; font-size:10px;">
                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></div>
				</div>

				<div class  ="visible-md">
                <div style="float:left; width:60%; font-size:14px;">
                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></div>
				</div>                
			
			
				<div class  ="visible-lg">
                <div style="float:left; width:70%; font-size:14px;">
                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></div>
				</div>                
                
        <?php endforeach; ?>
        <?php else : //記事が無い場合 ?>
            <li><p>記事はまだありません。</p></li>
        <?php endif;
        wp_reset_postdata(); //クエリのリセット ?>

		</div>
	</div>
	
	
	<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
		<!-- Blog -->		
		<div id="top_detail">
		<div id="top_detail_title">
			<!--<span class="glyphicon glyphicon-pencil"></span>-->
			Blog 
		</div>

		<a href="<?php bloginfo( 'template_directory' );?>/bloglist" style="decoration:none; color: #000000;">
		<div id="more">
		more
		</div>
		</a>		


		<?php $args = array(
			'numberposts' => 5,                //表示（取得）する記事の数
			'post_type' => 'myblog'    //投稿タイプの指定
		);
		$customPosts = get_posts($args);
		if($customPosts) : foreach($customPosts as $post) : setup_postdata( $post ); ?>
	
			<div class  ="visible-xs visible-sm">
				<div style="clear:both; margin:0 0 8px 20px; font-size:10px;">
				<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
				</div>
			</div>

			<div class  ="visible-md visible-lg">
				<div style="clear:both; margin:0 0 20px 20px; font-size:14px;">
				<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
				</div>
			</div>

		<?php endforeach; ?>
		<?php else : //記事が無い場合 ?>
			<li><p>記事はまだありません。</p></li>
		<?php endif;
		wp_reset_postdata(); //クエリのリセット ?>
		
		</div>
	</div>	
</div>


<!-- Works & Store -->		
<div class="row"><div id="top_works">
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

    <div id="top_detail">
		<!--<span class="glyphicon glyphicon-picture"></span>-->
		<div id="top_detail_title">
			Gallery e-ART
		</div>
		<?php

		//WEBAPIでデータ呼び出し

		$response = file_get_contents('http://e-art.tokyo/user/getgallery.php?artist_id=2&limit=6&apikey=u5cht7ph0tam7hg1y6j18a1f08z98l0azd63znkn61rbu38gfmh01e3n56twlhtclsv360dohj2bgrfpoahqd0nqbq5ji5zedic9auqbuuzpjzrbjae8btcxgindjny7qhgnfuqytiwx177vckapumit0mh643jwlgu3m2cvm3n89jzj8ev57xe4zt28kse7et9pb1c0f1269rkp205u7vhp5u1snlm5v6e03pr971pv4qzhjhndmgjtjtofefcg');
		$result = json_decode($response,true);

		//echo $result['works'][0]['title'];
		//echo $result['result'];

		$htmllist=NULL;
		$ROWNUM = 3; //折り返しの画像数
		$icount=1;

		if($result['result']=='OK'){	
			foreach($result['works'] as $data)
			{
				$htmllist=NULL;

				if(($icount%$ROWNUM)==1){
					print('<div  class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><div id="block_works_img">');			
				}		
				$htmllist=sprintf('<div id="works_img"><a href="%s" data-lity><img src="%s" class="works_img"></a></div>',$data['main_pic'],$data['main_pic']);

				print($htmllist);

				if(($icount%$ROWNUM)==0){
					print('</div></div>');			
				}		

				$icount=$icount+1;

			}
			if((($icount-1)%$ROWNUM)!=0){
				print('</div>');			
			}		
		}
		?>
    </div>

	<div  class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:20px; text-align:center;">
	<a href="http://e-art.tokyo/user/gallery.php?artist_id=2" target="_blank">
		<div id="motto_miru">もっと見る</div>
		<div id="to_gallery" class="center-block text-center">
		Gallery e-ART へ
		</div></a>
	</div>


</div></div>
</div>

</div> <!-- container -->

<?php get_footer(); ?>




<script>        
  var mySwiper = new Swiper ('.swiper-container', {
    // Optional parameters
    direction: 'horizontal',
    loop: true,
	autoplay: 3000,
	speed: 1000,
    //autoplayStopOnLast: true,
    // If we need pagination
    pagination: '.swiper-pagination',
	paginationClickable: true,
   })        
</script>