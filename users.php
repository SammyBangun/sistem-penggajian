<?php

?>

<div class="container-fluid">

	<div class="row">
		<div class="col-lg-12">
			<button class="btn btn-primary float-right btn-sm" id="new_user"><i class="fa fa-plus"></i> Tambah Pengguna</button>
		</div>
	</div>
	<br>
	<div class="row">
		<div class="card col-lg-12">
			<div class="card-body">
				<table class="table-striped table-bordered col-md-12">
					<thead>
						<tr>
							<th class="text-center">#</th>
							<th class="text-center">Nama</th>
							<th class="text-center">Username</th>
							<th class="text-center">Aksi</th>
						</tr>
					</thead>
					<tbody>
						<?php
						include 'db_connect.php';
						$users = $conn->query("SELECT * FROM users WHERE username != 'own123' order by name asc");
						$i = 1;
						while ($row = $users->fetch_assoc()) :
						?>
							<tr>
								<td>
									<?php echo $i++ ?>
								</td>
								<td>
									<?php echo $row['name'] ?>
								</td>
								<td>
									<?php echo $row['username'] ?>
								</td>
								<td>
									<center>
										<div class="btn-group">
											<button type="button" class="btn btn-primary">Aksi</button>
											<button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
												<span class="sr-only">Toggle Dropdown</span>
											</button>
											<div class="dropdown-menu">
												<a class="dropdown-item edit_user" href="javascript:void(0)" data-id='<?php echo $row['id'] ?>'>Edit</a>
												<div class="dropdown-divider"></div>
												<a class="dropdown-item delete_user" href="javascript:void(0)" data-id='<?php echo $row['id'] ?>'>Hapus</a>
											</div>
										</div>
									</center>
								</td>
							</tr>
						<?php endwhile; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>

</div>
<script>
	$('#new_user').click(function() {
		uni_modal('Pengguna Baru', 'manage_user.php')
	})
	$('.edit_user').click(function() {
		uni_modal('Edit Pengguna', 'manage_user.php?id=' + $(this).attr('data-id'))
	})
	$('.delete_user').click(function() {
		_conf("Apakah kamu yakin ingin menghapusnya ?", "delete_user", [$(this).attr('data-id')])
	})



	function delete_user($id) {
		start_load()
		$.ajax({
			url: 'ajax.php?action=delete_user',
			method: 'POST',
			data: {
				id: $id
			},
			success: function(resp) {
				if (resp == 1) {
					alert_toast("Data berhasil dihapus", 'success')
					setTimeout(function() {
						location.reload()
					}, 1500)

				}
			}
		})
	}
</script>