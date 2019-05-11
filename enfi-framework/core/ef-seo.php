<?php

 ## get post meta
 $meta_data = get_post_meta(get_the_id(), 'seo-meta-data', true);

 ## if null, set to empty array
 if(!is_array($meta_data))
     $meta_data = array();
 
 ## get seo option (+child)
 if(is_child_theme()) {
     $child_theme = get_stylesheet();
     $option_seo = get_option('seo-'.$child_theme);
 } else {
     $option_seo = get_option('seo');
 }


$disable_meta_tags = array(
    array( 'key' => 'description' ,'text' =>  __('Description', 'enfi'), 'value' => true),
    array( 'key' => 'keywords' ,'text' =>  __('Keywords', 'enfi'), 'value' => true),
    array( 'key' => 'topic' ,'text' =>  __('Topic', 'enfi'), 'value' => true),
    array( 'key' => 'web-author' ,'text' =>  __('Webpost Author Name', 'enfi'), 'value' => true),
    array( 'key' => 'web-author-email' ,'text' =>  __('Webpost Author Email', 'enfi'), 'value' => true),
    array( 'key' => 'web-designer' ,'text' =>  __('Designer', 'enfi'), 'value' => true),
    array( 'key' => 'copyright' ,'text' =>  __('Copyright', 'enfi'), 'value' => true)
);
 

$title_seperators = array(
    array( 'text' =>  '|', 'value' => '|'),
    array( 'text' =>  '-', 'value' => '-'),
    array( 'text' =>  '~', 'value' => '~'),
    array( 'text' =>  '+', 'value' => '+'),
    array( 'text' =>  '>', 'value' => '>'),
    array( 'text' =>  '<', 'value' => '<'),
    array( 'text' =>  ':', 'value' => ':'),
);

$title_sep = $option_seo['global-title-seperator'];
$title_style = array(
    array( 'text' =>  get_bloginfo('name').' '.$title_sep.' '.__('{Post name}', 'enfi'), 'value' => 'left'),
    array( 'text' =>  __('{Post name}', 'enfi').' '.$title_sep.' '.get_bloginfo('name'), 'value' => 'right'),
);

## add module page
$seo_page = new EF_Settings_Page('seo', __('Search Engine Optimization', 'enfi'), __('Search Engine Optimization', 'enfi'), __('Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.', 'enfi'), 'settings', 'fa-search-dollar', 2);

## settinfs for post type and other stuff
$seo_page->addSection('settings', __('Search Machine Optimization', 'enfi'));
$seo_page->addField('settings', 'post-types', __('Post Types', 'enfi'), null, 'checkbox-group', null, array( 'post_types' => get_post_types()));
$seo_page->addField('settings', 'no-index', __('No-Index', 'enfi'), null, 'checkbox', null, array('checkboxText' => __('No-Index', 'enfi')));

## global meta tags
$seo_page->addSection('seo-tags', __('Search Machine Optimization', 'enfi'));
$seo_page->addField('seo-tags', 'global-title-seperator', __('Title Seperator', 'enfi'), null, 'button-group', '|', array( 'options' => $title_seperators ));
$seo_page->addField('seo-tags', 'global-title-style', __('Title Seperator', 'enfi'), null, 'button-group', 'left', array( 'options' => $title_style ));
$seo_page->addField('seo-tags', 'global-keywords', __('Keywords', 'enfi'), null, 'text', null);
$seo_page->addField('seo-tags', 'global-description', __('Description', 'enfi'), null, 'text', null);
$seo_page->addField('seo-tags', 'global-topic', __('Topic', 'enfi'), null, 'text', null);
$seo_page->addField('seo-tags', 'global-author', __('Webpost Author Name', 'enfi'), null, 'text', 'Enrico Fischer');
$seo_page->addField('seo-tags', 'global-designer', __('Designer', 'enfi'), null, 'text', null);
$seo_page->addField('seo-tags', 'global-copyright', __('Copyright', 'enfi'), null, 'text', null);
$seo_page->addField('seo-tags', 'global-disable-seo-meta', __('Disable SEO Meta Tags', 'enfi'), null, 'checkbox-group', null, array( 'options' => $disable_meta_tags));

## set defaults
$seo_page->setDefaultValues();

## type options for "type" meta tag
$typeOptions = array(
    array( 'key' => 'movie', 'text' =>  __('Movie', 'enfi'), 'value' => 'movie'),
    array( 'key' => 'audio','text' =>  __('Audio', 'enfi'), 'value' => 'Audio'),
    array( 'key' => 'article','text' =>  __('Article', 'enfi'), 'value' => 'article'),
);

## get option data
$option_data = get_option('seo');

