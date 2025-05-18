<?php
include_once('load_session.php');

//include_once('check_attendance.php');
include_once('database_connection.php');

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Expenses | Add Expenses</title>
  <?php include_once('head.php'); ?>

</head>

<body class="hold-transition sidebar-mini">
  <!-- Site wrapper -->
  <div class="wrapper">

    <?php
    $department = $_GET['dept'];
    switch ($department) {
      case 'Men':
        include_once('navbar_men.php');
        break;
      case 'Women':
        include_once('navbar_women.php');
        break;
      case 'Youth':
        include_once('navbar_youth.php');
        break;
      case 'Main':
        include_once('navbar.php');
        break;
      default:
        echo "No department specified";
        break;
    }

    ?>
    <!-- /.navbar -->
    <?php
    $department = $_GET['dept'];

    switch ($department) {
      case 'Men':
        include_once('mens_sidebar.php');
        break;
      case 'Women':
        include_once('womens_sidebar.php');
        break;
      case 'Youth':
        include_once('youth_sidebar.php');
        break;
      case 'Main':
        include_once('sidebar.php');
        break;
      default:
        echo "No department specified";
        break;
    }

    ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">

            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="manage_expenses.php">Expenses</a></li>
                <li class="breadcrumb-item active">expenses</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>
      <button class="btn btn-primary btn-sm back" style="margin-left:300px"><i class="fa fa-arrow-left"></i>
        Back</button>
      <br>
      <br>
      <!-- Main content -->
      <section class="content">

        <!-- Default box -->
        <div class="row" style="padding-left:23%">

          <form method="post" id="warefare">

            <div class="col-9">
              <div class="card">
                <div class="card-body">
                  <div class="row">
                    <div class="col-9">
                      <div class="form-group">
                        <label for="">Category:</label>
                        <select name="category" id="" class='form-control tfcat'>
                          <option value="">-select-</option>
                          <option value="Offering">Offering</option>
                          <option value="MainHarvest">MainHarvest</option>
                          <option value="MiniHarvest">MiniHarvest</option>
                          <option value="Fuel_&_Power
">CBF318: Fuel&Power
                          </option>
                          <option value="Telephone
">TEL505:Telephone
                          </option>
                          <option value="Loan
">LN025:Loan
                          </option>

                          <option value="Travel_&_Transport
">T&T412: Travel & Transport
                          </option>
                          <option value="Cleaning
">CLNG101: Cleaning
                          </option>
                          <option value="Stationery_&_Printing
">STA404: Stationery&Printing
                          </option>
                          <option value="Misc_Expenses
">MSE305: Misc Expenses
                          </option>
                          <option value="Vehicle_R&M
">CRPM605: Vehicle_R&M
                          </option>
                          <option value="Electricity_Bill
">ECG708: Electricity Bill
                          </option>
                          <option value="Water_Bill
">WTR903: Water Bill
                          </option>
                          <option value="Repairs_&_Maintenance.
">R&M817: Repairs & Maint.
                          </option>
                          <option value="Medicals
">MDC945: Medicals
                          </option>
                          <option value="Internet_Charges
">INT747: Internet Charges
                          </option>
                          <option value="Bank
">BNK210: Bank
                          </option>
                          <option value="Petty_Cash
">PTC212: Petty Cash
                          </option>
                          <option value="Motor_Vehicle
">MVH214: Motor Vehicle
                          </option>
                          <option value="Furniture
">FUR215: Furniture
                          </option>
                          <option value="Wedding_benefit
">Wedding benefit
                          </option>
                          <option value="Cards
">WC24:Cards
                          </option>
                          <option value="Dues">Welfare Dues</option>

                        </select>
                      </div>
                    </div>

                    <div class="col-3">
                      <div class="form-group">
                        <label for="">Expense type</label>
                        <select name="extype" class='form-control type'>
                          <option value="">-select-</option>
                          <option value="Expenditure">Expenditure
                          </option>
                          <option value="Income">Income
                          </option>
                        </select>
                      </div>
                    </div>

                    <div class="col-6">
                      <div class="form-group">
                        <label for="">Date:</label>
                        <input type="date" name="date" class="form-control tfdate" placeholder="Date">
                      </div>
                    </div>

                    <div class="col-6">
                      <div class="form-group">
                        <label for="">Amount(¢):</label>
                        <input type="text" name="amount" class="form-control tfamount" placeholder="¢0.00">
                      </div>
                    </div>

                    <div class="col-9">
                      <div class="form-group">
                        <label for="">Paid To:</label>
                        <input type="text" name="benefit" class="form-control tfbenefit" placeholder="Benefitiary">
                      </div>
                    </div>
                    <div class="col-3">
                      <div class="form-group">
                        <label for="">Cheque No.:</label>
                        <input type="text" name="cheque" class="form-control tfcheque" placeholder="Cheque No.">
                      </div>
                    </div>

                    <div class="col-12">
                      <div class="form-group">
                        <label for="">Description</label>
                        <textarea name="details" cols="10" rows="4" class="form-control tfdetails"
                          placeholder="description........"></textarea>
                      </div>
                    </div>

                    <div class="col-12" hidden>
                      <div class="form-group">
                        <label for="">ID</label>
                        <input class='form-control tfidd' placeholder='ID' value="<?php echo $_GET['uid'] ?>">
                      </div>
                    </div>
                    <div class="col-12" hidden>
                      <input type="text" class="form-control tfdept" value="<?php echo $_GET['dept'] ?>">
                    </div>
                    <button type='submit' class="btn btn-success" style="width:100%">Add Expenses</button>
                  </div>
                </div>
          </form>

        </div>
    </div>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <?php include_once('footer.php'); ?>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
  </div>
  <!-- ./wrapper -->



  <?php include_once("script.php"); ?>
  <?php include_once("validate_expenses.php") ?>
  <script>

    $('.back').click(function () {
      if (document.referrer) {
        window.location.href = document.referrer;
      } else {
        window.history.back();
      }

    });

  </script>

</body>

</html>