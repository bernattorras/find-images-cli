<?php
if ( ! class_exists( 'WP_CLI' ) ) {
	return;
}

/**
 * Find images in posts/pages/custom post types and generate CSV.
 *
 * @when after_wp_load
 */
class Find_Images_Command {
	/**
	 * Find images in the database and generate CSV.
	 *
	 * ## OPTIONS
	 *
	 * <file>
	 * : Path to the text file containing image names.
	 *
	 * @param array $args Command arguments.
	 * @param array $assoc_args Command associative arguments.
	 */
	public function __invoke( $args, $assoc_args ) {
		list( $file_path ) = $args;

		if ( ! file_exists( $file_path ) ) {
			WP_CLI::error( "File not found: $file_path" );
		}

		$image_names = file( $file_path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES );

		$result = array();

		foreach ( $image_names as $image_name ) {
			$posts_with_image = $this->get_posts_with_image( $image_name );

			foreach ( $posts_with_image as $post ) {
				$result[] = array( 'image_name' => $image_name, 'post_url' => get_permalink( $post->ID ) );
			}
		}

		if ( empty( $result ) ) {
			WP_CLI::success( 'No matching images found in the database.' );
			return;
		}

		$csv_file_path = dirname( $file_path ) . '/found_images.csv';

		$file_handle = fopen( $csv_file_path, 'w' );
		fputcsv( $file_handle, array( 'Image Name', 'Post URL' ) );

		foreach ( $result as $row ) {
			fputcsv( $file_handle, $row );
		}

		fclose( $file_handle );

		WP_CLI::success( "CSV file generated: $csv_file_path" );
	}

	/**
	 * Get posts containing the given image name.
	 *
	 * @param string $image_name Image name.
	 * @return array Array of posts.
	 */
	private function get_posts_with_image( $image_name ) {
		global $wpdb;
		
		$query = $wpdb->prepare(
			"SELECT p.ID 
			FROM $wpdb->posts p 
			WHERE p.post_type IN ('page', 'post', 'product') 
				AND p.post_content LIKE %s",
			'%' . $wpdb->esc_like( $image_name ) . '%'
		);

		$post_ids = $wpdb->get_col( $query );

		return array_map( 'get_post', $post_ids );
	}
}

	WP_CLI::add_command( 'find-images', 'Find_Images_Command' );
