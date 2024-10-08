<?php
/**
 * @package WP Scraper
 * @version 5.8.1  */
/*
Plugin Name: WP Scraper
Plugin URI:  http://www.wpscraper.com
Description: This plugin allows you to copy content from websites directly to your WordPress posts.
Version: 5.8.1
Author: Robert Macchi
*/

define( 'WPSF_DIR', untrailingslashit( dirname( __FILE__ ) ) );
define ( 'WPSF_CURRENT_VERSION', '5.8.1' );


if ( is_admin() ) {
    add_action( 'admin_menu', 'WpScraper::wp_scraper_menu');
	add_action( 'admin_menu', 'wpsf_edit_admin_menus' );
}

add_action( 'admin_enqueue_scripts', 'wpsf_admin_enqueue_scripts' );

function wpsf_edit_admin_menus() {
	global $submenu;

	if ( current_user_can( 'activate_plugins' ) ) {
		$submenu['wp-scraper'][0][0] = 'Single Scrape';
	}
}


class WpScraper {

    private static $templateVariables;

    // post url
    public static $url;

    // post html
    public static $html;

    // post images
    public static $images;


/**
 * Register WP Scraper Menu
 */

 public static function wp_scraper_menu($action = '') {
        // Main menu block

		add_menu_page( 'WP Scraper Single Selection',
            'WP Scraper',
            'activate_plugins', 'wp-scraper',
            'WpScraper::wp_scraper_page', 'dashicons-layout', '11.952144500145214' );

		$wp_scraper_subpage3 = add_submenu_page(
        'wp-scraper',
        'WP Scraper Pro Versions',
        'Pro Versions',
        'activate_plugins',
		'wp-scraper-pro-versions',
        'WpScraper::wp_scraper_pro_versions');

		$wp_scraper_subpage2 = add_submenu_page(
        'wp-scraper',
        'WP Scraper Help',
        'Help',
        'activate_plugins',
		'wp-scraper-help-menu',
        'wp_scraper_help_page');

        if (isset($_GET['action']) && !empty($_GET['action']) && isset($_GET['page']) && $_GET['page'] == 'wp-scraper') {

		if ((!isset($_POST['_wpnonce']) || empty($_POST['_wpnonce'])) && check_admin_referer('wp_scraper_url')) {

        $action = $_GET['action'];

		} elseif (isset($_POST['_wpnonce']) && !empty($_POST['_wpnonce']) && check_ajax_referer('wpsf-save-wpscraper', '_wpnonce')) {

        $action = $_GET['action'];

		} else {

        $action = 'add';

		}
		} else {

		$action = 'add';

		}



		$path = 'wp-scraper'.($action?'&action='.$action:'');

		$the_page = isset($_GET['page'])?$_GET['page']:null;

		if($the_page != 'wp-scraper') return;

		$function = 'wp_scraper_'.$action.'_content';
		WpScraper::$templateVariables = WpScraper::$function();


    }

	public static function wp_scraper_pro_versions() {
		echo '<div class="wrap wpsf-form">';
			echo '<div style="background-image: url('.esc_url(plugins_url( "images/Cube-m.jpg", __FILE__ )).');max-width:100%;height:100px;background-size:cover;background-position:center center;);">
      <h1 style="text-align:center;font-weight:bold;color: white; padding-top:30px;">WP Scraper Pro Versions</h1>
      </div>
      <style>p {font-size:16px;}</style>
      <p style="font-weight:bold;text-align:center;font-size:20px;">Are you looking for more features?</p>
      <div style="background-color:#fff; overflow:hidden;padding:10px;border:1px solid #ccc;">

      <div style="margin-top:-16px;margin-bottom:20px;width:48%; margin-right: 4%; font-size:16px;float:left;">
					<div style="padding: 0px;">
						<h2 style="text-align:center;"><strong><a style="color:black; text-decoration:none;font-size:30px;" href="http://www.wpscraper.com/scraper-pro-features/">WP Scraper Pro</a></strong></h2>
            <p>With WP Scraper Pro you can scrape 100’s of pages at a time and import new content on a set schedule.</p>
            <br>
            <a href="http://www.wpscraper.com/scraper-pro-features/">
            <img style="max-width:100%;" src="'.esc_url(plugins_url( "images/WP-Scraper-Pro-Ad.jpg", __FILE__ )).'" alt="WP Scraper Pro Plugin" /></a>
            </div></div>
            <div style="margin-top:-16px;margin-bottom:20px;width:48%;float:left;font-size:16px;">
    					<div style="padding: 0px;">
                <h2 style="text-align:center;"><strong><a style="color:black; text-decoration:none;font-size:30px;" href="http://www.wpscraper.com/live-scraper-features/">WP Live Scraper</a></strong></h2>
                <p>With WP Live Scraper you can automatically update reviews, events, prices, and so much more.</p>
                <br>
                <a href="http://www.wpscraper.com/live-scraper-features/">
                <img style="max-width:100%;" src="'.esc_url(plugins_url( "images/Live-Scrape-Ad.jpg", __FILE__ )).'" alt="WP Live Scraper Plugin" /></a>
                </div></div>
            <div style="margin-top:-16px;margin-bottom:20px;width:48%; margin-right: 4%; font-size:16px;float:left;">
      					<div style="padding: 0px;">
<p><a href="http://www.wpscraper.com/scraper-pro-features/">WP Scraper Pro</a> can scrape 100’s of pages at a time with its multiple scrape feature and makes it simple with an easy to use visual interface on&nbsp;your WordPress site.</p>
<p><strong>URL Selection</strong><br>We have included a URL crawler tool to help find the content you want. The URL selection tool will crawl a URL and compile a list of pages that match your request.</p>
<p><strong>Content Selection</strong><br>You may select as much content as you wish by simply highlighting and selecting or deselecting the blocks of content &nbsp;to import.</p>
<p><strong>Automation</strong><br>WP Scraper Pro will automate Titles, Tags, Categories and Images recursively from each page based on a preselection or your own.</p>
<p><strong>Auto Post New Content</strong><br>Auto Scrape will automatically pull any new posts into your site on a set schedule.&nbsp; Daily, Every Two Days, Every Three Days, Weekly, Every Two Weeks, Monthly</p>
<p><strong>Options</strong><br>Include Images, Remove Links, HTML Elements, Add source link to the content and many more.</p>
<a href="http://www.wpscraper.com/scraper-pro-features/">Learn More About WP Scraper Pro Here</a>
</div>
				</div>
            <div style="margin-top:-16px;margin-bottom:20px;width:48%;float:left;font-size:16px;">
    					<div style="padding: 0px;">
<p><a href="http://www.wpscraper.com/live-scraper-features/">WP Live Scraper</a> provides a shortcode that can be used in any post or page and will automatically refresh scraped content with a recurring cron schedule. This can be used for events, ratings, reviews, scores, prices and so much more!</p>
<p><strong>Shortcodes</strong><br>Shortcodes will be stored with a title and ID in an easy to read table where you will be able to edit or delete.</p>
<p><strong>Content Selection</strong><br>You may select as much content as you wish by simply highlighting and selecting or deselecting the blocks of content &nbsp;to import.</p>
<p><strong>Refresh Schedule</strong><br>Hourly, Twice Daily, Daily, Every Two Days, Every Three Days, Weekly, Every Two Weeks, Monthly</p>
<p><strong>Options</strong><br>Include Images, Remove Links, HTML Elements, Add source link to the content and many more.</p>
<a href="http://www.wpscraper.com/live-scraper-features/">Learn More About WP Live Scraper Here</a>
					</div>
				</div></div></div>
				';

	}


