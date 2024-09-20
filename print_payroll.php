<style>
    body {
        font-family: Arial, sans-serif;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    tr,
    td,
    th {
        border: 1px solid #ccc;
        padding: 8px;
    }

    th {
        background-color: #f2f2f2;
        font-weight: bold;
        text-align: center;
    }

    .text-center {
        text-align: center;
    }

    .text-right {
        text-align: right;
    }

    .header {
        margin-bottom: 20px;
        text-align: center;
    }

    .header h2 {
        margin: 5px 0;
        color: #333;
    }

    .header p {
        margin: 5px 0;
        color: #666;
    }

    .total-row {
        font-weight: bold;
        background-color: #f9f9f9;
    }
</style>

<?php include('db_connect.php') ?>
<?php
$pay = $conn->query("SELECT * FROM payroll where id = " . $_GET['id'])->fetch_array();
$pt = array(1 => "Bulanan", 2 => "Mingguan");
?>
<div>
    <h2 class="text-center">Penggajian - <?php echo $pay['ref_no'] ?></h2>
    <p>Kisaran Penggajian: <b><?php echo date("d M Y", strtotime($pay['date_from'])) . " - " . date("d M Y", strtotime($pay['date_to'])) ?></b></p>
    <hr>
</div>
<table>
    <thead>
        <tr>
            <th class="text-center">ID Karyawan</th>
            <th class="text-center">Nama Karyawan</th>
            <th class="text-center">Bank</th>
            <th class="text-center">No Rekening</th>
            <th class="text-center">Gaji Bulanan</th>
            <!-- <th class="text-center">Absent</th>
            <th class="text-center">Tardy/Undertime(mins)</th> -->
            <th class="text-center">Total Tunjangan</th>
            <th class="text-center">Total Potongan</th>
            <th class="text-center">Gaji Bersih</th>
        </tr>
    </thead>
    <tbody>
        <?php

        $payroll = $conn->query("SELECT p.*, e.firstname as ename,e.employee_no,e.bank, e.bank_account, e.salary FROM payroll_items p inner join employee e on e.id = p.employee_id ") or die(mysqli_error($conn));
        while ($row = $payroll->fetch_array()) {
        ?>
            <tr>
                <td><?php echo $row['employee_no'] ?></td>
                <td><?php echo ucwords($row['ename']) ?></td>
                <td><?php echo ucwords($row['bank']) ?></td>
                <td><?php echo ucwords($row['bank_account']) ?></td>
                <td class="text-right"><?php echo number_format($row['salary'], 2) ?></td>
                <td class="text-right"><?php echo number_format($row['allowance_amount'], 2) ?></td>
                <td class="text-right"><?php echo number_format($row['deduction_amount'], 2) ?></td>
                <td class="text-right"><?php echo number_format($row['net'], 2) ?></td>
            </tr>
        <?php
        }
        ?>
    </tbody>
</table>