## enable for post types
if(array_key_exists('post-types', $option_data)) {
    
    ## get post types
    $post_types = $option_data['post-types'];   
 
    ## create meta box for post types
    $meta = new EF_Metabox('seo-meta-data', __('SEO', 'enfi'), $post_types);
    $meta->addField('seo-disable', __('Disable', 'enfi'), 'Aktivieren, um die Suchmaschinenoptimierung für diese Seite/Beitrag auszuschalten.', 'checkbox', array('checkboxText' => __('Disable SEO for this post', 'enfi')));
    $meta->addField('seo-no-index', __('No-Index', 'enfi'), 'Aktivieren, um Suchmaschinen davon abzuhalten, diesen Beitrag/Seite zu indexieren.', 'checkbox', array('checkboxText' => __('Stop search engines from crawling this post', 'enfi')));
    $meta->addField('seo-title', __('Post title', 'enfi'), __('Overwrite post title', 'enfi'), 'text');
    $meta->addField('seo-description', __('Post description', 'enfi'), __('Post description'), 'text');
    $meta->addField('seo-keywords', __('Keywords', 'enfi'), 'Keywörter für diesen Beitrag angeben', 'text');
    $meta->addField('seo-topic', __('Topic', 'enfi'), __('Topic', 'enfi'), 'text');
    $meta->addField('seo-author', __('Web Author Name', 'enfi'), __('Web Author', 'enfi'), 'text');
    $meta->addField('seo-designer', __('Webdesigner', 'enfi'), __('Webdesigner', 'enfi'), 'text');
    $meta->addField('seo-copyright', __('Copyright', 'enfi'), __('Copyright', 'enfi'), 'text');
    $meta->addField('seo-disable-seo-meta', __('Disable SEO Meta Tags', 'enfi'), __('Copyright', 'enfi'), 'checkbox-group', array( 'options' => $disable_meta_tags));
}

# is seo for post type active?
function check_post_type_enable() {

    if(is_child_theme()) {
        $child_theme = get_stylesheet();
        $option_seo = get_option('seo-'.$child_theme, array());
    } else {
        $option_seo = get_option('seo', array());
    }

    $post_type = get_post_type();

    if(array_key_exists('post-types', $option_seo) && is_array($option_seo['post-types']))
        return in_array($post_type, $option_seo['post-types']);

}

function check_post_enable() {

    $meta_data = get_post_meta(get_the_id(), 'seo-meta-data', true);

    if(array_key_exists('seo-disable', $meta_data))
        return false;
    else        
        return true;

}

function check_meta_tag_disable($global_disable_seo_meta, $key) {
    if(array_key_exists($key, $global_disable_seo_meta)) {
        return false;
    } else 
        return true;
}

function seo_add_wp_head() {

    if(check_post_type_enable() && check_post_enable()) {
        
        ## get post meta
        $meta_data = get_post_meta(get_the_id(), 'seo-meta-data', true);

        ## if null, set to empty array
        if(!is_array($meta_data))
            $meta_data = array();
        
        ## get seo option (+child)
        if(is_child_theme()) {
            $child_theme = get_stylesheet();
            $option_seo = get_option('seo-'.$child_theme);
        } else {
            $option_seo = get_option('seo');
        }

        ## check disable seo meta tags
        if(array_key_exists('global-disable-seo-meta', $option_seo))
            $global_disable_seo_meta = $option_seo['global-disable-seo-meta'];
        else 
            $global_disable_seo_meta = array();

        if(array_key_exists('seo-disable-seo-meta', $meta_data))
            $meta_disable_seo_meta = $meta_data['seo-disable-seo-meta'];
        else 
            $meta_disable_seo_meta = array();

        $meta_tags = array('keywords', 'description', 'topic', 'author', 'designer', 'copyright');

        ef_html_comment('SEO');

        if(isset($meta_data['seo-no-index']))
           echo "\t<meta name=\"robots\" content=\"noindex,nofollow\">\n";


        foreach($meta_tags as $meta_tag) {

            $meta = $meta_data['seo-'.$meta_tag];
            $options = $option_seo['global-'.$meta_tag];

            if(!(is_array($meta_disable_seo_meta) && array_key_exists($meta_tag, $meta_disable_seo_meta)) ) {
                if(!(is_array($global_disable_seo_meta) && array_key_exists($meta_tag, $global_disable_seo_meta)) ) {

                if($meta_tag == 'keywords') {

                    if($meta != "" && $options != "")
                        $meta .= ', '.$options;

                    if($meta) 
                        echo "\t<meta name=\"keywords\" content=\"".$meta."\"/>\n";
                    else if($options)
                        echo "\t<meta name=\"keywords\" content=\"".$options."\"/>\n";

                } else {

                    if($meta)
                        echo "\t<meta name=\"".$meta_tag."\" content=\"".$meta."\"/>\n";
                    else if($options)
                        echo "\t<meta name=\"".$meta_tag."\" content=\"".$options."\"/>\n";
                }

            }

            }
         
        }

    }

}

add_action('wp_head', 'seo_add_wp_head', -998);

## seo admin sidebar
function enfi_seo_sm_editor_sidebar() {
    wp_enqueue_script( 'ef-seo-sidebar', get_template_directory_uri().'/core/editor-sidebars/seo/seo-sidebar.js', array( 'wp-blocks', 'wp-edit-post', 'wp-element' ));
}
#add_action( 'enqueue_block_editor_assets', 'enfi_seo_sm_editor_sidebar' );

## title hook
function wpdocs_filter_wp_title( $title, $sep ) {
    global $paged, $page;
 
    if( is_front_page() || is_home()) 
        return get_bloginfo('name');

    if(is_archive())
        return post_type_archive_title('', true).' '.$sep.' ';;
    
 
    ## get post meta
    $meta_data = get_post_meta(get_the_id(), 'seo-meta-data', true);

    ## if null, set to empty array
    if(!is_array($meta_data)) 
        $meta_data = array();

    if(array_key_exists('seo-title', $meta_data) && $meta_data['seo-title'] != '') {
        return $meta_data['seo-title'].' '.$sep.' ';
    } else {
        return get_the_title().' '.$sep.' ';
    }
 
}
add_filter( 'wp_title', 'wpdocs_filter_wp_title', 10, 2 );


?>