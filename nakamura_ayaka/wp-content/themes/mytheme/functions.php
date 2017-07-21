<?php


/**
 * アイキャッチ画像の機能を有効化します。
 */
add_theme_support( 'post-thumbnails' );

/**
 * ウィジェットエリアを定義します。
 */


//　「サイドバー上部」を作成
register_sidebar(array(

	'name' => __('サイドバー上部') ,//このサイドバーの名前
	'id' => 'primary-widget-area',//サイドバーID
	'description' => __( 'サイドバーに表示されるウィジェットエリアです。エリア全体がグレーの枠に囲まれます。' ),//サイドバーの説明
	'before_widget' => '<div id="%1$s" class="widget %2$s">',//ウィジェットの前のテキスト %1$sと%2$sの箇所はウィジェットごとに固有の値が与えられます
	'after_widget' => '</div>',//ウィジェットの後のテキスト
	'before_title' => '<h3 class="widget-title">',//タイトルの前のテキスト
	'after_title' => '</h3>'//タイトルの後のテキスト
	
));

//　「サイドバー下部」を作成
register_sidebar(array(

	'name' => __('サイドバー下部') ,
	'id' => 'secondary-widget-area',
	'description' => __( '枠や装飾をしていないので画像バナーを設置するのに最適です。' ),
	'before_widget' => '<div id="%1$s" class="widget %2$s">',
	'after_widget' => '</div>',
	'before_title' => '<h3 class="widget-title">',
	'after_title' => '</h3>'
	
));



//アイキャッチ画像の定義と切り抜き
add_action( 'after_setup_theme', 'baw_theme_setup' );
function baw_theme_setup() {
 add_image_size('pc_thumbnail', 150, 150 ,true );
 add_image_size('mobile_thumbnail', 80, 80 ,true );
}


function pagination($pages = '', $range = 1)
{
     $showitems = ($range * 2)+1;  
 
     global $paged;
     if(empty($paged)) $paged = 1;
 
     if($pages == '')
     {
         global $wp_query;
         $pages = $wp_query->max_num_pages;
         if(!$pages)
         {
             $pages = 1;
         }
     }   
 
     if(1 != $pages)
     {
         echo "<div class=\"pagination\"><div class=\"pagination-box\"><span class=\"page-of\">Page ".$paged." of ".$pages."</span>";
         if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<a href='".get_pagenum_link(1)."'>&laquo;</a>";
         if($paged > 1 && $showitems < $pages) echo "<a href='".get_pagenum_link($paged - 1)."'>&lsaquo;</a>";
 
         for ($i=1; $i <= $pages; $i++)
         {
             if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
             {
                 echo ($paged == $i)? "<span class=\"current\">".$i."</span>":"<a href='".get_pagenum_link($i)."' class=\"inactive\">".$i."</a>";
             }
         }
 
         if ($paged < $pages && $showitems < $pages) echo "<a href=\"".get_pagenum_link($paged + 1)."\">&rsaquo;</a>";
         if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo "<a href='".get_pagenum_link($pages)."'>&raquo;</a>";
         echo "</div></div>\n";
     }
}

//★管理画面のカスタマイズ★

// 管理バーの項目を非表示
function remove_admin_bar_menu( $wp_admin_bar ) {
 if (!current_user_can('level_10')) { //level10以下のユーザーの場合ウィジェットをunsetする	
 $wp_admin_bar->remove_menu( 'wp-logo' ); // WordPressシンボルマーク
 $wp_admin_bar->remove_menu('my-account'); // マイアカウント
 }
}
add_action( 'admin_bar_menu', 'remove_admin_bar_menu', 70 );

// 管理バーのヘルプメニューを非表示にする
function my_admin_head(){
 if (!current_user_can('level_10')) { //level10以下のユーザーの場合ウィジェットをunsetする	
 echo '<style type="text/css">#contextual-help-link-wrap{display:none;}</style>';
 }
}
add_action('admin_head', 'my_admin_head');

// 管理バーにログアウトを追加
function add_new_item_in_admin_bar() {
 global $wp_admin_bar;
 $wp_admin_bar->add_menu(array(
 'id' => 'new_item_in_admin_bar',
 'title' => __('ログアウト'),
 'href' => wp_logout_url()
 ));
 }
add_action('wp_before_admin_bar_render', 'add_new_item_in_admin_bar');

