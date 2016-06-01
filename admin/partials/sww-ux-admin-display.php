<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://inside.sas.com
 * @since      1.0.0
 *
 * @package    Sww_Ux
 * @subpackage Sww_Ux/admin/partials
 */
?>

<h1>UX Testing Responses: Results</h1>

<?php
$tasks = array();
$meta = get_option( $this->key );
if ( isset( $meta ) ) {
    $tasklist = $meta['_ux_test_group'];
    $size = count( $tasklist );
    if ( isset( $tasklist ) ) {
        foreach ( $tasklist as $key => $value ) {
            $index = $key + 1;
            if ( $index == $size ) {
                $prefix = 'FINAL TASK: ';
            } else {
                $prefix = 'Task ' . $index . ': ';
            }
            $tasks[] = $prefix . $value['task'];
        }
    }
}

$args = array(
    'posts_per_page' => -1,
    'order_by' => 'date',
    'order' => 'DESC',
    'post_type' => 'ux-reporting',
    'post_status' => array( 'any' )
);
$users = get_posts( $args );
$url = array();
$easy = array();
$expect = array();
$postlink = array();
foreach( $users as $key => $user ) {
    $postlink[$key] = 'post.php?post=' . $user->ID . '&action=edit';
    $meta = get_post_meta( $user->ID );
    $responses = maybe_unserialize( $meta['_sww_ux_repeat_group'][0] );
    foreach ( $responses as $key2 => $response ) {
        if ( isset( $response['submitted_where'] ) ) $url[$key2][$key] = $response['submitted_where'];
        if ( isset( $response['submitted_easy'] ) ) $easy[$key2][$key] = $response['submitted_easy'];
        if ( isset( $response['submitted_expect'] ) ) $expect[$key2][$key] = $response['submitted_expect'];
    }
}

foreach( $tasks as $key => $task ) {
    echo '<h3 class="clear-all">' . $task . '</h3>';
    echo '<div class="response-set">';
    echo '<h4>Where did you find this information?</h4>';
    if ( isset( $url[$key] ) ) {
        echo '<p>';
        foreach( $url[$key] as $key2 => $value ) {
            echo sprintf('<a href="%s">%d: %s</a>', $postlink[$key2], $key2 + 1, $value );
        }
        echo '</p>';
    }
    echo '</div>';
    echo '<div class="response-set">';
    echo '<h4>Was it easy or difficult to find this information?</h4>';
    if ( isset( $easy[$key] ) ) {
        echo '<p>';
        foreach( $easy[$key] as $key2 => $value ) {
            echo sprintf('<a href="%s">%d: %s</a>', $postlink[$key2], $key2 + 1, $value );
        }
        echo '</p>';
    }
    echo '</div>';
    echo '<div class="response-set">';
    echo '<h4>Was the information where you expected it to be? If not, where did you expect to find it?</h4>';
    if ( isset( $expect[$key] ) ) {
        echo '<p>';
        foreach( $expect[$key] as $key2 => $value ) {
            echo sprintf('<a href="%s">%d: %s</a>', $postlink[$key2], $key2 + 1, $value );
        }
        echo '</p>';
    }
    echo '</div>';
}


?>
