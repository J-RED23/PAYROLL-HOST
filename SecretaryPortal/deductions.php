<?php
require_once('../secclass.php');
$sessionData = $payroll->getSessionSecretaryData();
$payroll->verifyUserAccess($sessionData['access'], $sessionData['fullname'],2);
$fullname = $sessionData['fullname'];
$access = $sessionData['access'];
$id = $sessionData['id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Deductions</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="../seccss/main.css">
</head>
<body>
     <div class="main-container">
      <div class="sidebar">
               <div class="sidebar__logo">
                    <div class="logo"></div>
                    <h3>JDTV</h3>
               </div>
               <nav>
                    <ul>
                        <li class="li__records">
                            <a href="../SecretaryPortal/secdashboard.php">Attendance</a>
                         </li>
                        <li class="li__user active">
                            <a href="../SecretaryPortal/employeelist.php" class="active">Employees</a>
                            <ul>
                                <li><a href="../SecretaryPortal/empschedule.php">Schedule</a></li>
                                <li><a href="../SecretaryPortal/deductions.php" class="active">Deductions</a></li>
                                <li><a href="../SecretaryPortal/violations.php">Violations</a></li>
                            </ul>
                        </li>
    
                        <li class="li__report">
                            <a href="#">Payroll</a>
                            <ul>
                             
                                <li><a href="../SecretaryPortal/automaticpayroll.php">Salary</a></li>
                            </ul>
                        </li>

                        <li class="li__report">
                            <a href="#">Salary Report</a>
                            <ul>
                                <li><a href="../SecretaryPortal/releasedsalary.php" >Released Salary</a></li>
                                <li><a href="../SecretaryPortal/salaryreport.php">Salary Chart</a></li>
                                <li><a href="../SecretaryPortal/contributions.php" >Contributions</a></li>
                            </ul>
                         </li>
                         <li class="li__report">
                         <a href="../SecretaryPortal/activitylog.php">Activity log</a>
                         </li>
                    </ul>
                </nav>
                <div class="sidebar__logout">
                    <div class="li li__logout"><a href="../seclogout.php">LOGOUT</a></div>
                </div>
            </div>

          <div class="page-info-head">
               Deductions
          </div>

          <div class="user-info">
               <a href="editsec.php">[ Edit Account ]</a>
               <p><?php echo $fullname; ?></p>
          <div class="user-profile">
          </div>
          </div>

          <div class="emp-deductions">
               <div class="emp-deductions__header">
                    <h2>Generate Deductions</h2>
               </div>

               <div class="emp-deductions__form">
                    <form action="" method="post">
                         <div class="detail">
                              <label for="deduction">Deductions :</label> <br>
                              <select name="deduction" id="deduction" onchange="myFunction()">
                                   <option value="">Select Deduction</option>
                                   <option value="SSS">SSS</option>
                                   <option value="Pagibig">Pag-ibig</option>
                                   <option value="Philhealth">Philhealth</option>
                                   <option value="other">Other</option>
                                   <script>
                                   function myFunction() 
                                   {    
                                        var x = document.getElementById("deduction").value;
                                        if (x == "other"){
                                        document.getElementById("percentage").style.display = "none";
                                        document.getElementById("percentagelabel").style.display = "none";
                                        document.getElementById("other").style.display = "block";
                                        }else{
                                        document.getElementById("percentage").style.display = "block";
                                        document.getElementById("percentagelabel").style.display = "block";
                                        document.getElementById("other").style.display = "none";
                                        }
                                   }
                                   </script>
                              </select>
                         </div>

                         <div class="detail">
                              <label for="percentage" style="display:block" id="percentagelabel">Percentage :</label> <br>
                              <input type="number" step="0.001" id="percentage" name="percentage" style="display:block">
                         </div>

                         <div id="other" style="display:none">
                              
                              <div class="detail">
                              <label for="deductionname" id="deductionname"> Name :</label> <br>
                              <input type="text" id="dedname" name="name" ><br>
                              <label for="amount"> Amount :</label> <br>
                              <input type="number" name="amount" placeholder="Php">
                              </div>
                         </div>

                         <button type="submit" name="generatededuction">
                              Generate
                         </button>
                         <?php $payroll->adddeduction($fullname,$id); ?>
                    </form>
               </div>
          </div>

          <div class="cashadvance">
               <div class="cashadvance__header">
                    <h2>Cash Advance</h2>
               </div>
               <form action="" method="post">
                    <div class="cashadvance__form">
                         <div class="detail">
                         <?php $payroll->cashadvance($fullname,$id);?>
                              <label for="">Employee ID :</label>
                              <?php $sql ="SELECT empId,firstname,lastname FROM employee;";$stmt = $payroll->con()->prepare($sql); $stmt->execute(); $row = $stmt->fetchall(); echo "<select id= empid name=empid >"; foreach($row as $rows){echo "<option value=$rows->empId> $rows->empId $rows->firstname $rows->lastname</option>";}; ?><?php echo "</select>"; ?><br/><br/>
                         </div>

                         <div class="detail">
                              <label for="amount">Amount :</label>
                              <input type="number" name="amount" placeholder="Php">
                         </div>
                    </div>

                    <button type="submit" name="add">
                         Add
                    </button>
               </form>
          </div>

          <div class="generated-deduction-table">
          
                <div class="generated-deduction-table__header">
                <h1>Deductions</h1>
                </div>
               <table>
               <col>
               <colgroup span="2"></colgroup>
               <colgroup span="2"></colgroup>
                    <thead>
                        <tr>
                            <th>Deduction Name</th>
                            <th colspan="2" scope="colgroup">Deduction</th>
                            <th>Action</th>
                        </tr>
                        <tr>
                              <th></th>
                              <th scope="col">Total</th>
                              <th scope="col">Percent</th>
                              <th></th>
                         </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <?php $payroll->displaydeduction();?>
                    </tr>
                    </tbody>
               </table>
          </div>

          <div class="generated-cashadvance">
               <div class="generated-deduction-table__header">
               <h1>Cash Advance</h1>
               </div>
               <table>
                    <thead>
                    <tr>
                         <th>Name</th>
                         <th>Date</th>
                         <th>Amount</th>
                         <th>Action</th>
                    </tr>

                    </thead>

                    <tbody>
                    <tr>
                         <!--php here displaydeduction();--> 
                         <?php $payroll->displaycashadvance();?>
                    </tr>
                    </tbody>
               </table>
          </div>
     </div>
</body>
</html>



