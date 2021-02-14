<?php
// From https://github.com/humanmade/S3-Uploads#custom-endpoints

// Filter S3 Uploads params.
add_filter( 's3_uploads_s3_client_params', function ( $params ) {
	$params['endpoint'] = sprintf('http://%s:%d', getenv('AWS_HOST'), getenv('AWS_PORT'));
	$params['use_path_style_endpoint'] = true;
	$params['debug'] = boolval(getenv('AWS_DEBUG')); // Set to true if uploads are failing.
	return $params;
} );