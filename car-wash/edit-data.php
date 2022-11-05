<?php
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    error_reporting(E_ALL);
    require "includes/nav_sidebar.php";
    require "query/Queries.php";

    $get_income_date = $_GET['income_date'];
    
    //var_dump($get_income_date);
    $query = new Queries();

    $income = $query->select('incomes', '*', null, "DATE(created_at)='$get_income_date'", null, '1');
    //var_dump($income);

    
    $income_date = date('d.m.Y', strtotime($income['created_at']));

    $expands = $query->select('expands', '*', null, "DATE(created_at)='$get_income_date'");
    //var_dump($expands);

    $employee_expands = $query->select('employee_expands', 'employee_expands.*, employees.name as e_name', 'employees ON employee_expands.employee_id = employees.id', "DATE(employee_expands.created_at)='$get_income_date'");
    //var_dump($employee_expands);

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $total_income = $_POST['total_income'];
        $income_id = $_POST['income_id'];
        $expand_id = $_POST['expand_id'];
        $expand_name = $_POST['expand_name'];
        $expand_amount = $_POST['expand_amount'];
        $employee_expand_id = $_POST['employee_expand_id'];
        $employee_expand_name = $_POST['employee_expand_name'];
        $employee_expand_amount = $_POST['employee_expand_amount'];
        //var_dump($income_id);
        //var_dump($employee_expand_amount);

        try {
            if(isset($total_income)){
                $data = [
                    'total_income' => $total_income
                ];
                $query->update('incomes', $data,'id = '.$income_id);
            };
            if(isset($expand_name) && isset($expand_amount)){
                for ($i=0; $i < count($expand_name) ; $i++) { 
                    if($expand_id[$i]){
                        $data = [
                            'reason' => $expand_name[$i],
                            'amount' => $expand_amount[$i]
                        ];
                        $query->update('expands', $data, 'id = '.$expand_id[$i]);
                    }else{
                        $data = [
                            'reason' => $expand_name[$i],
                            'amount' => $expand_amount[$i],
                            'created_at' => $get_income_date
                        ];
                        $query->store('expands', $data);
                    }
                    
                };
            };
            if(isset($employee_expand_name) && isset($employee_expand_amount)){
                for ($i=0; $i < count($employee_expand_name) ; $i++) { 
                    if($employee_expand_id[$i]){
                        $data = [
                            'employee_id' => $employee_expand_name[$i],
                            'amount' => $employee_expand_amount[$i]
                        ];
                        $query->update('employee_expands', $data, 'id = '.$employee_expand_id[$i]);
                    }else{
                        $data = [
                            'employee_id' => $employee_expand_name[$i],
                            'amount' => $employee_expand_amount[$i],
                            'created_at' => $get_income_date
                        ];
                        $query->store('employee_expands', $data);
                    }
                    
                };
            };

            
            $income = $query->select('incomes', '*', null, "DATE(created_at)='$get_income_date'", null, '1');
            $income_date_str = strtotime($income['created_at']);
            $income_date = date("Y-m-d", $income_date_str);
            header("location:view-data.php?income_date=$income_date");
            if($_POST['expand_del']){
                $id = $_POST['expand_del'];
                $query->delete('expands','id = '.$id);

                header("location:".$_SERVER['HTTP_REFERER']);
            };
            if($_POST['employee_expand_del']){
                $id = $_POST['employee_expand_del'];
                $query->delete('employee_expands', 'id = '.$id);

                header("location:".$_SERVER['HTTP_REFERER']);
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
                <h3><b>ဝင်ငွေနှင့်အသုံးများ ပြင်ရန်</b></h3>

                <div class="mt-5">
                    <form action="#" method="post" class="form">
                        <div class="mb-3">
                            <label for="income" class="form-label">စုစုပေါင်း‌၀င်ငွေ</label>
                            <input type="hidden" value="<?php echo $income['id'] ?>" name="income_id">
                            <input type="number" value="<?php echo $income['total_income'] ?>" id="total_income" name="total_income" class="form-control" placeholder="စုစုပေါင်း‌၀င်ငွေ" required>
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
                            <?php 
                                foreach ($expands as $expand) {
                                
                            ?>
                            <div class="row mb-3">
                                <div class="col">
                                    <input type="hidden" name="expand_id[]" value="<?php echo $expand['id'] ?>">
                                    <input type="text" value="<?php echo $expand['reason'] ?>" class="form-control" name="expand_name[]" id="expand_name" placeholder="အသုံး">
                                </div>
                                <div class="col">
                                    <div class="input-group mb-3">
                                        <input type="number" value="<?php echo $expand['amount'] ?>" name="expand_amount[]" id="expand_amount" class="form-control" placeholder="ပမာဏ">
                                        <button name="expand_del" value="<?php echo $expand['id'] ?>" class="btn btn-outline-secondary" type="submit" id="button-addon2" onclick="return confirm('Are yoe sure to remove');">X</button>
                                    </div>
                                </div>
                            </div>
                            <?php 
                                }
                            ?>
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
                            <?php 
                                foreach ($employee_expands as $employee_expand) {
                                
                            ?>
                            <div class="row mb-3">
                                <div class="col">
                                <input type="hidden" name="employee_expand_id[]" value="<?php echo $employee_expand['id']; ?>">
                                <select class="form-select" name="employee_expand_name[]">
                                    <option selected>ရွေးချယ်ပါ....</option>
                                    <?php 
                                        $employees = $query->select('employees', '*', null, "deleted_at IS NULL");
                                        //var_dump($employees);
                                        foreach ($employees as $employee){
                                    ?>
                                        <option value="<?php echo $employee['id']; ?>" <?php if($employee_expand['employee_id'] == $employee['id']){echo 'selected';} ?> ><?php echo $employee['name']; ?></option>
                                    <?php
                                        }
                                    ?>
                                </select>
                                </div>
                                <div class="col">
                                    <div class="input-group mb-3">
                                    <input type="number" value="<?php echo $employee_expand['amount']; ?>" class="form-control" placeholder="ပမာဏ" name="employee_expand_amount[]">
                                        <button name="employee_expand_del" value="<?php echo $employee_expand['id'] ?>" class="btn btn-outline-secondary" type="submit" id="button-addon2" onclick="return confirm('Are yoe sure to remove');">X</button>
                                    </div>
                                    
                                </div>
                            </div>
                            <?php 
                                }
                            ?>
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