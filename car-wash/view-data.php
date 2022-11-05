<?php
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    error_reporting(E_ALL);
    require "includes/nav_sidebar.php";
    include "query/Queries.php";

    
    $get_income_date = $_GET['income_date'];
        
    
    //var_dump($get_income_date);
    $query = new Queries();

    $income = $query->select('incomes', '*', null, "DATE(created_at)='$get_income_date'", null, '1');
    //var_dump($income);

    if($income){
    $income_date = date('d.m.Y', strtotime($income['created_at']));

    $expands = $query->select('expands', '*', null, "DATE(created_at)='$get_income_date'");
    //var_dump($expands);

    $employee_expands = $query->select('employee_expands', 'employee_expands.*, employees.name as e_name', 'employees ON employee_expands.employee_id = employees.id', "DATE(employee_expands.created_at)='$get_income_date'");
?>


    <!-- Page content-->
    <div class="container">
        <div class="row">
        <div class="d-flex justify-content-center">
            <div class="col-6">
                <div class="row text-center mt-3">
                    <h6 class="text-secondary"><?php echo $income_date; ?> ရက်နေ့</h6>
                    <h6 class="text-secondary">ဝင်ငွေနှင့်အသုံးများ</h6>
                </div>
                <div class="row text-center mt-3">
                    <div class="col-6">
                        <p>စုစုပေါင်း‌ဝင်ငွေ</p>
                    </div>
                    <div class="col-6">
                        <p><?php echo $income['total_income']; ?> ကျပ်</p>
                    </div>
                </div>
                <div class="row text-center">
                    <div class="col-6">
                    <p><b>အသုံးများ</b></p>
                    </div>
                </div>
                <?php 
                    $total_expand = 0;
                    foreach($expands as $expand){
                    $total_expand += $expand['amount'];
                ?>
                <div class="row text-center">
                    <div class="col-6">
                        <p><?php echo $expand['reason']; ?></p>
                    </div>
                    <div class="col-6">
                    <p><?php echo $expand['amount']; ?> ကျပ်</p>
                    </div>
                </div>
                <?php 
                    }
                ?>
                <div class="row text-center">
                    <div class="col-6">
                    <p><b>‌ဝန်ထမ်းများအသုံးများ</b></p>
                    </div>
                </div>
                <?php 
                //$total_employee_expand = 0;
                    foreach ($employee_expands as $employee_expand) {
                        $total_expand += $employee_expand['amount'];
                ?>
                <div class="row text-center">
                    <div class="col-6">
                        <p><?php echo $employee_expand['e_name']; ?></p>
                    </div>
                    <div class="col-6">
                        <p><?php echo $employee_expand['amount']; ?> ကျပ်</p>
                    </div>
                </div>
                <?php 
                    }
                ?>
                <hr>
                <div class="row text-center">
                    <div class="col-6">
                        <p>စုစုပေါင်း‌ဝင်ငွေ</p>
                    </div>
                    <div class="col-6">
                        <p><?php echo $income['total_income']; ?> ကျပ်</p>
                    </div>
                </div>
                <div class="row text-center">
                    <div class="col-6">
                        <p>စုစုပေါင်းအသုံး</p>
                    </div>
                    <div class="col-6">
                        <p><?php echo $total_expand; ?> ကျပ်</p>
                    </div>
                </div>
                <hr>
                <div class="row text-center">
                    <div class="col-6">
                        <p>စုစုပေါင်းကျန်ငွေ</p>
                    </div>
                    <div class="col-6">
                        <p><b><?php echo $income['total_income'] - $total_expand; ?> ကျပ်</b></p>
                    </div>
                </div>
                <div class="row">
                    <div class="d-grid gap-2 mt-4">
                        <a href="edit-data.php?income_date=<?php echo $get_income_date; ?>" class="btn btn-outline-secondary">ပြင်မည်</a>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>


<?php 
    }else{
?>
        <div class="row mt-5">
            <div class="d-flex justify-content-center">
                <div class="col-10 mt-5">
                    <h4 class="text-secondary text-center mt-5"><?php echo date('d.m.Y', strtotime($get_income_date)); ?> ရက်နေ့အတွက် ဝင်ငွေနှင့်အသုံးများစာရင်း မရှိသေးပါ။</h4>
                </div>
            </div>
        </div>
<?php
    }
    require "includes/footer.php";
?>