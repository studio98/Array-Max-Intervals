class Array_Max_Intervals {
    /**
     * Variables
     * Arrays
     */
    private $sorted_array;
    private $groups;

    /**
     * Hold the key
     * @var null|string
     */
    private $key;
    private $original_key;

    /**
     * Total Count
     * @var int
     */
    private $total_count;

    /**
     * The current item for sorting
     * @var int
     */
    private $current_item = 0;

    /**
     * Construct
     *
     * @param array $array
     * @param string $key [optional]
     */
    public function __construct( array $array, $key = NULL ) {
        // Make sure it's a valid array
        if ( 0 == count( $array ) )
            return false;

        // Remember the keys
        $this->original_key = $this->key = $key;

        // Make sure the array is in the right style
        $formatted_array = $this->_validate( $array );

        // Calculate
        $this->_calculate( $formatted_array );

        // Sort the arrays
        $this->_sort();
    }

    /**
     * Get the sorted array and return the proper values
     *
     * @return array
     */
    public function get_sorted_array() {
        $sorted_array = $this->sorted_array;

        if ( is_null( $this->original_key ) ) {
            $new_array = array();

            foreach ( $sorted_array as $array ) {
                $new_array[] = $array[$this->key];
            }

            $sorted_array = $new_array;
        }

        return $sorted_array;
    }

    /**
     * Sort the array
     */
    private function _sort() {
        $sorted_array = array();

        // Go for as long as we can
        while ( 1 ) {
            $item = $this->_determine_item();

            if ( is_null( $item ) || !$item )
                break;

            // Add to the array
            $sorted_array[] = $item;

            // Up the current item
            $this->current_item++;
        }

        $this->sorted_array = $sorted_array;
    }

    /**
     * Determine the proper item to go next
     *
     * @return array
     */
    private function _determine_item() {
        $highest_priority = NULL;
        $highest_priority_group = NULL;

        foreach ( $this->groups as $key => $group ) {
            // Make sure we have a valid set of groups -- if there is nothing left, get rid of it
            if ( 0 == $group->count() ) {
                unset( $this->groups[$key] );
                continue;
            }

            // Get the groups priority
            $priority = $group->priority( $this->current_item );

            // Whoever has the highest priority wins
            if ( is_null( $highest_priority ) || $priority > $highest_priority ) {
                $highest_priority = $priority;
                $highest_priority_group = $group;
            }
        }

        // Return the last item
        return ( is_null( $highest_priority_group ) ) ? NULL : $highest_priority_group->get_item( $this->current_item );
    }

    /**
     * Calculate and bunch the array into duplicates
     *
     * @param array $formatted_array
     * @return bool
     */
    private function _calculate( $formatted_array ) {
        $this->total_count = count( $formatted_array );

        $groups = array();

        // Bunch them
        foreach ( $formatted_array as $item ) {
            $value = $item[$this->key];

            if ( !is_object( $groups[$value] ) )
                $groups[$value] = new Array_Group( $this->total_count );

            $groups[$value]->add_item( $item );
        }

        // Set the groups
        $this->groups = $groups;
    }

    /**
     * Ensure that the array is the right style
     *
     * @param array $original_array
     * @return array
     */
    private function _validate( $original_array ) {
        // If they have a key, we're fine
        if ( !is_null( $this->key ) )
            return $original_array;

        // They don't have a key, lets assign them one
        $this->key = 'key';
        $new_array = array();

        foreach ( $original_array as $value ) {
            $new_array[] = array( $this->key => $value );
        }

        return $new_array;
    }
}

/**
 * Array Group Class
 *
 */
class Array_Group {
    /**
     * Hold the items
     * @var array
     */
    private $items;

    /**
     * Last Used number
     * @var null|int
     */
    private $last_used = NULL;

    /**
     * The frequency in which this group should be inserted
     * @var null|int
     */
    private $frequency = NULL;

    /**
     * Initation of group
     *
     * @param int $total_count
     */
    public function __construct( $total_count ) {
        $this->total_count = $total_count;
    }

    /**
     * Add Item
     *
     * @param array $item
     */
    public function add_item( $item ) {
        $this->items[] = $item;
    }

    /**
     * Get Item
     *
     * @param int $current_number
     * @return array
     */
    public function get_item( $current_number ) {
        // Set the last used
        $this->last_used = $current_number;

        return array_shift( $this->items );
    }

    /**
     * Count the item
     *
     * @return int
     */
    public function count() {
        return count( $this->items );
    }

    /**
     * Priority
     *
     * Determines the priority based on Current Number - Last Used Number - Frequency
     *
     * @param int $current_number
     * @return int
     */
    public function priority( $current_number ) {
        $separation = $current_number - $this->last_used;
        $frequency = $this->_frequency();

        // We can't have it less than the frequency
        if ( !is_null( $this->last_used ) && $separation < $frequency )
            return -2147483647; // Longest PHP Integer - making this the absolute lowest priority PHP can handle

        return $separation - $frequency;
    }

    /**
     * Frequency
     *
     * @return int
     */
    private function _frequency() {
        if ( !is_null( $this->frequency ) )
            return $this->frequency;

        $this->frequency = $this->total_count / count( $this->items );

        return $this->frequency;
    }
}
?>