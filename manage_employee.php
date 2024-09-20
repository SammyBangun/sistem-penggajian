<?php
include 'db_connect.php';
if (isset($_GET['id'])) {
	$qry = $conn->query("SELECT * FROM employee where id = " . $_GET['id'])->fetch_array();
	foreach ($qry as $k => $v) {
		$$k = $v;
	}
}
?>

<div class="container-fluid">
	<form id='employee_frm'>
		<div class="form-group">
			<label>Nama</label>
			<input type="hidden" name="id" value="<?php echo isset($id) ? $id : "" ?>" />
			<input type="text" name="firstname" required="required" class="form-control" value="<?php echo isset($firstname) ? $firstname : "" ?>" />
		</div>
		<div class="form-group">
			<label>Departmen</label>
			<select class="custom-select browser-default select2" name="department_id">
				<option value=""></option>
				<?php
				$dept = $conn->query("SELECT * from department order by name asc");
				while ($row = $dept->fetch_assoc()) :
				?>
					<option value="<?php echo $row['id'] ?>" <?php echo isset($department_id) && $department_id == $row['id'] ? "selected" : "" ?>><?php echo $row['name'] ?></option>
				<?php endwhile; ?>
			</select>
		</div>
		<div class="form-group">
			<label>Posisi</label>
			<select class="custom-select browser-default select2" name="position_id">
				<option value=""></option>
				<?php
				$pos = $conn->query("SELECT * from position order by name asc");
				while ($row = $pos->fetch_assoc()) :
				?>
					<option class="opt" value="<?php echo $row['id'] ?>" data-did="<?php echo $row['department_id'] ?>" <?php echo isset($department_id) && $department_id == $row['department_id'] ? '' : "disabled" ?> <?php echo isset($position_id) && $position_id == $row['id'] ? " selected" : '' ?>><?php echo $row['name'] ?></option>
				<?php endwhile; ?>
			</select>
		</div>
		<div class="form-group">
			<label>Gaji</label>
			<input type="number" name="salary" required="required" class="form-control" step="any" value="<?php echo isset($salary) ? $salary : "" ?>" />
		</div>
		<div class="form-group">
			<label>Bank</label>
			<input type="text" name="bank" required="required" class="form-control" value="<?php echo isset($bank) ? $bank : "" ?>" />
		</div>
		<div class="form-group">
			<label>No Rekening</label>
			<input type="text" name="bank_account" required="required" class="form-control" value="<?php echo isset($bank_account) ? $bank_account : "" ?>" />
		</div>
	</form>
</div>
<script>
	$('[name="department_id"]').change(function() {
		var did = $(this).val()
		$('[name="position_id"] .opt').each(function() {
			if ($(this).attr('data-did') == did) {
				$(this).attr('disabled', false)
			} else {
				$(this).attr('disabled', true)
			}
		})
	})
	$(document).ready(function() {
		$('.select2').select2({
			placeholder: "Pilih disini",
			width: "100%"
		})
		$('#employee_frm').submit(function(e) {
			e.preventDefault()
			start_load();
			$.ajax({
				url: 'ajax.php?action=save_employee',
				method: "POST",
				data: $(this).serialize(),
				error: err => console.log(err),
				success: function(resp) {
					if (resp == 1) {
						alert_toast("Data karyawan berhasil disimpan", "success");
						setTimeout(function() {
							location.reload();

						}, 1000)
					}
				}
			})
		})
	})
</script>