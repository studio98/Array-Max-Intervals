<?php
// Require the Class
require 'array_max_intervals.php';

// One Dimensional Array
$sample_array_one = array(
	'red'
	, 'red'
	, 'blue'
	, 'blue'
	, 'blue'
	, 'green'
	, 'green'
	, 'purple'
	, 'purple'
	, 'purple'
	, 'purple'
);

// Create Multi-Dimensional array, much larger
$sample_array_base = array(
	'red' => 10
	, 'blue' => 7
	, 'green' => 15
	, 'purple' => 25
	, 'yellow' => 19
	, 'gold' => 1
	, 'silver' => 11
);

// Initialize variable
$sample_array_two = array();

// Create the second sample array
foreach ( $sample_array_base as $color => $count ) {
	for ( $i = 0; $i < $count; $i++ ) {
		$sample_array_two[] = array( 'color' => $color );
	}
}

/**
 * The array will look something like this:
 *
 * array( 
 *		array( 'color' => red )
 *		, array( 'color' => red )
 *		, array( 'color' => red )
 *		, array( 'color' => blue )
 *		, array( 'color' => green )
 *		, array( 'color' => green )
 *	)
 */

/***** Sort Arrays *****/
 
// One Dimensional
$sorted_array_one = new Array_Max_Intervals( $sample_array_one );

echo "<h1>One Dimensional</h1>\n\n";

// Print them out
print_r( $sorted_array_one->get_sorted_array() );

echo '<br /><hr /><br />';

// Multi-Dimensional
$sorted_array_two = new Array_Max_Intervals( $sample_array_two, 'color' );

echo "<h1>Multi-Dimensional</h1>n\n";

// Print them out
print_r( $sorted_array_two->get_sorted_array() );
