Array-Max-Intervals
===================

Creates the maximum possible intervals between identical/duplicate array elements

-------------------

Example Usage:

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

	// One Dimensional
	$sorted_array_one = new Array_Max_Intervals( $sample_array_one );

	echo "<h1>One Dimensional</h1>\n\n";

	// Print them out
	print_r( $sorted_array_one->get_sorted_array() );

The result will be:

	// One Dimensional Array
	$sample_array_one = array(
		'purple'
		, 'blue'
		, 'red'
		, 'purple'
		, 'green'
		, 'blue'
		, 'purple'
		, 'red'
		, 'blue'
		, 'purple'
		, 'green'
	);

For a multi-dimensional array example, see **example.php**.