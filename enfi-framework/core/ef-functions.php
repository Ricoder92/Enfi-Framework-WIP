<?php

################################################################################################################################################## 
### html commentary
##################################################################################################################################################

function ef_html_comment($text) {
    echo "\n<!-- ############ ".$text." ############ --!>\n";
}

################################################################################################################################################## 
### get option
##################################################################################################################################################

function ef_get_option($string, $default = false) {

    if(is_child_theme()) {
        $child_theme = get_stylesheet();
        $option = get_option($string.'-'.$child_theme);
    } else {
        $option = get_option($string);
    }

    return $option;
}

################################################################################################################################################## 
### get meta
##################################################################################################################################################

function ef_get_meta($string, $single = false, $post_id = null) {

    if($post_id != null)
        $post_type = get_the_id();

    $option = get_post_meta($post_id, $string, $single);

    return $option;
}

################################################################################################################################################## 
### set/get child name
##################################################################################################################################################

function ef_get_child_name($string) {

    if(is_child_theme()) {
        $child_theme = get_stylesheet();
        $_return = $string.'-'.$child_theme;
    } else {
        $_return = $string;
    }

    return $_return;
}

################################################################################################################################################## 
### render logo
##################################################################################################################################################

function ef_render_logo() {
    if ( has_custom_logo() ) {
        echo the_custom_logo();
    } else {
        echo '<div onclick="location.href=\''.site_url().'\';">'.$logo_out = ''.get_bloginfo('name').'</div>';
    }
}

################################################################################################################################################## 
### copyright footer
##################################################################################################################################################

function ef_render_copyright() {
    echo '<div class="ef-footer-copyright">';
    echo bloginfo();
    echo ' '.date('Y'); 
    echo ' | ';
    _e('ALL_RIGHTS_RESERVED', 'ef');
    echo ' | ';
    _e('A_WEBSITE_BY_ENRICO_FISCHER', 'ef');
    echo '</div>';
}

function ef_get_type_of_post() {

    if(is_single()) 
        return 'post';
    else if(is_page()) 
        return 'page';
    else if(is_home()) 
        return 'post';
    else if(is_archive() & !is_tax()) 
        return get_query_var( 'post_type' );
    else if(is_tax()) 
        return get_query_var( 'taxonomy' );
    else 
        return null;
}

?>