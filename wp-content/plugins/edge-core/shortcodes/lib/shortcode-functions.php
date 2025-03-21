<?php

if(!function_exists('eldritch_edge_remove_auto_ptag')) {
	function eldritch_edge_remove_auto_ptag($content, $autop = false) {
        if($autop) {
            $content = preg_replace('#^<\/p>|<p>$#', '', $content);
        }

        return do_shortcode($content);
	}
}