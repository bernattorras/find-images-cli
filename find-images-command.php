<?php
/**
 * Plugin Name: Find Images CLI Command
 * Description: Custom WP_CLI command to find the images provided in a txt file and export a CSV file with all the posts that contain these images.
 * Version: 1.0
 * Author: Your Name
 */

if ( defined( 'WP_CLI' ) && WP_CLI ) {
	require_once __DIR__ . '/class-find-images-command.php';
}
