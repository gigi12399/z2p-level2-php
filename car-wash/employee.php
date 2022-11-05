<?php
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    error_reporting(E_ALL);
    require "includes/nav_sidebar.php";
    require "query/Queries.php";

    $queries = new Queries();
    $employees = $queries->select('employees', '*', null, 'deleted_at IS NULL', 'id DESC');
    //var_dump($employees);
    date_default_timezone_set('Asia/Yangon');
    $month = date('m');
    $date = date('Y-m-d');
    $employee_expands = $queries->select('employee_expands','employee_expands.*','employees ON employee_expands.employee_id = employees.id', "MONTH(employee_expands.created_at)='$month'");
    //var_dump($employee_expands);
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $employee_del_id = $_POST['employee_del'];
        $data = [
            'deleted_at' => $date
        ];
        $queries->update('employees', $data, 'id = '.$employee_del_id);
        header("location:employee.php");
    }
    
?>


    <!-- Page content-->
    <div class="container my-5">
        <div class="card">
            <div class="card-header">
                Employees Lists
                <a href="employee-add.php" class="btn btn-secondary btn-sm float-end"> <i data-feather="user-plus"></i></a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Name</th>
                                <th>Date of Birth</th>
                                <th>Salary</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $j = 1;
                                foreach($employees as $key=>$employee){
                                    $used_salary = 0;
                                    foreach($employee_expands as $employee_expand){
                                        if($employee_expand['employee_id'] == $employee['id']){
                                            $used_salary += $employee_expand['amount'];
                                        };
                                    };
                            ?>

                            <tr>
                                <td><?php echo $j++; ?></td>
                                <td><?php echo $employee['name']; ?></td>
                                <td><?php echo date('d-m-Y', strtotime($employee['dob'])); ?></td>
                                <td><?php echo $employee['salary']; ?></td>
                                <td>
                                    <a class="btn text-primary btn-sm detail" data-id="<?php echo $employee['id']; ?>" data-name="<?php echo $employee['name']; ?>" data-dob="<?php echo date('d.m.Y', strtotime($employee['dob'])); ?>" data-address="<?php echo $employee['address']; ?>" data-nrc="<?php echo $employee['nrc']; ?>" data-salary="<?php echo $employee['salary']; ?>" data-description="<?php echo $employee['description']; ?>" data-used="<?php echo $used_salary; ?>" data-bs-toggle="modal" data-bs-target="#exampleModal"> <i data-feather="info"></i></a>
                                    <a href="employee-edit.php?employee_id=<?php echo $employee['id']; ?>" class="btn text-warning btn-sm"> <i data-feather="edit"></i></a>
                                    <form action="#" method="POST" class="form d-inline">
                                        <button class="btn text-danger btn-sm" type="submit" onclick="return confirm('Are you sure to remove?');" name="employee_del" value="<?php echo $employee['id']; ?>">
                                            <i data-feather="trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>

                            <?php
                                }
                            ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>No.</th>
                                <th>Name</th>
                                <th>Date of Birth</th>
                                <th>Salary</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">အသေးစိတ်အချက်အလက်များ</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="d-flex justify-content-center">
                    <div class="col-8">
                        <div class="row">
                            <div class="col-6">
                                <p>အမည်</p>
                            </div>
                            <div class="col-6">
                                <p id="name"></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <p>မွေးနေ့</p>
                            </div>
                            <div class="col-6">
                                <p id="dob"></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <p>လိပ်စာ</p>
                            </div>
                            <div class="col-6">
                                <p id="address"></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <p>‌‌မှတ်ပုံတင်အမှတ်</p>
                            </div>
                            <div class="col-6">
                                <p id="nrc"></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <p>မှတ်ချက်</p>
                            </div>
                            <div class="col-6">
                                <p id="description"></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <p>လစာ</p>
                            </div>
                            <div class="col-6">
                                <p id="salary"></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <p>ကြိုသုံးလစာ</p>
                            </div>
                            <div class="col-6">
                                <p id="expand_salary"></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <p>ကျန်လစာ</p>
                            </div>
                            <div class="col-6">
                                <p id="net_salary"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ပိတ်မည်</button>
            </div>
            </div>
        </div>
    </div>

<?php 
    require "includes/footer.php";
?>