<?php include 'db_connect.php' ?>

<?php ?>

<div class="container-fluid">
	<form action="" id="employee-deduction">
		<input type="hidden" name="employee_id" value="<?php echo $_GET['id'] ?>">
		<div class="row form-group">
			<div class="col-md-5">
				<label for="" class="control-label">Potongan</label>
				<select id="deduction_id" class="borwser-default select2">
					<option value=""></option>
					<?php
					$deduction = $conn->query("SELECT * FROM deductions order by deduction asc");
					while ($row = $deduction->fetch_assoc()) :
					?>
						<option value="<?php echo $row['id'] ?>"><?php echo $row['deduction'] ?></option>
					<?php endwhile; ?>
				</select>
			</div>
			<div class="col-md-3">
				<label for="" class="control-label">Tipe</label>
				<select id="type" class="borwser-default custom-select">
					<option value="1">Bulanan</option>
					<option value="2">Mingguan</option>
					<!-- <option value="3">Once</option> -->
				</select>
			</div>
			<div class="col-md-3" id="dfield">
				<label for="" class="control-label">Tanggal Efektif</label>
				<input type="date" id="edate" class="form-control">
			</div>
		</div>
		<div class="row form-group">
			<div class="col-md-5">
				<label for="" class="control-label">Jumlah</label>
				<input type="number" id="amount" class="form-control" step="any">
			</div>
			<div class="col-md-2 offset-md-2">
				<label for="" class="control-label">&nbsp</label>
				<button class="btn btn-primary btn-block btn-sm" type="button" id="add_list"> Tambah</button>
			</div>
		</div>
		<hr>
		<div class="row">
			<table class="table table-bordered" id="deduction-list">
				<thead>
					<tr>
						<th class="text-center">
							Tunjangan
						</th>
						<th class="text-center">
							Tipe
						</th>
						<th class="text-center">
							Jumlah
						</th>
						<th class="text-center">
							Tanggal
						</th>
						<th class="text-center">

						</th>
					</tr>
				</thead>
				<tbody></tbody>
			</table>
		</div>
	</form>
</div>
<div id="tr_clone" style="display: none">
	<table>
		<tr>
			<td>
				<input type="hidden" name="deduction_id[]">
				<p class="deduction"></p>
			</td>
			<td>
				<input type="hidden" name="type[]">
				<p class="type"></p>
			</td>
			<td>
				<input type="hidden" name="amount[]">
				<p class="amount"></p>
			</td>
			<td>
				<input type="hidden" name="effective_date[]">
				<p class="edate"></p>
			</td>
			<td class="text-center">
				<button class="btn-sm btn-danger" type="button" onclick="$(this).closest('tr').remove()"><i class="fa fa-trash"></i></button>
			</td>
		</tr>
	</table>
</div>

<script>
	$('.select2').select2({
		placeholder: "Pilih disini",
		width: "100%"
	})
	$('#type').change(function() {
		if ($(this).val() == 3) {
			$('#dfield').show()
		} else {
			$('#dfield').hide()
		}
	})
	$('#add_list').click(function() {
		var deduction_id = $('#deduction_id').val(),
			type = $('#type').val(),
			amount = $('#amount').val(),
			edate = $('#edate').val();
		console

		var date = new Date(edate);
		var options = {
			year: 'numeric',
			month: 'long',
			day: 'numeric'
		};
		var formattedDate = date.toLocaleDateString('id-ID', options);

		var tr = $('#tr_clone tr').clone()
		tr.find('[name="deduction_id[]"]').val(deduction_id)
		tr.find('[name="type[]"]').val(type)
		tr.find('[name="effective_date[]"]').val(edate)
		tr.find('[name="amount[]"]').val(amount)
		tr.find('.deduction').html($('#deduction_id option[value="' + deduction_id + '"]').html())
		tr.find('.type').html($('#type option[value="' + type + '"]').html())
		tr.find('.amount').html(amount)
		tr.find('.edate').html(formattedDate); // Use formatted date
		$('#deduction-list tbody').append(tr)
		$('#deduction_id').val('').select2({
			placeholder: "Pilih disini",
			width: "100%"
		})
		$('#type').val('')
		$('#amount').val('')
		$('#edate').val('')

	})
	$(document).ready(function() {
		$('#employee-deduction').submit(function(e) {
			e.preventDefault()
			start_load();
			$.ajax({
				url: 'ajax.php?action=save_employee_deduction',
				method: "POST",
				data: $(this).serialize(),
				error: err => console.log(),
				success: function(resp) {
					if (resp == 1) {
						alert_toast("Data karyawan berhasi tersimpan", "success");
						end_load()
						uni_modal("Detail Karyawan", 'view_employee.php?id=<?php echo $_GET['id'] ?>', 'mid-large')
					}
				}
			})
		})
	})
</script>