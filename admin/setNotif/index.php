<?php
    // Check if the "Set Notification" button was clicked
    if (isset($_POST['set_notification'])) {
        // Get the minimum and maximum stock values from the form
        $min_stock = $_POST['minimum_stock'];
        $max_stock = $_POST['max_stock'];

        // Update the values in the stock_notif table
        $sql = "UPDATE stock_notif SET min_stock='$min_stock', max_stock='$max_stock' WHERE id=1";
        if ($conn->query($sql) === TRUE) {
            $notification_updated = true;
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    // Select the data from the stock_notif table
    $sql = "SELECT * FROM stock_notif WHERE id=1";
    $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
        }
?>


<div class="col-lg-12">
    <div class="card card-outline rounded-0 card-dark">
        <div class="card-header">
            <h5 class="card-title">Stock Alert Notification</h5>
        </div>

        <div class="card-body">
            <?php if(isset($notification_updated) && $notification_updated) { ?>
                <div class="modal fade" id="notificationModal" tabindex="-1" role="dialog" aria-labelledby="notificationModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="notificationModalLabel">Notification Updated</h5>
                            </div>
                            <div class="modal-body">
                                <p>The stock notification has been updated successfully.</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" data-dismiss="modal">Okay</button>
                            </div>
                        </div>
                    </div>
                </div>

                <script type="text/javascript">
                    $(document).ready(function() {
                        $('#notificationModal').modal('show');
                    });
                </script>
            <?php } ?>

            <form action="" method="POST" id="system-forms">
                <div class="form-group">
                    <label for="minimum_stock" class="control-label">Minimum Stock</label>
                    <input type="text" class="form-control form-control-sm" name="minimum_stock" id="minimum_stock" placeholder="Enter stock range" value="<?php echo isset($row['min_stock']) ? $row['min_stock'] : '' ?>" required oninput="checkMinMaxStock()">
                    <span id="minStockError" style="color: red; display: none;">Sorry, the min stock entered must be greater than zero.</span>
                </div>

                <div class="form-group">
                    <label for="max_stock" class="control-label">Max Stock</label>
                    <input type="number" class="form-control form-control-sm" name="max_stock" id="max_stock" placeholder="Enter stock range" value="<?php echo isset($row['max_stock']) ? $row['max_stock'] : '' ?>" required oninput="checkMinMaxStock()">
                    <span id="maxStockError" style="color: red; display: none;">Sorry, the max stock entered must be greater than zero.</span>
                </div>

                <div class="form-group">
                    <label for="date_updated" class="control-label">Date Updated</label>
                    <input type="text" class="form-control form-control-sm" name="date_updated" id="date_updated" value="<?php echo isset($row['date_updated']) ? date("Y-m-d H:i",strtotime($row['date_updated'])) : '' ?>" disabled>
                </div>

                <button type="submit" name="set_notification" class="btn btn-primary">Set Notification</button>

                <script>
                    function checkMinMaxStock() {
                        let minStockInput = document.getElementById("minimum_stock");
                        let maxStockInput = document.getElementById("max_stock");
                        let minStockError = document.getElementById("minStockError");
                        let maxStockError = document.getElementById("maxStockError");
                        
                        if (maxStockInput.value <= 0) {
                            maxStockError.style.display = "inline";
                            maxStockError.innerText = "Sorry, the max stock entered must be greater than zero.";
                        } else {
                            maxStockError.style.display = "none";
                        }

                        if (minStockInput.value <= 0) {
                            minStockError.style.display = "inline";
                            minStockError.innerText = "Sorry, the min stock entered must be greater than zero.";
                        } else {
                            minStockError.style.display = "none";
                        }
                    }
                </script>
            </form>

		</div>
	</div>
</div>