	public static function wp_scraper_page($vars = array(), $page='wp-scraper', $template=null) {
		add_thickbox();
		require_once('includes/meta-boxes.php');
		//add_meta_box( 'submitdiv', __( 'Publish' ), 'post_submit_meta_box', 'toplevel_page_wp-scraper', 'side', 'core' );
		add_meta_box( 'categorydiv', __( 'Categories' ), 'wpsf_post_categories_meta_box', 'toplevel_page_wp-scraper', 'side', 'core' );
		add_meta_box( 'tagsdiv-post_tag', __( 'Tags' ), 'wpsf_post_tags_meta_box', 'toplevel_page_wp-scraper', 'side', 'core' );
		add_meta_box( 'postimagediv', __( 'Featured Image' ), 'wpsf_post_thumbnail_meta_box', 'toplevel_page_wp-scraper', 'side', 'core' );
        if (!$template) {
          if (isset($_GET['action']) && !empty($_GET['action']) && isset($_GET['amp;_wpnonce']) && !empty($_GET['amp;_wpnonce']) && check_ajax_referer('amp;_wpnonce')) {
            $template = $_GET['action'];
          } elseif (isset($_GET['action']) && !empty($_GET['action']) && check_admin_referer('wp_scraper_url')) {
            $template = $_GET['action'];
          } else {
            $template = 'add';
          }
        }


        if (!$vars || !count($vars)) {
            $vars = WpScraper::$templateVariables;
        }
        if (isset($vars)) {
            extract($vars);
        }
		if ($template == 'add') {
			$post_type_options = '';
			$args = array(
			   'public'   => true,
			);
			foreach (get_post_types($args, 'names') as $post_type) {
    			if ($post_type == 'attachment') continue;
        			$selected = ($post_type == 'post') ? 'selected="selected"' : '';
    				$post_type_options .= '<option value="' . esc_attr($post_type) . '" ' . $selected . '>' . esc_html(ucfirst($post_type)) . '</option>';
}
			echo '<div id="post-body" class="wrap wpsf-form">';
	if(isset($_GET['pid'])) {
		$pid = $_GET['pid'];
	$view = get_permalink($pid);
	$edit = get_edit_post_link($pid);
    echo '<div id="message" class="updated notice is-dismissible">
        <p>
		Post created
		<a style="padding-left: 5px;" target="_blank" href="'.esc_url($view).'">View Post</a>
		<a style="padding-left: 5px;" target="_blank" class="post-edit-link" href="'.esc_url($edit).'">Edit Post</a>
		</p>
    </div>';
	} else if(isset($_GET['amp;pid'])){
    $pid = $_GET['amp;pid'];
	  $view = get_permalink($pid);
	  $edit = get_edit_post_link($pid);
    echo '<div id="message" class="updated notice is-dismissible">
        <p>
		Post created
		<a style="padding-left: 5px;" target="_blank" href="'.esc_url($view).'">View Post</a>
		<a style="padding-left: 5px;" target="_blank" class="post-edit-link" href="'.esc_url($edit).'">Edit Post</a>
		</p>
    </div>';
	}
    echo '<h2>Add New Scraped Post</h2>

    <form method="post" action="'.esc_url(wp_scraper_url('wp-scraper', 'add')).'" id="wpsf-add-post-form">
        <input type="hidden" value="'.esc_url(wp_scraper_url('wp-scraper', 'extract')).'" id="wpsf-content-extractor-url" />
		<input type="hidden" value="'.esc_url(wp_scraper_url('wp-scraper', 'downloader')).'" id="wpsf-downloader-url" />';
        wp_nonce_field( 'wpsf-save-wpscraper');
        echo '<div id="wpsf-add-source-form-container" class="metabox-holder">
			<div id="wpsf-extractor-box">
                <label for="wpsf-url"><b>Url to Scrape:</b></label>
				<div class="field wpsf-field-container">
					<input id="wpsf-url" class="regular-text ltr" name="url"  style="width: 100%;" />
				</div>
            </div>
			<div id="add_wpsf_post_container">
            <div id="postbox-container-1" class="postbox-container">
			<div id="titlediv" class="wpsf-field-container">
                <input type="text" name="title" value="" id="title" spellcheck="true" placeholder="Enter post title" />
				<a id="choose_title_content" title="Click to select content you want to use for the title. Then click the button below to add it to the title field." href="#TB_inline?width=600&height=550&inlineId=content-extractor" class="thickbox button post-select-btn">Choose Title</a>
            </div>

            <div id="wpsf-data" class="wpsf-meta-box-container meta-box-sortables">
                <div class="postbox">
                    <h3 class="hndle"><span>Post Content</span></h3>

                    <div class="inside">
                        <div class="field wpsf-field-container"><a id="choose_body_content" title="Click to select content you want to use for the post content. Then click the button below to add it to the post content field." href="#TB_inline?width=600&height=550&inlineId=content-extractor" class="thickbox button block-select-btn" style="z-index: 19; position: relative;">Choose Post Content</a>';
                        wp_editor( '', 'wpsf-html' );
                            echo '<input type="hidden" id="wpsf-images" name="images" />
                        </div>
                    </div>
                </div>
            </div>
			<div id="custom-post-fields"></div>
			</div>
			<div id="postbox-container-2" class="postbox-container">
			<div id="submitdiv" class="postbox">
				<div class="handlediv" title="Click to toggle">
				<br>
				</div>
				<h3 class="hndle ui-sortable-handle">
				<span>Publish</span>
				</h3>
				<div class="inside">
				<div id="submitpost" class="submitbox">
				<div id="minor-publishing">
				<div id="misc-publishing-actions">
				<div class="misc-pub-section misc-pub-post-type">
				<label for="post_type">Post Type:</label>
				<span id="post-type-display">Post</span>
				<a class="edit-post-type hide-if-no-js" href="#post_type" style="display: inline;">
				<span aria-hidden="true">Edit</span>
				<span class="screen-reader-text">Edit type</span>
				</a>
				<div id="post-type-select" class="hide-if-js" style="display: none;">
				<input id="hidden_post_type" type="hidden" value="post" name="hidden_post_type">';

				$allowed_html = array(
								    'option' => array(
								        'value' => array(),
								        'selected' => array(),
								    ),
								);

				echo '<select id="post_type" name="post_type">'.wp_kses($post_type_options, $allowed_html).'</select>';
				echo'<a class="save-post-type hide-if-no-js button" href="#post_type">OK</a>
				<a class="cancel-post-type hide-if-no-js button-cancel" href="#post_type">Cancel</a>
				</div>
				</div>
				<div class="misc-pub-section misc-pub-post-status">
				<label for="post_status">Status:</label>
				<span id="post-status-display">Published</span>
				<a class="edit-post-status hide-if-no-js" href="#post_status" style="display: inline;">
				<span aria-hidden="true">Edit</span>
				<span class="screen-reader-text">Edit status</span>
				</a>
				<div id="post-status-select" class="hide-if-js" style="display: none;">
				<input id="hidden_post_status" type="hidden" value="publish" name="hidden_post_status">
				<select id="post_status" name="post_status">
				<option value="publish" selected="selected">Published</option>
				<option value="pending">Pending Review</option>
				<option value="draft" selected="selected">Draft</option>
				</select>
				<a class="save-post-status hide-if-no-js button" href="#post_status">OK</a>
				<a class="cancel-post-status hide-if-no-js button-cancel" href="#post_status">Cancel</a>
				</div>
				</div>
				<div class="clear"></div>
				</div>
				</div>
				</div>
				</div>
				<div id="major-publishing-actions">
					<div class="save-wpscraper-form">
						<input type="submit" class="button-primary" name="save" value="Save Post" />
					</div>
				</div>
			</div>
			<div id="extract-options" class="postbox">
				<div class="handlediv" title="Click to toggle">
				<br>
				</div>
				<h3 class="hndle ui-sortable-handle">
				<span>Extract Options</span>
				</h3>
				<div class="inside">
				<label class="extract-opt" for="js" style="display: inline-block"><input id="js" type="checkbox" name="js" value="1">Load JavaScript</label><p class="description">Some content may need javascript enabled to display correctly. Check this box to enable javascript while selecting content.</p><br>
				<label class="extract-opt" for="down" style="display: inline-block"><input id="down" type="checkbox" name="down" value="1">Load Restricted Image Content</label><p class="description">Some images will not load due to cross domain conflicts. Use this feature to load these restricted images. However, it doesn\'t work with all server configurations. Use with caution.</p>
				</div>
			</div>
			<div id="submitdiv" class="postbox">
				<div class="handlediv" title="Click to toggle">
				<br>
				</div>
				<h3 class="hndle ui-sortable-handle">
				<span>Post Options</span>
				</h3>
				<div class="inside">
				<label class="misc-pub-section" for="simpletext" style="display: inline-block"><input id="simpletext" type="checkbox" name="simpletext" value="remove" checked="checked">Only Text and Images</label><br>
				<label class="misc-pub-section" for="incvideos" style="display: inline-block"><input id="incvideos" type="checkbox" name="incvideos" value="add" checked="checked">Include Videos</label><br>
				<label class="misc-pub-section" for="remove_links" style="display: inline-block"><input id="remove_links" type="checkbox" name="remove_links" value="remove">Remove Links</label><br>
				<label class="misc-pub-section" for="add_copy" style="display: inline-block"><input id="add_copy" type="checkbox" name="add_copy" value="add" checked="checked">Add source link to the content</label>
				</div>
			</div>';
			do_meta_boxes('toplevel_page_wp-scraper', 'side', '');
			echo '</div>
        </div>
        </div>
    </form>
</div>

<div id="content-extractor" style="display:none;">
	<a id="wpsf-select-html" class="button-primary">Add selected content to my post</a>
    <iframe id="content-extractor-iframe" name="wpsf-extractor"></iframe>
</div>';
		} elseif ($template == 'extract') {
			if ($page) :
        $tags = wp_kses_allowed_html('post');
        $tags['style'] = array('media' => 1, 'src' => 1, 'type' => 1, 'aria-controls' => 1, 'aria-current' => 1, 'aria-describedby' => 1, 'aria-details' => 1, 'aria-expanded' => 1, 'aria-hidden' => 1, 'aria-label' => 1, 'aria-labelledby' => 1, 'aria-live' => 1, 'class' => 1, 'data-*' => 1, 'dir' => 1, 'hidden' => 1, 'id' => 1, 'lang' => 1, 'style' => 1, 'title' => 1, 'role' => 1, 'xml:lang' => 1);
        $tags['script'] = array('src' => 1, 'type' => 1, 'aria-controls' => 1, 'aria-current' => 1, 'aria-describedby' => 1, 'aria-details' => 1, 'aria-expanded' => 1, 'aria-hidden' => 1, 'aria-label' => 1, 'aria-labelledby' => 1, 'aria-live' => 1, 'class' => 1, 'data-*' => 1, 'dir' => 1, 'hidden' => 1, 'id' => 1, 'lang' => 1, 'style' => 1, 'title' => 1, 'role' => 1, 'xml:lang' => 1);
        $tags['body'] = array('aria-controls' => 1, 'aria-current' => 1, 'aria-describedby' => 1, 'aria-details' => 1, 'aria-expanded' => 1, 'aria-hidden' => 1, 'aria-label' => 1, 'aria-labelledby' => 1, 'aria-live' => 1, 'class' => 1, 'data-*' => 1, 'dir' => 1, 'hidden' => 1, 'id' => 1, 'lang' => 1, 'style' => 1, 'title' => 1, 'role' => 1, 'xml:lang' => 1);
        $tags['noscript'] = array('aria-controls' => 1, 'aria-current' => 1, 'aria-describedby' => 1, 'aria-details' => 1, 'aria-expanded' => 1, 'aria-hidden' => 1, 'aria-label' => 1, 'aria-labelledby' => 1, 'aria-live' => 1, 'class' => 1, 'data-*' => 1, 'dir' => 1, 'hidden' => 1, 'id' => 1, 'lang' => 1, 'style' => 1, 'title' => 1, 'role' => 1, 'xml:lang' => 1);
        $tags['link'] = array('aria-controls' => 1, 'aria-current' => 1, 'aria-describedby' => 1, 'aria-details' => 1, 'aria-expanded' => 1, 'aria-hidden' => 1, 'aria-label' => 1, 'aria-labelledby' => 1, 'aria-live' => 1, 'class' => 1, 'data-*' => 1, 'dir' => 1, 'hidden' => 1, 'href' => 1, 'id' => 1, 'lang' => 1, 'rel' => 1, 'sizes' => 1, 'style' => 1, 'title' => 1, 'type' => 1, 'role' => 1, 'xml:lang' => 1);
        $tags['html'] = array('aria-controls' => 1, 'aria-current' => 1, 'aria-describedby' => 1, 'aria-details' => 1, 'aria-expanded' => 1, 'aria-hidden' => 1, 'aria-label' => 1, 'aria-labelledby' => 1, 'aria-live' => 1, 'class' => 1, 'data-*' => 1, 'dir' => 1, 'hidden' => 1, 'id' => 1, 'lang' => 1, 'prefix' => 1, 'style' => 1, 'title' => 1, 'role' => 1, 'xml:lang' => 1);
        $tags['head'] = array('aria-controls' => 1, 'aria-current' => 1, 'aria-describedby' => 1, 'aria-details' => 1, 'aria-expanded' => 1, 'aria-hidden' => 1, 'aria-label' => 1, 'aria-labelledby' => 1, 'aria-live' => 1, 'class' => 1, 'data-*' => 1, 'dir' => 1, 'hidden' => 1, 'id' => 1, 'lang' => 1, 'prefix' => 1, 'style' => 1, 'title' => 1, 'role' => 1, 'xml:lang' => 1);
        $tags['meta'] = array('aria-controls' => 1, 'aria-current' => 1, 'aria-describedby' => 1, 'aria-details' => 1, 'aria-expanded' => 1, 'aria-hidden' => 1, 'aria-label' => 1, 'aria-labelledby' => 1, 'aria-live' => 1, 'class' => 1, 'content' => 1, 'data-*' => 1, 'dir' => 1, 'hidden' => 1, 'http-equiv' => 1, 'id' => 1, 'lang' => 1, 'name' => 1, 'prefix' => 1, 'property' => 1, 'style' => 1, 'title' => 1, 'role' => 1, 'xml:lang' => 1);
      //  print('<pre>'.print_r($tags,true).'</pre>');
    			echo '<!DOCTYPE html>'.wp_kses($page, $tags);
			else:
		    	echo '<p>Error loading page</p>';
			endif;
		} elseif ($template == 'auto') {
			if ($page) :
    			echo wp_kses_post($page);
			else:
		    	echo '<p>Error loading page</p>';
			endif;
		}

        //include(WPSF_DIR.'/templates/'.$template.'.phtml');
    }

