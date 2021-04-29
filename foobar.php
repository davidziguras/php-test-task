<?php
$limit = 100;
for ($i=1;$i<=$limit;$i++) {
	if ($i % 3 == 0) {
		echo 'foo';
	}
	if ($i % 5 == 0) {
		echo 'bar';
	}
	if ($i % 3 != 0 && $i % 5 != 0) {
		echo $i;	
	}
	if ($i < $limit) {
		echo ', ';	
	}
}
echo "\n";
?>