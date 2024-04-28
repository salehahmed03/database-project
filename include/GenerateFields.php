<div class="container">
            <h2>Add New Data To The Table</h2>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <?php
                foreach ($columns as $column) {
                    echo "<div class='form-group'>";
                    echo "<label for='$column'>$column:</label>";
                    echo "<input type='text' class='form-control' id='$column' name='$column'>";
                    echo "</div>";
                }
                ?>
                <button type="submit" class="btn btn-primary">Add</button>
            </form>
        </div>

    </body>
    </html>
    <?php