// ダッシュボードウィジェット非表示
function example_remove_dashboard_widgets() {
 if (!current_user_can('level_10')) { //level10以下のユーザーの場合ウィジェットをunsetする
 global $wp_meta_boxes;
 unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']); // 現在の状況
 unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']); // 最近のコメント
 unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']); // 被リンク
 unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']); // プラグイン
 unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']); // クイック投稿
 unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_recent_drafts']); // 最近の下書き
 unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']); // WordPressブログ
 unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']); // WordPressフォーラム
 }
 }
add_action('wp_dashboard_setup', 'example_remove_dashboard_widgets');


function remove_menus () {
 if (!current_user_can('level_10')) { //level10以下のユーザーの場合メニューをunsetする
 remove_menu_page('wpcf7'); //Contact Form 7
 global $menu;
 unset($menu[2]); // ダッシュボード
 unset($menu[4]); // メニューの線1
 unset($menu[5]); // 投稿
 //unset($menu[10]); // メディア
 unset($menu[15]); // リンク
 unset($menu[20]); // ページ
 unset($menu[25]); // コメント
 unset($menu[59]); // メニューの線2
 unset($menu[60]); // テーマ
 unset($menu[65]); // プラグイン
 unset($menu[70]); // プロフィール
 unset($menu[75]); // ツール
 unset($menu[80]); // 設定
 unset($menu[90]); // メニューの線3
 }
 }
add_action('admin_menu', 'remove_menus');


/**
 * カスタム投稿タイプ「新着情報」、カスタムタクソノミー(分類)「情報タイプ」を定義します。
 */

/*
//関数　add_custompost_type　を定義　(関数名は任意の名前でOK)
function add_custompost_type() {

	$args = array(
		'label' => '新着情報',//管理画面の左メニューに表示される名前
		'labels' => array(
			'singular_name' => '新着情報',//この投稿タイプの名前
			'add_new' => '新規追加',//デフォルトの「add new」の代わりに表示するテキスト(以下省略)
			'add_new_item' => '新着情報を追加',//add new itemテキスト
			'edit_item' => '新着情報を編集',//edit itemテキスト
			'new_item' => '新しい新着情報',//new itemテキスト
			'view_item' => '新着情報を表示',//view itemテキスト
			'search_items' => '新着情報を検索',//search itemsテキスト
			'not_found' => '新着情報は見つかりませんでした',//not foundテキスト
			'not_found_in_trash' => 'ゴミ箱に新着情報はありません。',//not found in trashテキスト
		),
		'description' => '新着情報を公開する時に使うカスタム投稿タイプです。',//投稿タイプの簡潔な説明
		'public' => true,//管理画面から投稿できるようにする(初期値がfalseなので注意)
		'hierarchical' => false,//階層をもつか
		'supports' => array('title','editor','author','thumbnail','excerpt','comments','custom-fields'),//この投稿で利用する機能
		'has_archive' => true,//投稿アーカイブを利用する(初期値がfalseなので注意)
		'menu_position' => 5//管理画面の左メニューにおける表示位置　5-投稿の下、10-メディアの下、20-ページの下
	); 
	register_post_type('news', $args);//カスタム投稿タイプ「news」を登録


	$args = array(
		'label' => '情報タイプ',//管理画面の左メニューに表示される名前
		'labels' => array(
			'singular_name' => '情報タイプ',//このカスタム分類の名前
			'search_items' => '情報タイプを検索',//デフォルトの「search item」の代わりに表示するテキスト(以下省略)
			'popular_items' => 'よく使われている情報タイプ',//popular itemテキスト
			'all_items' => 'すべての情報タイプ',//all itemsテキスト
			'parent_item' => '親情報タイプ',//parent itemテキスト
			'edit_item' => '情報タイプの編集',//edit itemテキスト
			'update_item' => '更新',//update itemテキスト
			'add_new_item' => '新規情報タイプを追加',//add new itemテキスト
			'new_item_name' => '新しい情報タイプ',//new item nameテキスト
		),
		'public' => true,//管理画面から作成できるようにする
		'hierarchical' => true,//階層をもつか
	);
	register_taxonomy('newstype', 'news', $args);//カスタム分類「newstype」を「news」内に登録

	flush_rewrite_rules();//パーマリンク設定を再設定(エラー回避のため)
}

add_action('init', 'add_custompost_type');//定義した「add_custompost_type」を実行

*/



?>