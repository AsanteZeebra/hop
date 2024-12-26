<nav class="main-header navbar navbar-expand navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                <i class="fas fa-bars"></i>
            </a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">

        <!-- Balance Display -->
        <li class="nav-item">
            <?php
            // Fetch total balance for Men department
            $query = "SELECT SUM(amount) AS total FROM exepenses WHERE department = ? AND expense_type = ? AND status = ?";
            if ($stmt = $con->prepare($query)) {
                $department = 'Men';
                $expenseType = 'Income';
                $status = 'Approved';

                $stmt->bind_param("sss", $department, $expenseType, $status);
                $stmt->execute();
                $result = $stmt->get_result();
                $row = $result->fetch_assoc();

                $count = $row['total'] ?? 0;
                echo '<b class="nav-link"> Balance(¢): ' . number_format($count, 2) . '</b>';

                $stmt->close();
            } else {
                echo '<b class="nav-link text-danger">Error fetching balance</b>';
            }
            ?>
        </li>

        

        <!-- Notifications Dropdown -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="fa-solid fa-bullhorn"></i>
                <?php
                // Fetch active announcement count
                $query = "SELECT COUNT(*) AS total FROM announcement WHERE status = ?";
                if ($stmt = $con->prepare($query)) {
                    $status = 'Active';

                    $stmt->bind_param("s", $status);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $row = $result->fetch_assoc();

                    $total = $row['total'] ?? 0;
                    echo '<span class="badge badge-warning navbar-badge">' . $total . '</span>';

                    $stmt->close();
                } else {
                    echo "<script>swal('Error', 'Unable to fetch notifications', 'error');</script>";
                }
                ?>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <span class="dropdown-item dropdown-header"><?php echo $total; ?> Notifications</span>

                <?php
                // Fetch active announcements
                $query = "SELECT department, tittle FROM announcement WHERE status = ?";
                if ($stmt = $con->prepare($query)) {
                    $stmt->bind_param("s", $status);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    while ($row = $result->fetch_assoc()) {
                        $department = htmlspecialchars($row['department']);
                        $tittle = htmlspecialchars($row['tittle']);
                        echo '
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fa-solid fa-bullhorn mr-2"></i> ' . $tittle . '
                            <span class="float-right text-muted text-sm">' . $department . '</span>
                        </a>';
                    }

                    $stmt->close();
                } else {
                    echo "<script>swal('Error', 'Unable to fetch announcements', 'error');</script>";
                }
                ?>
                <div class="dropdown-divider"></div>
                <a href="announcement.php?mid=<?php echo htmlspecialchars($_GET['mid']); ?>" class="dropdown-item dropdown-footer">See All Notifications</a>
            </div>
        </li>

        <!-- Fullscreen Toggle -->
        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>

        <!-- Logout -->
        <li class="nav-item">
            <a class="nav-link text-danger" href="signout.php" role="button">
                <i class="fa-solid fa-power-off"></i> Logout
            </a>
        </li>
    </ul>
</nav>
