<?php get_header(); ?>

<div id="main">

	<div id="bread-nav"><?php if ( function_exists( 'bcn_display' ) ) { bcn_display(); }//パンくずリストを表示 ?></div>
	
	<div id="content">
	
		<div id="column-left">
		
			<?php get_sidebar(); ?>
			
		</div>
		
		<div id="column-right">
		
			<?php if ( have_posts() ) : // ループ開始　投稿があるなら ?>
			
				<?php while ( have_posts() ) : the_post();//繰り返し処理開始 ?>
				
					<div class="entry archive-entry clearfix">
					
						<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
						
							<div class="archive-meta clearfix">
							
								<div class="entry-meta news-meta">
								
									<h2 class="entry-title news-title"><?php the_title(); ?></h2>
									
									<p class="entry-cat"><?php the_time('Y.m.j') ?>　｜　<?php if (has_term('','newstype')) { $terms = get_the_terms($post->ID, 'newstype'); foreach ($terms as $term) { echo ' - '; echo $term->name; } } ?></p>
									
								</div>
								
							</div>
							
							<div class="post-content">
							
								<?php the_content(); ?>
								
							</div>
							
						</div>
						
					</div>
					
				<?php endwhile; // 繰り返し終了 ?>
				
				<div id="post-link" class="clearfix">
				
					<p id="post-link-next"><?php next_posts_link('次のページ' ); //次のページへのリンクを表示 ?></p>
					
					<p id="post-link-prev"><?php previous_posts_link('前のページ' ); //前のページへのリンクを表示 ?></p>
					
				</div>
				
			<?php else : //投稿が無い場合は ?>
			
				<h1>投稿が見つかりません</h1>
				
				<p><a href="<?php bloginfo( 'url' ); ?>">トップページに戻る</a></p>
				
			<?php endif; //ループ終了 ?>
			
		</div>		
		
		<p id="totop"><a href="#content">↑トップへ</a></p>
		
	</div>
	
</div>

<?php get_footer();