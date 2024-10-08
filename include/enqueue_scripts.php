<?php


/**
 * ===================================================
 *  Enqueue in backend admin area
 * ===================================================
 */
function ptreq_enqueue_script()
{
    // check post title

    global $pagenow,  $post_type;

    if ($pagenow == 'post-new.php' || $pagenow == 'post.php' || $pagenow == 'edit.php') {
        $allowed_post_types = (get_option('wp_title_require_post_types')) ?: [];
        if (in_array($post_type, $allowed_post_types) || count($allowed_post_types) === 0) {
            $js_file_path = plugin_dir_url(__FILE__)  . '../dist/js/post-title-required.js';
            wp_enqueue_script(
                'post-title-required-script',
                $js_file_path,
                array('jquery'),
                filemtime(get_stylesheet_directory($js_file_path)),
                array(
                    'in_footer' => true,
                    'strategy' => 'defer'
                )
            );
            $characterLimit = 100;
            $ptreq_character_limit = (int) get_option('ptreq_character_limit');
            if ($ptreq_character_limit) {
                $characterLimit = $ptreq_character_limit;
            }
            wp_localize_script('post-title-required-script', 'data_obj', [
                'ptreq_character_limit' => $characterLimit
            ]);
        }
    }
}
add_action('admin_enqueue_scripts', 'ptreq_enqueue_script');
