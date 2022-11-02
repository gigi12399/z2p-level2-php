<?php
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    error_reporting(E_ALL);
    require "includes/nav_sidebar.php";
    require "query/Queries.php";

    $queries = new Queries();
    $employees = $queries->select('employees', '*', null, null, 'id DESC');
    //var_dump($employees);
?>


    <!-- Page content-->
    <div class="container my-5">
        <div class="card">
            <div class="card-header">
                Employees Lists
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
                                foreach($employees as $employee){
                            ?>

                            <tr>
                                <td><?php echo $j++; ?></td>
                                <td><?php echo $employee['name']; ?></td>
                                <td><?php echo $employee['dob']; ?></td>
                                <td><?php echo $employee['salary']; ?></td>
                                <td>
                                    <a class="btn text-primary btn-sm"> <i data-feather="info"></i></a>
                                    <a class="btn text-warning btn-sm"> <i data-feather="edit"></i></a>
                                    <a class="btn text-danger btn-sm"> <i data-feather="trash"></i></a>
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

<?php 
    require "includes/footer.php";
?>