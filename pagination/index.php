<?php
require_once 'pagination_function.php';

$sortOrder = 'DESC';
$tableName = 'video';
$totalRecordsPerPage = 10;
$urlPage = 'index.php?pageID=';
$paginationData = pagination_records($totalRecordsPerPage, $tableName, $sortOrder);
$pagination = pagination($totalRecordsPerPage, $tableName, $urlPage);
?>

<div class="">
<?php
foreach ($paginationData as $row) { ?>
<div class="galleryVideo" style="border:1px solid red; clear:both; margin-bottom:10px">
<h5><?php echo $row['title_video'];?></h5><br>
<p><?php echo $row['url_video'];?></p>
</div>
<?php
}
?>
</div>

<!-- pagination start -->
<ul class="pagination">
<?php echo $pagination; ?>
</ul>
<!-- pagination end -->
