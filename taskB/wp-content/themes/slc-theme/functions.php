<?php
/**
 * Theme functions and definitions
 */

// GraphQL endpoint configuration
// Prefer PROD for reliability in this demo, since local networking is flakey on Windows
define('GRAPHQL_ENDPOINT_LOCAL', 'https://clubs.iiit.ac.in/graphql'); 
// define('GRAPHQL_ENDPOINT_LOCAL', 'http://services-nginx-1/graphql');
define('GRAPHQL_ENDPOINT_PROD', 'https://clubs.iiit.ac.in/graphql');

/**
 * Fetch data from GraphQL endpoint
 */
function fetch_graphql($query, $variables = []) {
    $data = json_encode([
        'query' => $query,
        'variables' => (object)$variables
    ]);

    $lastError = 'Unknown error';
    foreach ([GRAPHQL_ENDPOINT_LOCAL, GRAPHQL_ENDPOINT_PROD] as $endpoint) {
        $ch = curl_init($endpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data)
        ]);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);

        $result = curl_exec($ch);
        $error = curl_error($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($result !== false && $httpCode == 200) {
            $decoded = json_decode($result, true);
            if (isset($decoded['errors'])) {
                $lastError = $decoded['errors'][0]['message'];
                continue; // Try next endpoint
            }
            return $decoded;
        }
        if ($error) {
            $lastError = "Curl: $error (Code $httpCode)";
        }
    }

    return ['error' => 'Failed to connect. Last Error: ' . $lastError];
}

/**
 * Get all clubs
 */
function get_clubs() {
    $query = 'query ActiveClubs { allClubs(onlyActive: true) { cid name category } }';
    $result = fetch_graphql($query);
    
    if (isset($result['error'])) {
        return ['error' => $result['error']]; // Return the error to the frontend
    }
    
    // Check for GraphQL errors
    if (isset($result['errors'])) {
        return ['error' => $result['errors'][0]['message']];
    }
    
    return $result['data']['allClubs'] ?? [];
}

/**
 * Get all events
 */
function get_events($limit = 20) {
    $query = 'query Events($limit: Int) { events(limit: $limit) { _id name clubid datetimeperiod location mode } }';
    $result = fetch_graphql($query, ['limit' => $limit]);
    
    if (isset($result['error'])) {
        return ['error' => $result['error']];
    }
    
    if (isset($result['errors'])) {
        return ['error' => $result['errors'][0]['message']];
    }
    
    return $result['data']['events'] ?? [];
}

/**
 * Register theme support
 */
function slc_theme_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
}
add_action('after_setup_theme', 'slc_theme_setup');

/**
 * Enqueue scripts and styles
 */
function slc_theme_scripts() {
    wp_enqueue_style('slc-style', get_stylesheet_uri());
}
add_action('wp_enqueue_scripts', 'slc_theme_scripts');

/**
 * Custom page templates
 */
function slc_add_rewrite_rules() {
    add_rewrite_rule('^clubs/?$', 'index.php?clubs_page=1', 'top');
    add_rewrite_rule('^events/?$', 'index.php?events_page=1', 'top');
}
add_action('init', 'slc_add_rewrite_rules');

function slc_query_vars($vars) {
    $vars[] = 'clubs_page';
    $vars[] = 'events_page';
    return $vars;
}
add_filter('query_vars', 'slc_query_vars');

function slc_template_redirect() {
    if (get_query_var('clubs_page')) {
        include(get_template_directory() . '/page-clubs.php');
        exit;
    }
    if (get_query_var('events_page')) {
        include(get_template_directory() . '/page-events.php');
        exit;
    }
}
add_action('template_redirect', 'slc_template_redirect');
