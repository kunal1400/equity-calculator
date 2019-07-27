<div class="wrap">
<h2>Users Equity and Compensation Report</h2>
<?php 
if($results) {
	echo '<table class="widefat fixed" cellspacing="0" >';
		echo "<thead><tr>
				<th width='70'>S.No</th>					
				<th>First Name</th>
				<th>Last Name</th>
				<th>Email</th>
				<th>Action</th>
			</tr><thead>";
		echo "<tbody>";
	foreach ($results as $i => $result) {
		$data = $result['option_value'];
		$data = json_decode($data, ARRAY_A);

		// echo "<pre>";
		// print_r($data);
		// echo "</pre>";
		// // print_r($data);

		echo "<tr>";
		echo "<td>".($i+1)."</td>";
		echo "<td>".$data['userName']."</td>";
		echo "<td>".$data['userLName']."</td>";
		echo "<td>".$data['userEmail']."</td>";
		echo "<td><a href='javascript:void(0)' onclick='adminDownloadPdf(`".$data['userName']."`,`".$data['userLName']."`,`".$data['userEmail']."`, `".json_encode($data['dataToSend'])."`)'>Check Report</a></td>";
		echo "</tr>";
	}
	echo "<tbody>";
	echo '</table>';
}
?>
</div>