</div>
        </div>
        <!-- jquery -->
        <script src="js/jquery.min.js"></script>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
        <!-- feather icon  -->
        <script>
            feather.replace();
            $(document).ready(function(){
                $('.expand_append').on('click', function(){
                    let expand_row = `<div class="row mb-3">
                                <div class="col">
                                    <input type="text" class="form-control" placeholder="အသုံး" name="expand_name[]" id="expand_name">
                                </div>
                                <div class="col">
                                    <input type="number" class="form-control" placeholder="ပမာဏ" name="expand_amount[]" id="expand_amount">
                                </div>
                            </div>`;
                    $('#expand_row').append(expand_row);
                });
                $('.employee_append').on('click', function(){
                    let employee_row = `<div class="row mb-3">
                                <div class="col">
                                <select class="form-select" name="employee_expand_name[]">
                                    <option selected>ရွေးချယ်ပါ....</option>
                                    <?php 
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
                            </div>`;
                    $('#employee_row').append(employee_row);
                });
                $('.detail').on('click', function(){
                    let employee_id = $(this).data('id');
                    let employee_name = $(this).data('name');
                    let employee_dob = $(this).data('dob');
                    let employee_address = $(this).data('address');
                    let employee_nrc = $(this).data('nrc');
                    let employee_salary = $(this).data('salary');
                    let employee_description = $(this).data('description');
                    let employee_used_salary = $(this).data('used');
                    let employee_net_income = employee_salary - employee_used_salary;
                    console.log(employee_id, employee_name,employee_dob, employee_address, employee_nrc, employee_salary, employee_description, employee_used_salary);
                    $('#name').text(employee_name);
                    $('#dob').text(employee_dob);
                    $('#address').text(employee_address);
                    $('#nrc').text(employee_nrc);
                    $('#description').text(employee_description);
                    $('#salary').text(employee_salary + " ကျပ်");
                    $('#expand_salary').text(employee_used_salary + " ကျပ်");
                    $('#net_salary').text(employee_net_income + " ကျပ်");
                
                });
            });
        </script>
    </body>
</html>