  public static function wp_scraper_add_content(){
    if (isset($_POST) && !empty($_POST) && check_ajax_referer('wpsf-save-wpscraper', '_wpnonce')) {
        $data = $_POST;
        if (isset($data['_wpnonce'])) unset($data['_wpnonce']);
        if (isset($data['_wp_http_referer'])) unset($data['_wp_http_referer']);

		if(isset($data['limit'])) {
			$limit = $data['limit'];
			$limited = true;
		} else $limited = false;

		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            $ajaxRequest = true;
        } else {
            $ajaxRequest = false;
        }

        if (!empty($data) && $ajaxRequest) {
            check_admin_referer( 'wpsf-save-wpscraper' );

				if (isset($data['url']) && $data['url']) {
					WpScraper::$url = $data['url'];
				}

				if (isset($data['wpsf-html']) && $data['wpsf-html']) {
					WpScraper::$html = stripslashes($data['wpsf-html']);
				}

				if (isset($data['images']) && $data['images']) {
					WpScraper::$images = $data['images'];
				}
				$tags = array();

				if(isset($data['simpletext']) && $data['simpletext'] == 'remove') {
						$tags = array
								(
									'br' => array(),
									'b' => array(),
									'em' => array(),
									'strong' => array(),
									'mark' => array(),
									'i' => array(),
									'u' => array(),
									'col' => array
										(
											'span' => array(),
										),
									'colgroup' => array
										(
											'span' => array(),
										),
									'div' => array(),
									'h1' => array(),
									'h2' => array(),
									'h3' => array(),
									'h4' => array(),
									'h5' => array(),
									'h6' => array(),
									'img' => array
										(
											'alt' => array(),
											'src' => array(),
										),
									'li' => array(),
									'p' => array(),
									'span' => array(),
									'table' => array(),
									'tbody' => array(),
									'td' => array
										(
											'colspan' => array(),
											'rowspan' => array(),
										),
									'tfoot' => array(),
									'th' => array
										(
											'colspan' => array(),
											'rowspan' => array(),
										),
									'thead' => array(),
									'tr' => array(),
									'ul' => array(),
									'ol' => array(),
								);
				} else { $tags = wp_kses_allowed_html( 'post' );};

				if(isset($data['remove_links'])) {
					if($data['remove_links'] == 'remove') {
						unset($tags['a']);
					}
				}

				if (isset($data['incvideos']) && $data['incvideos'] == 'add') {
						$tags['iframe'] = array(
							'id' => array(),
							'title' => array(),
							'src' => array(),
							'allowfullscreen' => array(),
							'width' => array(),
							'height' => array(),
							'name' => array(),
						);
					}

				WpScraper::$html = wp_kses(WpScraper::$html, $tags);

				$excerpt = wp_strip_all_tags(WpScraper::$html);
				$excerpt = wp_trim_words($excerpt, 55, ' [...]');

				$category = '';
				if (isset($data['post_category'])) {
					if (!is_array($data['post_category'])) {
						if (strpos($data['post_category'], ',') == false) {
							$cat_id = wp_create_category($data['post_category']);
							$category = array($cat_id);
						} elseif (strpos($data['post_category'], ',') !== false) {
							$cats = substr($data['post_category'], 1);
							$category = explode(',', $cats);
						}
					} else $category = $data['post_category'];
				}

				$title = $data['title'];

				if (isset($data['title_prefix'])) {
					$title = $data['title_prefix'].$title;
				}

				if (isset($data['title_suffix'])) {
					$title = $title.$data['title_suffix'];
				}

				$tags = '';
				if (isset($data['tax_input-post_tag'])) $tags = $data['tax_input-post_tag'];

				if (isset($data['add_copy'])) {
					if($data['add_copy'] == 'add') {
						$curHtml = WpScraper::$html;
						$copy = '<br><p class="wpss_copy">Content retrieved from: <a href="'.WpScraper::$url.'" target="_blank">'.WpScraper::$url.'</a>.</p>';
						WpScraper::$html = $curHtml.$copy;
					}
				}

				$postId = wp_insert_post(
					array(
						'post_type' => $data['hidden_post_type'],
						'post_status' => $data['hidden_post_status'],
						'post_title' => $title,
						'post_content' => WpScraper::$html,
						'post_excerpt' => $excerpt,
						'post_category' => $category,
						'tags_input' => $tags
					)
				);

				if (WpScraper::$images) {
					$images = explode("\n", WpScraper::$images);

					foreach ($images as $im) {
						$origSrc = $src = trim($im);

						$parts = wp_parse_url($src);
						if (isset($parts['query']) && $parts['query']) {
							parse_str($parts['query'], $query);
							if (isset($query['action']) && ($query['action']=='downloader')) {
								$src = urldecode($query['url']);
							}
						}

						if (substr($src, 0, 2) == '//') {
							$src = 'http:'. $src;
						}

						// Download to temp folder
						$tmp = download_url( $src );
						$file_array = array();
						$newSrc = '';

						preg_match('/[^\?]+\.(jpg|jpe|jpeg|gif|png)/i', $src, $matches);
						if (isset($matches[0]) && $matches[0]) {
							$file_array['name'] = basename($matches[0]);
							$file_array['tmp_name'] = $tmp;
							if ( is_wp_error( $tmp ) ) {
								$file_array['tmp_name'] = '';
							} else {
								// do the validation and storage stuff
								$imageId = media_handle_sideload( $file_array, $postId, '');

								// If error storing permanently, log
								if ( is_wp_error($imageId) ) {
								} else {
									$newSrc = wp_get_attachment_url($imageId);
									update_post_meta( $imageId, '_wpsf_parent', $postId );
								}
							}
						} else {
							error_log($tmp);
						}

						// Replace images url in code
						if ($newSrc) {
							WpScraper::$html = str_replace(htmlentities($origSrc), $newSrc, WpScraper::$html);
						}

					}
				}

				if($data['featured_image']) {
				$feat_image = $data['featured_image'];
				if (is_numeric($feat_image)) {
					$thumb_id = $feat_image;
				} else {
					$origSrc = $src = trim($data['featured_image']);

					$parts = wp_parse_url($src);
					if (isset($parts['query']) && $parts['query']) {
						parse_str($parts['query'], $query);
						if (isset($query['action']) && ($query['action']=='downloader')) {
							$src = urldecode($query['url']);
						}
					}

					if (substr($src, 0, 2) == '//') {
						$src = 'http:'. $src;
					}

					// Download to temp folder
					$tmp = download_url( $src );
					$file_array = array();
					$newSrc = '';

					preg_match('/[^\?]+\.(jpg|jpe|jpeg|gif|png)/i', $src, $matches);
					if (isset($matches[0]) && $matches[0]) {
						$file_array['name'] = basename($matches[0]);
						$file_array['tmp_name'] = $tmp;
						if ( is_wp_error( $tmp ) ) {
							error_log($file_array['tmp_name']);
							$file_array['tmp_name'] = '';
						} else {
							// do the validation and storage stuff
							$imageId = media_handle_sideload( $file_array, $postId, '');

							// If error storing permanently, unlink
							if ( is_wp_error($imageId) ) {
								error_log($file_array['tmp_name']);
							} else {
								$newSrc = wp_get_attachment_url($imageId);
								update_post_meta( $imageId, '_wpsf_parent', $postId );
								$thumb_id = $imageId;
							}
						}
					} else {
						error_log($tmp);
					}

				}
				} else $thumb_id = '';


                $url = WpScraper::$url;

				$meta = get_post_meta($postId);
				foreach ($meta as $key=>$item) {
					delete_post_meta($postId, $key);
				}

				$postId = wp_update_post(
					array(
						'ID' => (int) $postId,
						'post_type' => $data['hidden_post_type'],
						'post_status' => $data['hidden_post_status'],
						'post_title' => $title,
						'post_content' => WpScraper::$html,
						'post_excerpt' => $excerpt,
						'post_category' => $category,
						'tags_input' => $tags
					)
				);
				if ($thumb_id != '') {
				set_post_thumbnail( $postId, $thumb_id );
				}

				if ($limited == true) {
					add_post_meta($postId, 'wpsm', $data['limit']);
				}

        $redirect_url = wp_scraper_url('wp-scraper');
        $redirect_url = html_entity_decode($redirect_url);
				$response['redirect_url'] = str_replace('_wpnonce', 'pid='.$postId.'&_wpnonce', $redirect_url);
				$response['pid'] = $postId;
				$response['view'] = get_permalink($postId);
				$response['edit'] = get_edit_post_link($postId);
				$response = preg_replace_callback(
				'/\\\\u([0-9a-zA-Z]{4})/',
				function ($matches) {
					return mb_convert_encoding(pack('H*',$matches[1]),'UTF-8','UTF-16');
				},
				wp_json_encode($response)
				);
				echo wp_kses_post($response);
        		exit;

        }

	  	return array();
    }
    }

	public static function wp_scraper_extract_content(){
    check_admin_referer('wp_scraper_url');
        $request = $_GET;
        $blockUrl = isset($_GET['blockUrl'])?$_GET['blockUrl']:null;
		$downloader = isset($_GET['down'])?$_GET['down']:null;
		$js = isset($_GET['js'])?true:false;

        if ($blockUrl) {
            $blockUrl = trim(urldecode($blockUrl));

            if (substr($blockUrl, 0, 2) == '//') {
                $blockUrl = 'http://' . substr($blockUrl, 2);
            } elseif (substr($blockUrl, 0, 4) != 'http') {
                $blockUrl = 'http://' . $blockUrl;
            }


			WpScraper::$url = $blockUrl;


				try {
					if (!function_exists('file_get_html')) {
						require_once(WPSF_DIR.'/includes/simple_html_dom.php');
					}

					$parts = wp_parse_url($blockUrl);
					$domain = $parts['scheme'].'://'.$parts['host'];

					if (isset($parts['port']) && $parts['port'] && ($parts['port'] != '80')) {
						$domain .= ':'.$parts['port'];
					}

					// Relative path URL
					$relativeUrl = $domain;
					if (isset($parts['path']) && $parts['path']) {
						$pathParts = explode('/', $parts['path']);
						if (count($pathParts)) {
							unset($pathParts[count($pathParts)-1]);
							$relativeUrl = $domain.'/'.implode('/',$pathParts);
						}
					}

					$content = wp_remote_get($blockUrl);
					if (is_wp_error($content) || ($content['response']['code'] != 200)) {
						$arrContextOptions=array(
							"ssl"=>array(
								"verify_peer"=>false,
								"verify_peer_name"=>false,
							),
							'http'=>array(
								'ignore_errors' => true,
								'method'=>"GET",
								'header'=>"Accept-language: en-US,en;q=0.5\r\n" .
									"Cookie: foo=bar\r\n" .
									"User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_5) AppleWebKit/600.8.9 (KHTML, like Gecko) Version/8.0.8 Safari/600.8.9\r\n" // i.e. An iPad
							)
						);
						$html = file_get_html($blockUrl, false, stream_context_create($arrContextOptions));
					} else {
						$html = str_get_html($content['body']);
					}

					if (!$html) return false;

					if (!$js) {
						foreach($html->find('script') as $element) {
							$element->outertext = '';
						}
					}

					// Remove meta
					foreach($html->find('meta[http-equiv*=refresh]') as $meta) {
						$meta->outertext = '';
					}

					// Remove meta x-frame
					foreach($html->find('meta[http-equiv*=x-frame-options]') as $meta) {
						$meta->outertext = '';
					}

					// Modify image and CSS URL's adding domain name if needed
					foreach($html->find('img') as $element) {
						$src = trim($element->src);

						if (empty($src)) $src = $src;
						elseif (strlen($src)>2 && (substr($src, 0, 1) == '/') && ((substr($src, 0, 2) != '//'))) {
							$src = $domain.$src;
						} elseif ((substr($src, 0, 4) != 'http') && (substr($src, 0, 2) != '//')) {
							$src = $relativeUrl .'/'.$src;
						}

						$downloader = $downloader?wp_scraper_url('wp-scraper', 'downloader'):'';

						if ($downloader) {
							if (strpos($downloader, '?')) {
								$element->src = $downloader.'&url='.wp_scraper_encodeURIComponent($src);
							} else {
								$element->src = $downloader.'?url='.wp_scraper_encodeURIComponent($src);
							}
						} else {
							$element->src = $src;
						}
					}

					// Modify links
					foreach($html->find('a') as $element) {
						$href = trim($element->href);
						if (strlen($href)>2 && (substr($href, 0, 1) == '/') && ((substr($href, 0, 2) != '//'))) {
							$href = $domain.$href;
						} elseif (substr($href, 0, 4) != 'http') {
							$href = $relativeUrl .'/'.$href;
						}
						$element->href = $href;
					}

					// Replace all styles URL’s
					foreach($html->find('link') as $element) {
						$src = trim($element->href);
						if (strlen($src)>2 && (substr($src, 0, 1) == '/') && ((substr($src, 0, 2) != '//'))) {
							$src = $domain.$src;
						} elseif ((substr($src, 0, 4) != 'http') && (substr($src, 0, 2) != '//')) {
							$src = $relativeUrl .'/'.$src;
						}
						$element->href = $src;
					}

					// Append our JavaScript and CSS
					$scripts = '<script type="text/javascript" src="'.esc_url(includes_url( '/js/jquery/jquery.js' )).'"></script>';
					$scripts .= '<script type="text/javascript" src="'.esc_url(plugins_url( 'includes/simpledomselector.js', __FILE__ )).'?'.time().'"></script>';
					$scripts .= '<script type="text/javascript" src="'.esc_url(plugins_url( 'includes/wp-scraper-ingest.js', __FILE__ )).'?'.time().'"></script>';
					$scripts .= '<style type="text/css">.wpscraper-hover {outline: 3px dotted #B2E0F0 !important; opacity: .7 !important;filter: alpha(opacity=70) !important; background-color: #B2E0F0 !important;}.wpscraper-hover-parent {background-color:#B2E0F0 !important;} .wpscraper-hover img {opacity: 0.7 !important; filter: alpha(opacity=70 !important);} .wpscraper-selected {outline: 5px solid #19A3D1 !important;background-color: #4DB8DB !important; opacity: .7 !important;filter: alpha(opacity=70) !important;} .wpscraper-selected-parent {background-color: #4DB8DB !important;} .wpscraper-selected img {opacity: 0.7 !important; filter: alpha(opacity=70) !important;}
					.wpscraper-not-hover {outline: 3px dotted #efb7b2 !important; opacity: .7 !important;filter: alpha(opacity=70) !important; background-color: #efb7b2 !important;}.wpscraper-not-hover-parent {background-color:#efb7b2 !important;} .wpscraper-not-hover img {opacity: 0.7 !important; filter: alpha(opacity=70 !important);} .wpscraper-not-selected {outline: 5px solid #d12e18 !important;background-color: #db584d !important; opacity: .7 !important;filter: alpha(opacity=70) !important;} .wpscraper-not-selected-parent {background-color: #db584d !important;} .wpscraper-not-selected img {opacity: 0.7 !important; filter: alpha(opacity=70) !important;}</style>';

					$html = str_replace('</body>', $scripts.'</body>', $html);

					$page = $html;
				} catch (PicoBlockException $e) {
					$page = false;
				}
        }

        WpScraper::wp_scraper_page(
            array(
                'page' => $page
            )
        );
        exit;
    }

	public static function wp_scraper_downloader_content(){
    check_admin_referer('wp_scraper_url');
        $request = $_GET;
        $url = trim(urldecode(isset($_GET['url'])?$_GET['url']:null));

        if (substr($url, 0, 2) == '//') {
            $url = 'http://'.substr($url,2);
        }

        $arrContextOptions=array(
            "ssl"=>array(
                "verify_peer"=>false,
                "verify_peer_name"=>false,
            ),
        );


        $content = wp_remote_retrieve_body($url, null, stream_context_create($arrContextOptions));

        echo wp_kses_post($content);
        exit;
    }

}



