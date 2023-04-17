<?php
require 'database.php';

// current page number
function current_page() {
  if (isset($_GET['pageID']) && $_GET['pageID'] != '') {
      $currentPage = validate($_GET['pageID']);
  } else {
      $currentPage = 1;
  }
 return $currentPage;
}
// validate current page number
function validate($value) {
  $value = trim($value);
  $value = stripslashes($value);
  $value = htmlspecialchars($value);
  return $value;
}
// fetching padination data
function pagination_records($totalRecordsPerPage, $tableName, $order) {
   global $mysqli;
   $currentPage = current_page();
   $totalPreviousRecords = ($currentPage-1) * $totalRecordsPerPage;
   $query = $mysqli->prepare("SELECT * FROM " . $tableName . " ORDER BY id " . $order . " LIMIT ?, ?");
   $query->bind_param('ii', $totalPreviousRecords, $totalRecordsPerPage);
   $query->execute();
   $result = $query->get_result();
		if ($result->num_rows > 0 ) {
			$row = $result->fetch_all(MYSQLI_ASSOC);
			return $row;
		} else {
			return $row = [];
			}
}
// serial number of pagination content
function pagination_records_counter($totalRecordsPerPage) {
    $currentPage = current_page();
    $totalPreviousRecords = ($currentPage-1) * $totalRecordsPerPage;
    $dataCounter = $totalPreviousRecords + 1;
    return $dataCounter;
}
// back to previous page
function previous_page($urlDirPage) {
	$currentPage = current_page();
	$previousPage = $currentPage - 1;
		if ($currentPage > 1) {
			$previous = '<li class="page-item"><a class="page-link" href="' . $urlDirPage . $previousPage . '">Previous</a></li>'."\n";
			return $previous;
			}
}
// go to next page
function next_page($totalPages, $urlDirPage) {
	$currentPage = current_page();
	$nextPage = $currentPage + 1;
		if ($currentPage < $totalPages) {
			$next = '<li class="page-item"><a class="page-link" href="' . $urlDirPage . $nextPage . '">Next</a></li>'."\n";
			return $next;
			}
}
// diplaying total pagination numbers
function pagination_numbers($totalPages, $urlDirPage) {
	$currentPage = current_page();
	$adjacents = 2;
	$second_last = $totalPages - 1; // total pages minus 1
	$pagelink = '';
		if ($totalPages <= 5) {
			for ($counter = 1; $counter <= $totalPages; $counter++) {
				if ($counter == $currentPage) {
					$pagelink .= '<li class="page-item active"><a class="page-link">' . $counter . '</a></li>'."\n";
				} else {
					$pagelink .= '<li class="page-item"><a class="page-link" href="' . $urlDirPage . $counter . '">' . $counter . '</a></li>'."\n";
					}
			}
		} elseif ($totalPages > 5) {
			if ($currentPage <= 4) {
				for ($counter = 1; $counter < 8; $counter++) {
					if ($counter == $currentPage) {
						$pagelink .= '<li class="page-item active"><a class="page-link" href="' . $urlDirPage . $counter . '">' . $counter . '</a></li>'."\n";
					} else {
        				$pagelink .= '<li class="page-item"><a class="page-link" href="' . $urlDirPage . $counter . '">' . $counter . '</a></li>'."\n";
						}
			}
				$pagelink .= '<li class="page-item"><a class="page-link">...</a>'."\n";
				$pagelink .= '<li class="page-item"><a class="page-link" href="' . $urlDirPage . $second_last . '">' . $second_last . '</a></li>'."\n";
				$pagelink .= '<li class="page-item"><a class="page-link" href="' . $urlDirPage . $totalPages . '">' . $totalPages . '</a></li>'."\n";
			} elseif ($currentPage > 4 && $currentPage < $totalPages - 4) {
				$pagelink .= '<li class="page-item"><a class="page-link" href="' . $urlDirPage . '1">1</a></li>'."\n";
				$pagelink .= '<li class="page-item"><a class="page-link" href="' . $urlDirPage . '2">2</a></li>'."\n";
				$pagelink .= '<li class="page-item"><a class="page-link">...</a>'."\n";
					for ($counter = $currentPage - $adjacents; $counter <= $currentPage + $adjacents; $counter++) {
						if ($counter == $currentPage) {
							$pagelink .= '<li class="page-item active"><a class="page-link">' . $counter . '</a></li>'."\n";
						} else {
							$pagelink .= '<li class="page-item"><a class="page-link" href="' . $urlDirPage . $counter . '">' . $counter . '</a></li>'."\n";
							}
					}
				$pagelink .= '<li class="page-item"><a class="page-link">...</a></li>'."\n";
				$pagelink .= '<li class="page-item"><a class="page-link" href="' . $urlDirPage . $second_last . '">' . $second_last . '</a></li>'."\n";
				$pagelink .= '<li class="page-item"><a class="page-link" href="' . $urlDirPage . $totalPages . '">' . $totalPages . '</a></li>'."\n";
			} else {
				$pagelink .= '<li class="page-item"><a class="page-link" href="' . $urlDirPage . '1">1</a></li>'."\n";
				$pagelink .= '<li class="page-item"><a class="page-link" href="' . $urlDirPage . '2">2</a></li>'."\n";
				$pagelink .= '<li class="page-item"><a class="page-link">...</a></li>'."\n";
					for ($counter = $totalPages - 6; $counter <= $totalPages; $counter++) {
						if ($counter == $currentPage) {
							$pagelink .= '<li class="page-item active"><a class="page-link">' . $counter . '</a></li>'."\n";
						} else {
							$pagelink .= '<li class="page-item"><a class="page-link" href="' . $urlDirPage . $counter . '">' . $counter . '</a></li>'."\n";
							}
					}
			}
		} return $pagelink;
}
// final script to create pagination
function pagination($totalRecordsPerPage, $tableName, $urlDirPage) {
global $mysqli;
	$currentPage = current_page();
	$query = "SELECT * FROM " . $tableName;
	$result = $mysqli->query($query);

	$totalRecords = $result->num_rows;
	$totalPages = ceil($totalRecords / $totalRecordsPerPage);
	$pagination = '';
	$pagination .= previous_page($urlDirPage);
	$pagination .= pagination_numbers($totalPages, $urlDirPage);
	$pagination .= next_page($totalPages, $urlDirPage);
		return $pagination;
}
?>
