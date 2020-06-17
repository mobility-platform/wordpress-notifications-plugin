<?php

/**
 * Operations of the plugin are included here. 
 *
 * @since 1.0
 */

/** Create notifications when a post is published */
function mobility_platform_get_access_token()
{
    $settings = get_option('mpn_settings');
    if (!$settings) {
        error_log('Failed to get client settings');
        return FALSE;
    }

    $content = @file_get_contents($settings["domain"], false, stream_context_create([
        'http' => [
            'method' => 'POST',
            'header' => "Content-Type: application/json\r\n",
            'content' => json_encode([
                'client_id' => $settings["client_id"],
                'client_secret' => $settings["client_secret"],
                'audience' => 'https://mobility-platform.michelin.com/',
                'grant_type' => 'client_credentials'
            ])
        ]
    ]));

    if ($content === FALSE) {
        return FALSE;
    }
    $token = json_decode($content)->access_token;
    return $token;
}

function mobility_platform_transition_post_status(string $new_status, string $old_status, WP_Post $post)
{
    if ($new_status !== 'publish' || $old_status === 'publish') {
        return;
    }

    $settings = get_option('mpn_settings');
    if (!$settings["client_id"] || !$settings["client_secret"] || !$settings["domain"] || !$settings["notifications_api"]) {
        error_log('`client_id`, `client_secret`, `domain`, `notifications_api` are required for Mobility Platform notifications push');
        return;
    }

    $token = mobility_platform_get_access_token();
    if ($token === FALSE) {
        error_log('Failed to retrieve access token');
        return;
    }

    if (!get_site_icon_url() || !get_bloginfo('name')) {
        error_log("Your Wordpress site don't have any favicon or name");
    }

    $language = get_bloginfo('language');
    if (function_exists('pll_get_post_language')) {
        $language = pll_get_post_language($post->ID);
    }
    $language = preg_split('/-/', $language)[0];

    $content = @file_get_contents($settings["notifications_api"], false, stream_context_create([
        'http' => [
            'method' => 'POST',
            'header' => "Authorization: Bearer $token\r\n" . "Content-Type: application/json\r\n",
            'content' => json_encode([
                'title' => get_bloginfo('name'),
                'body' => esc_html(get_the_title($post)),
                'icon' => get_site_icon_url(),
                'language' => $language,
                'target' => get_permalink($post)
            ])
        ]
    ]));

    if ($content === FALSE) {
        error_log("Failed to send notification for post $post->ID");
    }
}

// Exit if accessed directly
if (!defined('ABSPATH')) exit;