/**
 * Admin enqueue scripts
 */
function wpsf_admin_enqueue_scripts( $hook ) {
  $version = WPSF_CURRENT_VERSION;

	if ( $hook == 'toplevel_page_wp-scraper' || $hook == 'admin_page_wp-scraper-add-menu' ){
		wp_enqueue_media();
		wp_enqueue_script( 'jquery' );
		wp_enqueue_style( 'wp-scraper-css', plugins_url( 'wp-scraper.css', __FILE__ ), array(), $version, 'all' );
		wp_enqueue_script( 'wp-scraper-js', plugins_url( 'wp-scraper.js', __FILE__), array( 'jquery' ), $version, 'all' );
		wp_localize_script( 'wp-scraper-js', 'ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
		wp_enqueue_script('post');
    }
	if ( $hook == 'overlay_for_wp-scraper'  ){
		wp_enqueue_script( 'jquery' );
        wp_enqueue_script( 'wp-scraper-ingest', plugins_url( 'includes/wp-scraper-ingest.js', __FILE__ ), array( 'jquery' ), $version, 'all' );
    }
	if ($hook == 'wp-scraper_page_wp-scraper-live-menu') {
		wp_enqueue_style( 'wp-scraper-css', plugins_url( 'wp-scraper.css', __FILE__ ), array(), $version, 'all' );
	}
}

function wp_scraper_url($controller, $action='', $params=array()) {

		$url = menu_page_url( $controller, false );

        if ($action) {
            $url = add_query_arg(array( 'action' => $action ), $url);
        }

        if (count($params)) {
            $url = add_query_arg($params, $url);
        }

        $url = wp_nonce_url($url, 'wp_scraper_url', '_wpnonce');

        return $url;
    }

function wp_scraper_encodeURIComponent($str) {
    $revert = array('%21'=>'!', '%2A'=>'*', '%27'=>"'", '%28'=>'(', '%29'=>')');
    return strtr(rawurlencode($str), $revert);
}

/* Generate url page */

function wp_scraper_url_page() {
	echo '<div class="wrap wpsf-settings">
	<h1>Url Selection</h1>
  <div class="notice notice-info is-dismissible">
  <p>Please note, you are limited to ten posts in this test, and you can only test it once. If you want to repeat the test, you will need to permanently delete the generated posts before trying again.</a>
  </div>
  <p class="description">You can either generate a list of urls or paste a comma separated list of urls inside the box below. Once you have the urls you want to scrape click \'Continue\' at the bottom of the page.</p>
	<div id="wpsf-generate" class="meta-box-sortables">
	<div class="postbox closed">
	<div class="handlediv" title="Click to toggle">
	<span class="dashicons dashicons-arrow-down"></span>
	</div>
	<h3  class="hndle ui-sortable-handle">
	<span>Generate Urls</span>
	</h3>
	<div class="inside wpsf-url-form">
	<table class="form-table"><tbody>
	<tr><th scope="row"><label class="label" for="wpsf_url" >Url:<span class="wpsf-req">*</span></label></th>
	<td><input id="wpsf-url" class="regular-text ltr" type="text" name="wpsf_url"/>
	<p id="wpsf-urld" class="description" >Set this to the url you would like to pull content from.</p></td></tr>
	<tr><th scope="row"><label class="label" for="wpsf_follow" >Domain Pattern:<span class="wpsf-req">*</span></label></th>
	<td><label><input type="radio" name="wpsf_follow" value="1" >Only follow links with the same url.<p class="description">www.example.com and sub.example.com</p></label><br/>
	<label><input type="radio" name="wpsf_follow" value="2" >Only follow links with the same domain.<p class="description">www.example.com not sub.example.com</p></label><br/>
	<label><input type="radio" name="wpsf_follow" value="3" >Only follow links in the same path as the given url.<p id="wpsf-pattern" class="description">If the url is www.example.com/path/index.html, only get urls in www.example.com/path/</p></label></td></tr>
	<tr><th scope="row"><label class="label" for="wpsf_number" >Number of Pages:<span class="wpsf-req">*</span></label></th>
	<td><label><input type="radio" name="wpsf_number" value="10" >10</label><br/>
	<label><input type="radio" name="wpsf_number" value="25" >25</label><br/>
	<label><input type="radio" name="wpsf_number" value="50" >50</label><br/>
	<label><input type="radio" name="wpsf_number" value="75" >75</label><br/>
	<label><input type="radio" name="wpsf_number" value="100" >100</label>
	<p id="wpsf-num" class="description" >This sets the amount of webpages to pull from the url.</p></td></tr>
	<tr><th scope="row"><label class="label" for="wpsf_skip" >Skip Links:</label></th>
	<td><input id="wpsf-skip" type="text" name="wpsf_skip" />
	<p class="description" >Optionally skip a certain number of links. This is useful if you have already scraped a number of links from a website and want to scrape more pages now. For example, if you already created posts with 10 links from this url, and now you want to grab the next 10 links, you would enter 10 into the box above.</p></td></tr>
	<tr><th scope="row"><label class="label" for="wpsf_depth" >Depth Limit:</label></th>
	<td><input id="wpsf-depth" type="text" name="wpsf_depth" />
	<p class="description" >Optionally set the depth limit for crawling pages. If this value is set to 1, it will only gather webpages that are linked on the entry page. If it is set to 2, it will also gather all webpages linked to the pages found on the entry page.</p></td></tr>
	<tr><th scope="row"><label class="label" for="wpsf_delay" >Request Delay:</label></th>
	<td><input id="wpsf-delay" class="regular-text ltr" type="text" name="wpsf_delay" /> seconds
	<p class="description" >Optionally delay each request to the url. This can keep your site from making too many requests at once to the url. </p></td></tr>
	<tr><th scope="row"><label class="label" for="wpsf_pattern" >Path Matching:</label></th>
	<td> <select id="wpsf-typematch">
	<option value="contains">Contains</option>
	<option value="ends">Ends With</option>
	</select>
	<input id="wpsf-pattern" class="regular-text ltr" type="text" name="wpsf_pattern" />
	<p class="description" >Optionally add a word to match within urls.<br>For example, choosing "contains foo" above would only add webpages to the list that have "foo" in the path such as example.com/foo or example.com/path/this-page-has-foo</p></td></tr>
	</tbody></table>
	<p class="submit">
	<input id="wpsf-crawl-submit" class="button button-primary" type="submit" value="Get Webpages" name="submit">
	</p></div></div></div>
	<h3>Webpages to Scrape:</h3>
	<p class="description">Every url listed in the box below will be used to generate content for your site. Remove any generated urls that you do not want to pull content from.</p>
	<form id="wpsf-url-submit" action="'.esc_url(admin_url()).'admin.php?page=wp-scraper-add-menu" method="POST" >
	<textarea id="wpsf-url-list" style="width: 100%; min-height: 300px;" name="url_list"></textarea>
	<p class="submit">
	<input id="wpsf-continue-submit" class="button button-primary" type="submit" value="Continue" name="submit">
	</p></form>';
}

function wp_scraper_help_page() {
  echo '<style type="text/css">
	.fusion-one-half img {
		max-width: 100%;
		box-shadow: 3px 3px 5px 5px #ccc;
	}
	.fusion-layout-column {
		float: left;
		margin-right: 4%;
		position: relative;
	}
	.fusion-one-half {
		width: 46%;
	}
	.fusion-sep-clear {
		clear: both;
		display: block;
		font-size: 0;
		height: 1px;
		line-height: 0;
		overflow: hidden;
		width: 90%;
	}
	.fusion-separator {
		clear: both;
		position: relative;
		z-index: 11;
		border-top: #e0dede solid 1px;
		margin-bottom: 30px;
		margin-left: auto;
		margin-right: auto;
	}
	</style>
	<h1>Documentation</h1>';

// Installation
				echo '<div class="fusion-one-half fusion-layout-column fusion-spacing-yes" style="margin-top:0px;margin-bottom:20px;"><div class="fusion-column-wrapper">
<h3>
<strong>Installation</strong>
</h3>
<h4>Uploading via WordPress Dashboard</h4>
<ol>
<li>Navigate to the ‘Add New’ in the plugins dashboard</li>
<li>Navigate to the ‘Upload’ area</li>
<li>Select wp-scraper-pro.zip from your computer</li>
<li>Click ‘Install Now’</li>
<li>Activate the plugin in the Plugin dashboard</li>
</ol>
<h4>Using FTP</h4>
<ol>
<li>Download wp-scraper-pro.zip</li>
<li>Extract the wp-scraper-pro.zip directory to your computer</li>
<li>
Upload the wp-scraper-pro directory to the
<code>/wp-content/plugins/</code>
directory
</li>
<li>Activate the plugin in the Plugin dashboard</li>
</ol>

</div></div><div class="fusion-one-half fusion-layout-column fusion-column-last fusion-spacing-yes" style="margin-top:0px;margin-bottom:20px;"><div class="fusion-column-wrapper"><p>

<img class="alignnone size-full wp-image-126" src="'.esc_url(plugins_url( "images/Install-Plugin.jpg", __FILE__ )).'" alt="Install Plugin" />

</p>
</div></div><div class="fusion-clearfix"></div><div class="fusion-sep-clear"></div><div class="fusion-separator fusion-full-width-sep sep-single" style="border-color:#e0dede;border-top-width:1px;margin-left: auto;margin-right: auto;margin-top:px;margin-bottom:30px;"></div>';


// Single Scrape

echo '<div class="fusion-one-half fusion-layout-column fusion-spacing-yes" style="margin-top:0px;margin-bottom:20px;"><div class="fusion-column-wrapper">

<h3>
<strong>Single Scrape </strong>
</h3>
<p>
<strong>*URL</strong>
<br>
Enter the URL you wish to copy content from.
</p>
<p>
<strong>*Title</strong>
<br>
You may select a title from the source page or add your own.
</p>
<p>
<strong>*Post Content</strong>
<br>
You may select multiple areas of the source page including images.
</p>
<p>
<strong>Post Type</strong>
<br>
Post Type: Post, Page – Status: Published, Draft, Pending Review
</p>
<p>
<strong>Options</strong>
<br>
Only Text and Images – Checked will remove all html elements except p, div, table, list, break, headings, span, and images. Links are automatically removed with this option. All ids and classes are also removed.
<br><br>
Remove Links – Checked will remove all external links from the content.
<br><br>
Add source link to the content – Checked will Add source link to the content.
</p>
<p>
<strong>Categories</strong>
<br>
Select a category or create a new one.
</p>
<p>
<strong>Tags</strong>
<br>
Select tags from source page or add your own.
</p>
<p>
<strong>Featured Image</strong>
<br>
Select an image from the source page or add your own.
</p>
<p>* Required</p>
<div class="fusion-clearfix"></div>

</div></div><div class="fusion-one-half fusion-layout-column fusion-column-last fusion-spacing-yes" style="margin-top:0px;margin-bottom:20px;"><div class="fusion-column-wrapper"><p>

<img class="alignnone size-full wp-image-205" src="'.esc_url(plugins_url( "images/Add-New-Scraped-Post-1200x1066.jpg", __FILE__ )).'" alt="Single Scrape" />

</p>
</div></div><div class="fusion-clearfix"></div><div class="fusion-sep-clear"></div><div class="fusion-separator fusion-full-width-sep sep-single" style="border-color:#e0dede;border-top-width:1px;margin-left: auto;margin-right: auto;margin-top:px;margin-bottom:30px;"></div>';

// Content Selection

echo '<div class="fusion-one-half fusion-layout-column fusion-spacing-yes" style="margin-top:0px;margin-bottom:20px;"><div class="fusion-column-wrapper">

<h3><strong>Content Selection</strong></h3>

<p><strong>Highlighting And Selection</strong><br>
You may select as much content as you wish by simply clicking to select the blocks of content you want. As your mouse hovers over the page, a blue box will appear to illustrate what content you will get. If there is an area within the blue box that you do not wish to include, simply click it again. A red box will appear inside the blue box to illustrate content that will be excluded.</p>

<p><strong>Add selected content</strong><br>
Hit the add selected content to my post button on top of window and the content will be added to the WP Scraper post editor.</p>

<p><strong>How much should I select?</strong><br>
Depending on server resources adding content to your post may take anywhere from a few seconds to a few minutes. The more content you import into your post, the longer scraping will take. If it takes too long to scrape, you could try increasing the “Time Delay Between Scrapes” under Extract Options.</p><br>

<h3>
<strong>Advanced Content Selecting</strong>
</h3>
<p  style="background-color: #fff; border: 2px solid #000; border-radius: 3px; color: #000; padding: 10px;">This feature is only available in the <a href="http://www.wpscraper.com/">Pro Version</a>.<br> </p>

<p><strong>Selecting the Right Content</strong><br>
If at any time you are having trouble getting the visual selector to choose the right elements from the page, you can manually type in the correct selector into the selection textboxes. These inputs are different from others on the scrape page, and can be distinguished by the red text inside them.</p>
<p>To find the right element, you must have an understanding of HTML and CSS selectors.</p>
<p>On most popular browsers, you can right click and inspect any element on any website. This will bring up the source code for that page, with the element you selected highlighted.</p>
<p>By viewing the source code you can find the id, class, or another selector to use.</p>
<p>Ensure that this selector is unique on the page, meaning if the class of the element is "blue", be sure there are no other elements on the page using the class "blue" to be sure that you are choosing the right element.</p>
<p>It is often necessary to nest elements to get a truly unique selector. To do this correctly for scraper you will want to use this ">" between each element. You can also use ":eq(n)" to select the nth element that matches. When using ":eq(n)" rememeber that the number "n" starts at 0 not 1.</p>
<p>For example, if you want to select the first h1 inside of the #main div, you would use type this selector into the selection text box: "#main > h1:eq(0)".</p>
<strong><p>We recommend you use this option with caution, and be sure you understand HTML elements and CSS selectors before attempting to change these fields.</p></strong>

<div class="fusion-clearfix"></div>

</div></div><div class="fusion-one-half fusion-layout-column fusion-column-last fusion-spacing-yes" style="margin-top:0px;margin-bottom:20px;"><div class="fusion-column-wrapper"><p>

<img class="alignnone size-full wp-image-110" src="'.esc_url(plugins_url( "images/Saturrn-1200x923.jpg", __FILE__ )).'" alt="Content Selection - Single Scrape" /><br><br>
<img class="alignnone size-full wp-image-205" src="'.esc_url(plugins_url( "images/Title_Selector.jpg", __FILE__ )).'" alt="Title Selector" /><br><br>
<img class="alignnone size-full wp-image-205" src="'.esc_url(plugins_url( "images/Content_Selector.jpg", __FILE__ )).'" alt="Content Selector" />

</p>
</div></div><div class="fusion-clearfix"></div><div class="fusion-sep-clear"></div><div class="fusion-separator fusion-full-width-sep sep-single" style="border-color:#e0dede;border-top-width:1px;margin-left: auto;margin-right: auto;margin-top:px;margin-bottom:30px;"></div>';

// Generating Urls
echo '<div class="fusion-one-half fusion-layout-column fusion-spacing-yes" style="margin-top:0px;margin-bottom:20px;"><div class="fusion-column-wrapper">

<h3>
<strong>Generating URL’s</strong>
</h3>
<p  style="background-color: #fff; border: 2px solid #000; border-radius: 3px; color: #000; padding: 10px;">This feature is only available in the <a href="http://www.wpscraper.com/">Pro Version</a>.<br> </p>
<p><strong>URL Visual Selector</strong></p>
<p>The visual selector works much in the same way as the Content Selector. The difference is you will only need to select one link to the pages you wish to scrape into your site. The visual selector will then import all similar links into a list for you to use with the multiple scraper.</p>

<p><strong>PHP Crawler</strong></p>

<p>
<strong>Domain Pattern:</strong>
</p>
<p>Only follow links with the same url. – www.example.com and sub.example.com</p>
<p>Only follow links with the same domain. – www.example.com not sub.example.com</p>
<p>
Only follow links in the same path as the given url. – If the url is
<br>
www.example.com/path/index.html, only get urls in www.example.com/path/
</p>
<p>
<strong>Number of Pages:</strong><br>
Allowed Options: 10, 25, 50, 75 and 100 – This sets the amount of webpages to pull from the url.</p>
<p>
<strong>Skip Links:</strong>
<br>
Optionally skip a certain number of links. This is useful if you have already scraped a number of links from a website and want to scrape more pages now. For example, if you already created posts with 10 links from this url, and now you want to grab the next 10 links, you would enter 10 into the box above.
</p>
<p>
<strong>Depth Limit:</strong>
<br>
Optionally set the depth limit for crawling pages. If this value is set to 1, it will only gather webpages that are linked on the entry page. If it is set to 2, it will also gather all webpages linked to the pages found on the entry page.
</p>
<p>
<strong>Request Delay: Seconds</strong>
<br>
Optionally delay each request to the url. This can keep your site from making too many requests at once to the url.
</p>
<p>
<strong>Path Matching: Contains – Ends with</strong>
<br>
Optionally add a word to match within urls.
<br>
For example, choosing “contains foo” above would only add webpages to the list that have “foo” in the path such as example.com/foo or example.com/path/this-page-has-foo
</p>
<p>Note: The list of URL’s will vary in quantity and accuracy depending on the site your retrieving them from.</p>
<div class="fusion-clearfix"></div>

</div></div><div class="fusion-one-half fusion-layout-column fusion-column-last fusion-spacing-yes" style="margin-top:0px;margin-bottom:20px;"><div class="fusion-column-wrapper"><p>

<img class="alignnone size-full wp-image-110" src="'.esc_url(plugins_url( "images/URL-Selection-1200x1066.jpg", __FILE__ )).'" alt="Generating URL\'s" /><br><br>
<img class="alignnone size-full wp-image-110" src="'.esc_url(plugins_url( "images/URL-List.jpg", __FILE__ )).'" alt="Generating URL\'s" />

</p>
</div></div><div class="fusion-clearfix"></div><div class="fusion-sep-clear"></div><div class="fusion-separator fusion-full-width-sep sep-single" style="border-color:#e0dede;border-top-width:1px;margin-left: auto;margin-right: auto;margin-top:px;margin-bottom:30px;"></div>';

// Multiple Scrape

echo '<div class="fusion-one-half fusion-layout-column fusion-spacing-yes" style="margin-top:0px;margin-bottom:20px;"><div class="fusion-column-wrapper">

<h3>
<strong>Multiple Scrape </strong>
</h3>
<p>
<p  style="background-color: #fff; border: 2px solid #000; border-radius: 3px; color: #000; padding: 10px;">This feature is only available in the <a href="http://www.wpscraper.com/">Pro Version</a>.<br> </p>
<strong>*Titles</strong>
<br>
*Select a title from source page or add your own.
</p>
<p>
<strong>*Post Content</strong>
<br>
*You may select multiple areas of the source page including images.
</p>
<p>
<strong>Post Type</strong>
<br>
Post Type: Post, Page – Status: Published Draft, Pending Draft
</p>
<p>
<strong>Options</strong>
<br>
Include Images, Format Tables, Remove Links, Add source link to the content</p>

<p>
<strong>HTML Options</strong>
<br>Strip all HTML, Include Post HTML, Include Basic HTML, or you can specify exactly which HTML to keep in the content
</p>
<p>
<strong>*Categories</strong>
<br>
Select a category or create a new one.
</p>
<p>
<strong>*Tags</strong>
<br>
*Select tags from source page or add your own.
</p>
<p>
<strong>*Featured Image</strong>
<br>
Select an image from the source page or add your own.
</p>

<p><strong>Extract Options</strong></p>

<p><strong>Load JavaScript</strong><br>
Some content may need javascript enabled to display correctly. Check this box to enable javascript while selecting content.</p>

<p><strong>Load Restricted Image Content</strong><br>
Some images will not load due to cross domain conflicts. Use this feature to load these restricted images. However, it doesn’t work with all server configurations. Use with caution.</p>

<p><strong>Time Delay Between Scrapes</strong><br>
This option will scrape one page at a time with this delay between each post. This will help manage your server resources. Choices Include: None, Ten Seconds, Thirty Seconds or One Minute</p>

<p>*If you type in your own content into the multiple scraper fields then the content will be repeated throughout all the posts. If you choose the content from the source page for any of these fields then the scraper will find and add the content to each post.</p>
<div class="fusion-clearfix"></div>

</div></div><div class="fusion-one-half fusion-layout-column fusion-column-last fusion-spacing-yes" style="margin-top:0px;margin-bottom:20px;"><div class="fusion-column-wrapper"><p>

<img class="alignnone size-full wp-image-133" src="'.esc_url(plugins_url( "images/Add-mulitple-Scraped-Post-1-1200x1009.jpg", __FILE__ )).'" alt="Multiple Scrape"  /><br><br>
<img class="alignnone size-full wp-image-133" src="'.esc_url(plugins_url( "images/Add-mulitple-Scraped-Post-e1509110908161.jpg", __FILE__ )).'" alt="Multiple Scrape"  />

</p>
</div></div>

<div class="fusion-clearfix"></div><div class="fusion-sep-clear"></div><div class="fusion-separator fusion-full-width-sep sep-single" style="border-color:#e0dede;border-top-width:1px;margin-left: auto;margin-right: auto;margin-top:px;margin-bottom:30px;"></div>';

// WP Scraper Results

echo '<div class="fusion-one-half fusion-layout-column fusion-spacing-yes" style="margin-top:0px;margin-bottom:20px;"><div class="fusion-column-wrapper">

<h3>
<strong>WP Scraper Results</strong>
</h3>
<p  style="background-color: #fff; border: 2px solid #000; border-radius: 3px; color: #000; padding: 10px;">This feature is only available in the <a href="http://www.wpscraper.com/">Pro Version</a>.<br> </p>

<p>The results of the scraper will be shown in real time as posts are created. Please remain on this page until all of your posts are created or it will interrupt the scraping process. Each post will display as soon as it is made. You can view or edit any of the new posts from this screen by simply clicking the provided links. When scraping is complete the progress bar will be removed and a message will be displayed showing that the process is now complete. After completion you are free to navigate from the page.</p>


<p><strong>Errors When Scraping</strong></p>

<p>There are usually only two reasons that a page fails to scrape. The first is if your php allowed memory size is too small to handle the scrape. You can change your php.ini settings to allow for a higher memory_limit. The other main reason scrapes fail is from the selector not being exactly the same on all pages. If this is the case simply rescrape the remaining pages with new selectors.</p>

<p>If you consistently receive multiple errors, try increasing the “Time Delay Between Scrapes” under Extract Options.</p>

<p>WP Scraper Pro will supply you with a list of url’s that failed so you can try again.</p>

<div class="fusion-clearfix"></div>

</div></div><div class="fusion-one-half fusion-layout-column fusion-column-last fusion-spacing-yes" style="margin-top:0px;margin-bottom:20px;"><div class="fusion-column-wrapper"><p>

<img class="alignnone size-full wp-image-205" src="'.esc_url(plugins_url( "images/Results-1-e1509128031325-1200x675.jpg", __FILE__ )).'" alt="Scraper Results" /><br><br>
<img class="alignnone size-full wp-image-205" src="'.esc_url(plugins_url( "images/errors-text.jpg", __FILE__ )).'" alt="Scraper Results" />

</p>
</div></div><div class="fusion-clearfix"></div><div class="fusion-sep-clear"></div><div class="fusion-separator fusion-full-width-sep sep-single" style="border-color:#e0dede;border-top-width:1px;margin-left: auto;margin-right: auto;margin-top:px;margin-bottom:30px;"></div>';

// Auto Scrape Scheduled Page

echo '<div class="fusion-one-half fusion-layout-column fusion-spacing-yes" style="margin-top:0px;margin-bottom:20px;"><div class="fusion-column-wrapper">

<h3>
<strong>Auto Scrape - Schedule Page</strong>
</h3>
<p  style="background-color: #fff; border: 2px solid #000; border-radius: 3px; color: #000; padding: 10px;">This feature is only available in the <a href="http://www.wpscraper.com/">Pro Version</a>.<br> </p>

<p>On this page, you can see each Auto Scrape that you have scheduled for your site. You can also add a new Auto Scrape, or edit and delete any saved scrapes from this screen.</p>
<p>Auto Scrape will automatically pull all urls from a source page that you select, and add any new posts into your site.</p>
<p>For example, let\'s say you have a blog on wordpress.com and you want each article you add there to automatically be imported into your website.</p>
<p>You can set the Auto Scrape to the homepage of your blog on wordpress.com, which typically shows links to each of your recent articles.</p>
<p>Each time Auto Scrape runs, it will check your blog page and compare it with what has already been imported into your site.</p>
<p>Any new articles will automatically be added into your wordpress website as well.</p>

<div class="fusion-clearfix"></div>

</div></div><div class="fusion-one-half fusion-layout-column fusion-column-last fusion-spacing-yes" style="margin-top:0px;margin-bottom:20px;"><div class="fusion-column-wrapper"><p>

<img class="alignnone size-full wp-image-205" src="'.esc_url(plugins_url( "images/Auto_Scrape.jpg", __FILE__ )).'" alt="Auto Scrape" />

</p>
</div></div><div class="fusion-clearfix"></div><div class="fusion-sep-clear"></div>
<div class="fusion-separator fusion-full-width-sep sep-single" style="border-color:#e0dede;border-top-width:1px;margin-left: auto;margin-right: auto;margin-top:px;margin-bottom:30px;"></div>';

// Auto Scrape - Add New

echo '<div class="fusion-one-half fusion-layout-column fusion-spacing-yes" style="margin-top:0px;margin-bottom:20px;"><div class="fusion-column-wrapper">
<h3>
<strong>Auto Scrape - Add a New Auto Scrape</strong>
</h3>
<p  style="background-color: #fff; border: 2px solid #000; border-radius: 3px; color: #000; padding: 10px;">This feature is only available in the <a href="http://www.wpscraper.com/">Pro Version</a>.<br> </p>

<p>
<strong>*Name</strong>
<br>
*Set a name for this Auto Scrape to distinguish it from other saved Auto Scrapes.
</p>
<p>
<strong>*Schedule</strong>
<br>
*Set how often this Auto Scrape will pull new posts into your site..
</p>
<p>
<strong>Url Selection</strong>
<br>
The visual selector works much in the same way as the Content Selector. The difference is you will only need to select one link to the pages you wish to scrape into your site. The visual selector will then import all similar links into a list for you to use with the auto scraper.
</p>
<p>
Once you have your first list of Urls to scrape, click <strong>Continue</strong> at the bottom of the page. You will then be taken to the Add Auto Scraped Posts. This page is similar to the Multiple Scrape Page.
</p><br><br>
<h3>
<strong>Selecting Content And Options</strong>
</h3>
<p  style="background-color: #fff; border: 2px solid #000; border-radius: 3px; color: #000; padding: 10px;">This feature is only available in the <a href="http://www.wpscraper.com/">Pro Version</a>.<br> </p>

<p>
Content selection and chosing options will be similar to the Multiple Scrape.
</p>
<p>
<strong>*Titles</strong>
<br>
*Select a title from source page or add your own.
</p>
<p>
<strong>*Post Content</strong>
<br>
*You may select multiple areas of the source page including images.
</p>
<p>
<strong>Post Type</strong>
<br>
Post Type: Post, Page – Status: Published Draft, Pending Draft
</p>
<p>
<strong>Options</strong>
<br>
Include Images, Format Tables, Remove Links, Add source link to the content</p>

<p>
<strong>HTML Options</strong>
<br>Strip all HTML, Include Post HTML, Include Basic HTML, or you can specify exactly which HTML to keep in the content
</p>
<p>
<strong>*Categories</strong>
<br>
Select a category or create a new one.
</p>
<p>
<strong>*Tags</strong>
<br>
*Select tags from source page or add your own.
</p>
<p>
<strong>*Featured Image</strong>
<br>
Select an image from the source page or add your own.
</p>

<p><strong>Extract Options</strong></p>

<p><strong>Load JavaScript</strong><br>
Some content may need javascript enabled to display correctly. Check this box to enable javascript while selecting content.</p>

<p><strong>Load Restricted Image Content</strong><br>
Some images will not load due to cross domain conflicts. Use this feature to load these restricted images. However, it doesn’t work with all server configurations. Use with caution.</p>

<p><strong>Time Delay Between Scrapes</strong><br>
This option will scrape one page at a time with this delay between each post. This will help manage your server resources. Choices Include: None, Ten Seconds, Thirty Seconds or One Minute</p>

<p>*You must select the content from the source page for the scraper to find and add the content to each post. You may set specific Categories, Tags, or a Featured Image for all the Auto Scraped Posts to have, but post title and post content must be selected using the visual selector.</p>

<p>Once you are finished click <strong>Create Auto Scrape</strong>.</p>
<p>The Auto Scrape will then save, and create your first batch of posts which you selected previously. You will be taken to a page that is similar to the Multiple Scrape Results page. You can see which posts have saved and which haven\'t.</p>
<div class="fusion-clearfix"></div>

</div></div><div class="fusion-one-half fusion-layout-column fusion-column-last fusion-spacing-yes" style="margin-top:0px;margin-bottom:20px;"><div class="fusion-column-wrapper"><p>
<img class="alignnone size-full wp-image-133" src="'.esc_url(plugins_url( "images/New_Auto_Scrape.jpg", __FILE__ )).'" alt="New Auto Scrape"  /><br><br>
<img class="alignnone size-full wp-image-133" src="'.esc_url(plugins_url( "images/Add-mulitple-Scraped-Post-1-1200x1009.jpg", __FILE__ )).'" alt="Multiple Scrape"  />
</p>
</div></div><div class="fusion-clearfix"></div><div class="fusion-sep-clear"></div>
<div class="fusion-separator fusion-full-width-sep sep-single" style="border-color:#e0dede;border-top-width:1px;margin-left: auto;margin-right: auto;margin-top:px;margin-bottom:30px;"></div>';


// Auto Scrape - Log

echo '<div class="fusion-one-half fusion-layout-column fusion-spacing-yes" style="margin-top:0px;margin-bottom:20px;"><div class="fusion-column-wrapper">

<h3>
<strong>Auto Scrape - Log Page</strong>
</h3>
<p  style="background-color: #fff; border: 2px solid #000; border-radius: 3px; color: #000; padding: 10px;">This feature is only available in the <a href="http://www.wpscraper.com/">Pro Version</a>.<br> </p>
<p>On the Auto Scrape Log Page you can see which Urls have been pulled into your site. Should you ever need to re-import a Url, simply delete if from this page, and if it is linked on your source Url it will be imported again the next time Auto Scrape runs. </p>
<p>This page will also show you the last time your Auto Scrape ran</p>
<p>Only 100 urls will be saved into the log at a time to prevent the log from using large amounts of your server resources when Auto Scrape runs. By keeping this file small in size, Auto Scrape remains a lightweight solution to your Auto Scraping needs. </p>

<div class="fusion-clearfix"></div>

</div></div><div class="fusion-one-half fusion-layout-column fusion-column-last fusion-spacing-yes" style="margin-top:0px;margin-bottom:20px;"><div class="fusion-column-wrapper"><p>

<img class="alignnone size-full wp-image-205" src="'.esc_url(plugins_url( "images/Auto_Scrape_Log.jpg", __FILE__ )).'" alt="Aut0 Scraper log" />

</p>
</div></div><div class="fusion-clearfix"></div><div class="fusion-sep-clear"></div>
<div class="fusion-separator fusion-full-width-sep sep-single" style="border-color:#e0dede;border-top-width:1px;margin-left: auto;margin-right: auto;margin-top:px;margin-bottom:30px;"></div>


<div class="fusion-full fusion-layout-column fusion-spacing-yes" style="margin-top:0px;margin-bottom:20px;"><div class="fusion-column-wrapper">

<p>WP Scraper Pro is intended solely for copying content that is in the public domain or other wise not protected by any copyright laws in any country.</p>
<p>Please obey the copyright laws of the country you are copying content from. Wp Scraper Pro does not assume any sort of legal responsibility or liability for the consequences of copying content that is protected under any copyright law of any country.</p>
<p>
For more information about copyright laws please visit
<a href="http://www.copyright.gov/">http://www.copyright.gov/</a>
.
</p><br>
<div class="fusion-clearfix"></div>
</div>
<a href="http://www.wpscraper.com/" target="_blank">For more information please visit us at wpscraper.com</a>
</div>
<div class="fusion-clearfix"></div>


';


}


function wpsf_post_tags_meta_box( $post, $box ) {
	$defaults = array( 'taxonomy' => 'post_tag' );
	if ( ! isset( $box['args'] ) || ! is_array( $box['args'] ) ) {
		$args = array();
	} else {
		$args = $box['args'];
	}
	$r = wp_parse_args( $args, $defaults );
	$tax_name = esc_attr( $r['taxonomy'] );
	$taxonomy = get_taxonomy( $r['taxonomy'] );
	$user_can_assign_terms = current_user_can( $taxonomy->cap->assign_terms );
	$comma = _x( ',', 'tag delimiter' );
?>
<div class="tagsdiv" id="<?php echo esc_attr($tax_name); ?>">
	<div class="jaxtag">
	<div class="nojs-tags hide-if-js">
	<p><?php echo esc_attr($taxonomy->labels->add_or_remove_items); ?></p>
	<textarea name="<?php echo esc_attr("tax_input-$tax_name"); ?>" rows="3" cols="20" class="the-tags" id="tax-input-
	<?php echo esc_attr($tax_name); ?>"
	<?php disabled( ! $user_can_assign_terms ); ?>>
	<?php if (isset($post->ID)) { echo esc_attr(str_replace( ',', $comma . ' ', get_terms_to_edit( $post->ID, $tax_name ) ));} else echo esc_attr(str_replace( ',', $comma . ' ', get_terms_to_edit( '', $tax_name ) )); // textarea_escaped by esc_attr() ?></textarea></div>
 	<?php if ( $user_can_assign_terms ) : ?>
	<div class="ajaxtag hide-if-no-js">
		<label class="screen-reader-text" for="new-tag-<?php echo esc_attr($tax_name); ?>"><?php echo esc_attr($box['title']); ?></label>
        <input class="wpsf-selector" type="text" name="tags_selector" value="" id="tags_selector" />
		<p><input type="text" id="new-tag-<?php echo esc_attr($tax_name); ?>" name="newtag-<?php echo esc_attr($tax_name); ?>" class="newtag form-input-tip" size="16" autocomplete="off" value="" />
		<input type="button" class="button tagadd" value="<?php esc_attr('Add'); ?>" /></p>
		<a id="choose_tags_content" title="Click to select content you want to use for the tags. Then click the button below to add it to the tags field. Remember to use a field that has comma separated values." href="#TB_inline?width=600&height=550&inlineId=content-extractor" class="thickbox button block-select-btn">Choose Tags</a>
	</div>
	<p class="howto"><?php echo esc_attr($taxonomy->labels->separate_items_with_commas); ?></p>
	<?php endif; ?>
	</div>
	<div class="tagchecklist"></div>
</div>
<?php if ( $user_can_assign_terms ) : ?>
<p class="hide-if-no-js"><a href="#titlediv" class="tagcloud-link" id="link-<?php echo esc_attr($tax_name); ?>"><?php echo esc_attr($taxonomy->labels->choose_from_most_used); ?></a></p>
<?php endif; ?>
<?php
}

function wpsf_post_categories_meta_box( $post, $box ) {
	$defaults = array( 'taxonomy' => 'category' );
	if ( ! isset( $box['args'] ) || ! is_array( $box['args'] ) ) {
		$args = array();
	} else {
		$args = $box['args'];
	}
	$r = wp_parse_args( $args, $defaults );
	$tax_name = esc_attr( $r['taxonomy'] );
	$taxonomy = get_taxonomy( $r['taxonomy'] );
	?>
	<div id="taxonomy-<?php echo esc_attr($tax_name); ?>" class="categorydiv">
    	<input class="wpsf-selector" type="text" name="cat_selector" value="" id="cat_selector" />
		<ul id="<?php echo esc_attr($tax_name); ?>-tabs" class="category-tabs">
			<li class="tabs"><a href="#<?php echo esc_attr($tax_name); ?>-all"><?php echo esc_attr($taxonomy->labels->all_items); ?></a></li>
			<li class="hide-if-no-js"><a href="#<?php echo esc_attr($tax_name); ?>-pop"><?php echo esc_attr( 'Most Used' ); ?></a></li>
		</ul>

		<div id="<?php echo esc_attr($tax_name); ?>-pop" class="tabs-panel" style="display: none;">
			<ul id="<?php echo esc_attr($tax_name); ?>checklist-pop" class="categorychecklist form-no-clear" >
				<?php $popular_ids = wp_popular_terms_checklist( $tax_name ); ?>
			</ul>
		</div>

		<div id="<?php echo esc_attr($tax_name); ?>-all" class="tabs-panel">
			<?php
            $name = ( $tax_name == 'category' ) ? 'post_category' : 'tax_input[' . $tax_name . ']';
            echo "<input id='post_category' type='hidden' name='".esc_attr($name)."[]' value='0' />"; // Allows for an empty term set to be sent. 0 is an invalid Term ID and will be ignored by empty() checks.
            ?>
			<ul id="<?php echo esc_attr($tax_name); ?>checklist" data-wp-lists="list:<?php echo esc_attr($tax_name); ?>" class="categorychecklist form-no-clear">
				<?php if (isset($post->ID)) { wp_terms_checklist( $post->ID, array( 'taxonomy' => $tax_name, 'popular_cats' => $popular_ids ) );} else wp_terms_checklist( '', array( 'taxonomy' => $tax_name, 'popular_cats' => $popular_ids ) );  ?>
			</ul>
		</div>
	<?php if ( current_user_can( $taxonomy->cap->edit_terms ) ) : ?>
			<div id="<?php echo esc_attr($tax_name); ?>-adder" class="wp-hidden-children">
				<h4>
					<a id="<?php echo esc_attr($tax_name); ?>-add-toggle" href="#<?php echo esc_attr($tax_name); ?>-add" class="hide-if-no-js">
						<?php
							/* translators: %s: add new taxonomy label */
							printf( esc_attr( '+ %s' ), esc_attr($taxonomy->labels->add_new_item) );
						?>
					</a>
				</h4>
				<p id="<?php echo esc_attr($tax_name); ?>-add" class="category-add wp-hidden-child">
					<label class="screen-reader-text" for="new<?php echo esc_attr($tax_name); ?>"><?php echo wp_kses_post($taxonomy->labels->add_new_item); ?></label>
					<input type="text" name="new<?php echo esc_attr($tax_name); ?>" id="new<?php echo esc_attr($tax_name); ?>" class="form-required form-input-tip" value="<?php echo esc_attr( $taxonomy->labels->new_item_name ); ?>" aria-required="true"/>
					<label class="screen-reader-text" for="new<?php echo esc_attr($tax_name); ?>_parent">
						<?php echo esc_attr($taxonomy->labels->parent_item_colon); ?>
					</label>
					<?php wp_dropdown_categories( array( 'taxonomy' => $tax_name, 'hide_empty' => 0, 'name' => 'new' . $tax_name . '_parent', 'orderby' => 'name', 'hierarchical' => 1, 'show_option_none' => '&mdash; ' . $taxonomy->labels->parent_item . ' &mdash;' ) ); ?>
					<input type="button" id="<?php echo esc_attr($tax_name); ?>-add-submit" data-wp-lists="add:<?php echo esc_attr($tax_name); ?>checklist:<?php echo esc_attr($tax_name); ?>-add" class="button category-add-submit" value="<?php echo esc_attr( $taxonomy->labels->add_new_item ); ?>" />

					<?php wp_nonce_field( 'add-' . $tax_name, '_ajax_nonce-add-' . $tax_name, false ); ?>
					<span id="<?php echo esc_attr($tax_name); ?>-ajax-response"></span>
				</p>
			</div>
		<?php endif; ?>
        <a id="choose_cat_content" title="Click to select content you want to use for the category. Then click the button below to add it to the categories field." href="#TB_inline?width=600&height=550&inlineId=content-extractor" class="thickbox button block-select-btn">Choose a New Category</a>
	</div>
	<?php
}

function wpsf_post_thumbnail_meta_box( $post ) {
	echo '<img class="wpsf_featured" src="" style="display:none" />
		<input class="wpsf-selector" type="text" name="fi_selector" value="" id="fi_selector" />
		<input id="wpsf_featured_image" type="hidden" name="featured_image" value="" />
		<p class="hide-if-no-js">
		<a id="set-featured-thumbnail" class="setfeatured" href="#" title="Set featured image">Set featured image</a>
		</p>
		<a id="choose_image_content" title="Click to select the image you want to use for the featured image. Then click the button below to add it to the featured image field." href="#TB_inline?width=600&height=550&inlineId=content-extractor" class="thickbox button block-select-btn">Choose a New Featured Image</a>';
	//echo _wp_post_thumbnail_html( $thumbnail_id, $post->ID );
}


add_action( 'wp_ajax_wpsf_custom_fields', 'wp_scraper_custom_fields');
function wp_scraper_custom_fields() {
	$post_type = get_post_type();

	$obj = get_post_type_object( $post_type );
	$title = post_type_supports($post_type, 'title');
	$editor = post_type_supports($post_type, 'editor');
	$thumbnail = post_type_supports($post_type, 'thumbnail');

	if ($post_type == 'post') { $tags = 1; $cat = 1; }
	else {$tags = 0; $cat = 0;}
	echo wp_kses_post($title.', '.$editor.', '.$thumbnail.', '.$tags.', '.$cat);
	//print('<pre>'.print_r($obj,true).'</pre>');
	die();
}
?>
