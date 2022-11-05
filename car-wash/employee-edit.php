<?php
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    error_reporting(E_ALL);
    require "includes/nav_sidebar.php";
    require "query/Queries.php";

    $employee_id = $_GET['employee_id'];

    $queries = new Queries();
    $employee = $queries->select('employees', '*', null, 'id = '.$employee_id, null, '1');
    //var_dump($employee);

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $new_employee_name = $_POST['name'];
        $new_employee_dob = $_POST['dob'];
        $new_employee_address = $_POST['address'];
        $new_employee_nrc = $_POST['nrc'];
        $new_employee_salary = $_POST['salary'];
        $new_employee_description = $_POST['description'];
        $query = new Queries();
        $new_employee = [
            'name' => $new_employee_name,
            'dob' => $new_employee_dob,
            'address' => $new_employee_address,
            'nrc' => $new_employee_nrc,
            'salary' => $new_employee_salary,
            'description' => $new_employee_description
        ];

        $query->update('employees', $new_employee, 'id = '.$employee_id);
        header("location:employee.php");
    }
     
    
    
?>


    <!-- Page content-->
    <div class="container my-5">
        <div class="row">
            <div class="d-flex justify-content-center">
                <div class="col-6">
                    <div class="row">
                        <h4 class="text-secondary text-center">ဝန်ထမ်းအချက်အလက်ပြင်ရန်</h4>
                    </div>
                    <form action="#" method="POST" class="form">
                        <div class="row mt-3">
                            <div class="col-6">
                                <label for="name" class="form-label">အမည်</label>
                                <input type="text" class="form-control" id="name" name="name" value="<?php echo $employee['name']; ?>">
                            </div>
                            <div class="col-6">
                                <label for="dob" class="form-label">မွေးနေ့</label>
                                <input type="date" class="form-control" id="dob" name="dob" value="<?php echo $employee['dob']; ?>">
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-6">
                                <label for="address" class="form-label">လိပ်စာ</label>
                                <input type="text" class="form-control" id="address" name="address" value="<?php echo $employee['address']; ?>">
                            </div>
                            <div class="col-6">
                                <label for="nrc" class="form-label">‌‌မှတ်ပုံတင်အမှတ်</label>
                                <input type="text" class="form-control" id="nrc" name="nrc" value="<?php echo $employee['nrc']; ?>">
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-6">
                                <label for="salary" class="form-label">လစာ</label>
                                <input type="number" class="form-control" id="salary" name="salary" value="<?php echo $employee['salary']; ?>">
                            </div>
                            <div class="col-6">
                                <label for="description" class="form-label">မှတ်ချက်</label>
                                <input type="text" class="form-control" id="description" name="description" value="<?php echo $employee['description']; ?>">
                            </div>
                        </div>
                        <div class="mt-3">
                        <div class="d-grid gap-2 mt-4">
                            <button class="btn btn-outline-secondary" type="submit">ပြင်မည်</button>
                        </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

<?php 
    require "includes/footer.php";
?>