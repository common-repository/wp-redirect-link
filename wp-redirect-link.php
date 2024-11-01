<?php
/*
Plugin Name: WP Redirect Link
Description: Change Link on content your post to redirect link.
Plugin URI: http://www.buidoi.net
Author: DinhQuocHan
Author URI: http://www.concuamap.com
Version: 1.2
License: GPL2
*/

/*

    Copyright (C) 2014  DinhQuocHan  dinhquochan.kayz@gmail.com

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

function wprlqdh_match_and_change_link( $content ){
    preg_match_all("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$content, $matches);

    foreach ($matches[0] as $url) {
        $v            = parse_url($url);
        $uri          = urlencode($url);
        $urlRedirect  = home_url( 'redirect.php?link=' . $uri , true );
        if($v['host'] != $_SERVER['SERVER_NAME']) 
            {
                $content = str_replace('href="'.$url, 'href="'.$urlRedirect, $content);
                $content = str_replace('href=\''.$url, 'href=\''.$urlRedirect, $content);
            }
    }
    return $content;
}

add_filter('the_content', 'wprlqdh_match_and_change_link' );


function wprlqdh_redirect_link(){

    if( isset( $_GET[ 'link' ] ) ) {
        $url = urldecode( $_GET[ 'link' ] );
        header('Status: 301 Moved Permanently', true, 301); 
        header("Location: $url");
        die();
    }

}

add_action('send_headers', 'wprlqdh_redirect_link' );
