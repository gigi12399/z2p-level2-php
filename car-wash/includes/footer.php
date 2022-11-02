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
            });
        </script>
    </body>
</html>