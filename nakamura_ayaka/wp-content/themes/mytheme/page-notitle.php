<?php
/*
Template Name: タイトル表示なし
*/
?>

<?php get_header(); ?>

<div id="main">

	<div id="bread-nav">e-ART><?php if ( function_exists( 'bcn_display' ) ) { bcn_display(); }//パンくずリストを表示 ?></div>

	<div id="content">

        <div id="column-left">
			
			<?php get_sidebar(); ?>
        
        </div>
			
		<div id="column-right">

			<?php if ( have_posts() ) : // ループ開始　投稿があるなら ?>
			
			<?php while ( have_posts() ) : the_post();//繰り返し処理開始 ?>
			
				<div class="page-entry entry">
			
					<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
											
						<div class="page-content"><?php the_content(); ?></div>
						
					</div>
										
				</div>
							
			<?php endwhile; // 繰り返し終了 ?>
											
			<?php else : //投稿が無い場合は ?>
			
				<h1>投稿が見つかりません</h1>
			
				<p><a href="<?php bloginfo( 'url' ); ?>">トップページに戻る</a></p>
			
			<?php endif; //ループ終了 ?>
			            
        </div>
		
        <p id="totop"><a href="#content">↑トップへ</a></p>
        
	</div>

</div>

<?php get_footer();