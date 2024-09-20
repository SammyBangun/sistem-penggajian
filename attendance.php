<?php include('db_connect.php') ?>
<div class="container-fluid ">
	<div class="col-lg-12">
		<br />
		<br />
		<div class="card">
			<div class="card-header">
				<span><b>List Kehadiran</b></span>
				<button class="btn btn-primary btn-sm btn-block col-md-3 float-right" type="button" id="new_attendance_btn"><span class="fa fa-plus"></span>Tambah Kehadiran</button>
			</div>
			<div class="card-body">
				<table id="table" class="table table-bordered table-striped">
					<colgroup>
						<col width="10%">
						<col width="20%">
						<col width="30%">
						<col width="30%">
						<col width="10%">
					</colgroup>
					<thead>
						<tr>
							<th>Tanggal</th>
							<th>ID Karyawan</th>
							<th>Nama</th>
							<th>Catatan Waktu</th>
							<th>Aksi</th>
						</tr>
					</thead>
					<tbody>
						<?php
						// Inisialisasi variabel $attendance sebagai array kosong
						$attendance = array();

						$att = $conn->query("SELECT a.*, e.employee_no, e.firstname as ename FROM attendance a INNER JOIN employee e ON a.employee_id = e.id ORDER BY UNIX_TIMESTAMP(datetime_log) ASC") or die(mysqli_error($conn));
						$lt_arr = array(1 => "Waktu Masuk", 2 => "Waktu Selesai");
						while ($row = $att->fetch_array()) {
							$date = date("d-m-Y", strtotime($row['datetime_log']));
							$attendance[$row['employee_id'] . "_" . $date]['details'] = array("eid" => $row['employee_id'], "name" => $row['ename'], "eno" => $row['employee_no'], "date" => $date);
							if ($row['log_type'] == 1) {
								if (!isset($attendance[$row['employee_id'] . "_" . $date]['log'][$row['log_type']]))
									$attendance[$row['employee_id'] . "_" . $date]['log'][$row['log_type']] = array('id' => $row['id'], "date" =>  $row['datetime_log']);
							} else {
								$attendance[$row['employee_id'] . "_" . $date]['log'][$row['log_type']] = array('id' => $row['id'], "date" =>  $row['datetime_log']);
							}
						}
						foreach ($attendance as $key => $value) {
						?>
							<tr>
								<td><?php echo date("d M, Y", strtotime($attendance[$key]['details']['date'])) ?></td>
								<td><?php echo $attendance[$key]['details']['eno'] ?></td>
								<td><?php echo $attendance[$key]['details']['name'] ?></td>
								<td>
									<div class="row">
										<?php
										$att_ids = array();
										foreach ($attendance[$key]['log'] as $k => $v) :
										?>
											<div class="col-sm-6">
												<p>
													<small><b><?php echo $lt_arr[$k] . ": <br/>" ?>
															<?php echo (date("H:i", strtotime($attendance[$key]['log'][$k]['date'])))  ?> </b>
														<span class="badge badge-danger rem_att" data-id="<?php echo $attendance[$key]['log'][$k]['id'] ?>"><i class="fa fa-trash"></i></span>
													</small>
												</p>
											</div>
										<?php endforeach; ?>
									</div>
								</td>
								<td>
									<center>
										<button class="btn btn-sm btn-outline-danger remove_attendance" data-id="<?php echo $key ?>" type="button"><i class="fa fa-trash"></i></button>
									</center>
								</td>
							</tr>
						<?php
						}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<style>
	td p {
		margin: unset;
	}

	.rem_att {
		cursor: pointer;
	}
</style>

<script type="text/javascript">
	// $(document).ready(function() {
	//  $('#table').DataTable();
	// });
</script>
<script type="text/javascript">
	$(document).ready(function() {
		$('.edit_attendance').click(function() {
			var $id = $(this).attr('data-id');
			uni_modal("Edit Karyawan", "manage_attendance.php?id=" + $id)
		});
		$('.view_attendance').click(function() {
			var $id = $(this).attr('data-id');
			uni_modal("Detail Karyawan", "view_attendance.php?id=" + $id, "mid-large")
		});
		$('#new_attendance_btn').click(function() {
			uni_modal("Catatan waktu baru", "manage_attendance.php", 'mid-large')
		})
		$('.remove_attendance').click(function() {
			var d = '"' + ($(this).attr('data-id')).toString() + '"';
			_conf("Apakah kamu yakin ingin menghapus data kehadiran ini ?", "remove_attendance", [d])
		})
		$('.rem_att').click(function() {
			var $id = $(this).attr('data-id');
			_conf("Apakah kamu yakin ingin menghapus catatan waktu ?", "rem_att", [$id])
		})
	});

	function remove_attendance(id) {
		// console.log(id)
		// return false;
		start_load()
		$.ajax({
			url: 'ajax.php?action=delete_employee_attendance',
			method: "POST",
			data: {
				id: id
			},
			error: err => console.log(err),
			success: function(resp) {
				if (resp == 1) {
					alert_toast("Data catatan waktu karyawan berhasil dihapus", "success");
					setTimeout(function() {
						location.reload();
					}, 1000)
				}
			}
		})
	}

	function rem_att(id) {
		start_load()
		$.ajax({
			url: 'ajax.php?action=delete_employee_attendance_single',
			method: "POST",
			data: {
				id: id
			},
			error: err => console.log(err),
			success: function(resp) {
				if (resp == 1) {
					alert_toast("Data catatan waktu karyawan berhasil dihapus", "success");
					setTimeout(function() {
						location.reload();
					}, 1000)
				}
			}
		})
	}
</script>