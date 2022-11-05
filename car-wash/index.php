<?php
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    error_reporting(E_ALL);
    require "includes/nav_sidebar.php";
    require "query/Queries.php";
    $query = new Queries();
    date_default_timezone_set('Asia/Yangon');
    $month = date('m');
    $income = $query->select('incomes', '*', null, "MONTH(created_at)='$month'", null);
    //var_dump($income);

    $expands = $query->select('expands', '*', null, "MONTH(created_at)='$month'");
    //var_dump($expands);

    $employee_expands = $query->select('employee_expands', 'employee_expands.*, employees.name as e_name', 'employees ON employee_expands.employee_id = employees.id', "MONTH(employee_expands.created_at)='$month'");
?>


    <!-- Page content-->
    <div class="container-fluid">
        <div class="row">
            <div class="d-flex justify-content-center">
                <div class="col-6">
                    <div class="row mt-5">
                        <h5 class="text-center text-secondary mb-3">စုစုပေါင်း‌ဝင်ငွေ</h5>
                    </div>
                    <div class="row mt-3">
                        <form action="view-data.php" method="GET" class="form">
                        <input type="date" class="form-control" name="income_date">
                        <div class="d-grid gap-2 mt-4">
                            <button class="btn btn-outline-secondary" type="submit">ကြည့်မည်</button>
                        </div>
                        </form>
                    </div>
                    <hr>
                    <div class="row mt-4">
                    <h5 class="text-center text-secondary mb-5">ဝင်ငွေနှင့်အသုံးများ</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>နေ့</th>
                                        <th>ရငွေ</th>
                                        <th>ကျန်ငွေ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        foreach ($income as $i) {
                                            $income_date = date('Y-m-d', strtotime($i['created_at']));
                                            $net_income = $i['total_income'];
                                            foreach($expands as $expand){
                                                if((date('Y-m-d', strtotime($expand['created_at']))) == $income_date){
                                                    $net_income -= $expand['amount'];
                                                };
                                            };
                                            foreach($employee_expands as $employee_expand){
                                                if((date('Y-m-d', strtotime($employee_expand['created_at']))) == $income_date){
                                                    $net_income -= $employee_expand['amount'];
                                                };
                                            };
                                    ?>
                                    <tr>
                                        <td><a href="view-data.php?income_date=<?php echo $income_date; ?>"><?php echo date('d.m.Y', strtotime($i['created_at'])); ?></a></td>
                                        <td><?php echo $i['total_income']; ?></td>
                                        <td><?php echo $net_income; ?></td>
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
        </div>
    </div>

<?php 
    require "includes/footer.php";
?>
            
