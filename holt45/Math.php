<?php
namespace w3l\Holt45;

trait Math
{
	/**
	 * Create range for pagination
	 *
	 * @param int $totalPages
	 * @param int $selectedPage
	 * @param int $numberOfResults
	 * @return array Array with all page-numbers limited by $number_of_results
	 */
	public static function generatePaginationRange($totalPages, $selectedPage = 1, $numberOfResults = 7) {

		// Get the numbers
		$tempArrayRange = range(1, $totalPages);
		
		if($totalPages <= $numberOfResults) {
			// all
			$arrayData = $tempArrayRange;
		} elseif($selectedPage <= (round(($numberOfResults / 2), 0, PHP_ROUND_HALF_UP))) {
			// 1-6+last
			$arrayData = array_slice($tempArrayRange, 0, ($numberOfResults-1));
			$arrayData[] = $totalPages;
			
		} elseif($selectedPage >= $totalPages-round(($numberOfResults / 2), 0, PHP_ROUND_HALF_DOWN)) {
			// first + $totalPages-5 - $totalPages
			$arrayData = array_slice($tempArrayRange, $totalPages-($numberOfResults-1));
			$arrayData[] = 1;
		} else {
			// first + $totalPages-2 - $totalPages+2 + last
			$arrayData = array_slice(
									$tempArrayRange,
									$selectedPage-(round(($numberOfResults / 2), 0, PHP_ROUND_HALF_DOWN)), 
									($numberOfResults-2)
									);
			$arrayData[] = 1;
			$arrayData[] = $totalPages;
			
		}
		
		sort($arrayData);
		
		return $arrayData;
		
	}

}
