<?php include("db_connect.php"); ?>
<?php
// Mengambil parameter $id dari request jika belum didefinisikan
if (!isset($id)) {
	$id = $_GET['id'];
}

$date = explode('_', $id);
$lt_arr = array(1 => "Waktu Masuk", 2 => "Waktu Selesai");
$dt = date("Y-m-d", strtotime($date[1]));
$emp_query = $conn->query("SELECT firstname as ename, employee_no FROM employee WHERE id = " . $date[0]);
$emp = $emp_query->fetch_array();
$qry = $conn->query("SELECT * FROM attendance WHERE employee_id = '" . $date[0] . "' AND date(datetime_log) ='$dt' ORDER BY UNIX_TIMESTAMP(datetime_log) ASC");

$att = array();  // Inisialisasi array $att untuk menyimpan data kehadiran
while ($row = $qry->fetch_assoc()) {
	if ($row['log_type'] == 1 || $row['log_type'] == 2) {
		$att[$row['log_type']] = $row;
	}
}
?>
<div class="container-fluid">
	<div class="col-ld-12">
		<div class="row">
			<h4><b><?php echo ucwords($emp['ename']) . ' | ' . $emp['employee_no'] ?></b></h4>
		</div>
		<hr>
		<?php foreach ($att as $k => $v) : ?>
			<div class="row">
				<p><b><?php echo $lt_arr[$k] ?></b></p>
			</div>
			<hr>
			<div class="row form-group">
				<div class="col-md-4">
					<?php echo date("H:i", strtotime($v['datetime_log'])); ?>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
</div>

<style>
	#uni_modal .modal-header {
		display: none
	}
</style>