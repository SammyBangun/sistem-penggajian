<style>
</style>
<nav id="sidebar" class='mx-lt-5 bg-primary'>

	<div class="sidebar-list">

		<a href="index.php?page=home" class="nav-item nav-home"><span class='icon-field'><i class="fa fa-home"></i></span> Home</a>
		<a href="index.php?page=attendance" class="nav-item nav-attendance"><span class='icon-field'><i class="fa fa-th-list"></i></span> List Kehadiran</a>
		<a href="index.php?page=payroll" class="nav-item nav-payroll"><span class='icon-field'><i class="fa fa-columns"></i></span> List Penggajian</a>


		<a href="index.php?page=employee" class="nav-item nav-employee"><span class='icon-field'><i class="fa fa-user-tie"></i></span> List Karyawan</a>


		<?php if ($_SESSION['login_type'] == 1) : ?>
			<a href="index.php?page=department" class="nav-item nav-department"><span class='icon-field'><i class="fa fa-columns"></i></span> List Departemen</a>
			<a href="index.php?page=position" class="nav-item nav-position"><span class='icon-field'><i class="fa fa-user-tie"></i></span> List Posisi</a>
		<?php endif ?>

		<?php if ($_SESSION['login_type'] == 2 || $_SESSION['login_type'] == 1) : ?>
			<a href="index.php?page=allowances" class="nav-item nav-allowances"><span class='icon-field'><i class="fa fa-list"></i></span> List Tunjangan</a>
			<a href="index.php?page=deductions" class="nav-item nav-deductions"><span class='icon-field'><i class="fa fa-money-bill-wave"></i></span> List Potongan</a>
		<?php endif; ?>

		<?php if ($_SESSION['login_type'] == 2 || $_SESSION['login_type'] == 1) : ?>
			<a href="index.php?page=users" class="nav-item nav-users"><span class='icon-field'><i class="fa fa-users"></i></span> List Pengguna</a>
		<?php endif; ?>
	</div>

</nav>
<script>
	$('.nav-<?php echo isset($_GET['page']) ? $_GET['page'] : '' ?>').addClass('active')
</script>