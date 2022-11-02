<?php
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    error_reporting(E_ALL);
    require "includes/nav_sidebar.php";
    require "query/Queries.php";

    $query = new Queries();

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $total_income = $_POST['total_income'];
        $expand_name = $_POST['expand_name'];
        $expand_amount = $_POST['expand_amount'];
        $employee_expand_name = $_POST['employee_expand_name'];
        $employee_expand_amount = $_POST['employee_expand_amount'];
        //var_dump($employee_expand_name);
        //var_dump($employee_expand_amount);

        try {
            if(isset($total_income)){
                $data = [
                    'total_income' => $total_income
                ];
                $query->store('incomes', $data);
            };
            if(isset($expand_name) && isset($expand_amount)){
                for ($i=0; $i < count($expand_name) ; $i++) { 
                    $data = [
                        'reason' => $expand_name[$i],
                        'amount' => $expand_amount[$i]
                    ];
                    $query->store('expands', $data);
                };
            };
            if(isset($employee_expand_name) && isset($employee_expand_amount)){
                for ($i=0; $i < count($employee_expand_name) ; $i++) { 
                    $data = [
                        'employee_id' => $employee_expand_name[$i],
                        'amount' => $employee_expand_amount[$i]
                    ];
                    $query->store('employee_expands', $data);
                };
            }
        } catch (PDOException $e) {
           echo $e->getMessage();
        }
    }
?>


    <!-- Page content-->
    <div class="container-fluid">
        <div class="d-flex justify-content-center">
           <div class="my-5">
                <h3><b>ဝင်ငွေနှင့်အသုံးများ မှတ်ရန်</b></h3>

                <div class="mt-5">
                    <form action="#" method="post" class="form">
                        <div class="mb-3">
                            <label for="income" class="form-label">စုစုပေါင်း‌၀င်ငွေ</label>
                            <input type="number" id="total_income" name="total_income" class="form-control" placeholder="စုစုပေါင်း‌၀င်ငွေ" required>
                        </div>
                        <div class="mb-3">
                            <div class="row">
                                <div class="col">
                                    <label class="form-label">အသုံးများ</label>
                                </div>
                                <div class="col">
                                    <a class="btn btn-sm float-end expand_append" id="add_expand"><i data-feather="plus"></i></a>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col">
                                    <input type="text" class="form-control" name="expand_name[]" id="expand_name" placeholder="အသုံး">
                                </div>
                                <div class="col">
                                    <input type="number" name="expand_amount[]" id="expand_amount" class="form-control" placeholder="ပမာဏ">
                                </div>
                            </div>
                            <div id="expand_row">
                            
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="row">
                                <div class="col">
                                    <label class="form-label">၀န်ထမ်းများအသုံး</label>
                                </div>
                                <div class="col">
                                    <a class="btn float-end employee_append" id=""><i data-feather="plus"></i></a>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col">
                                <select class="form-select" name="employee_expand_name[]">
                                    <option selected>ရွေးချယ်ပါ....</option>
                                    <?php 
                                        $employees = $query->select('employees');
                                        //var_dump($employees);
                                        foreach ($employees as $employee){
                                    ?>
                                        <option value="<?php echo $employee['id']; ?>"><?php echo $employee['name']; ?></option>
                                    <?php
                                        }
                                    ?>
                                </select>
                                </div>
                                <div class="col">
                                    <input type="number" class="form-control" placeholder="ပမာဏ" name="employee_expand_amount[]">
                                </div>
                            </div>
                            <div id="employee_row">
                            
                            </div>
                            
                        </div>
                        <div class="d-grid gap-2 mt-4">
                            <button class="btn btn-outline-secondary" type="submit">သိမ်းမည်</button>
                        </div>
                    </form>
                </div>
           </div>
        </div>
    </div>

<?php 
    require "includes/footer.php";
?>