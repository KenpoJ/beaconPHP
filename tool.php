<?php
if(isset($_POST['submitted'])) {
	$gross = $_POST['grossPay'];
	$net = $_POST['netPay'];
	$totalExpenses = 0;
	$totalAllowances = 0;
	$allExpenses = 0;

	$expense_values = array();
	$expenseAmount_values = array();
	$allowance_values = array();
	$allowanceAmount_values = array();


	// ============ EXPENSES =============== //
	// CAPTURE EXPENSE NAMES AND VALUES
	if(isset($_POST["expense"]) && is_array($_POST["expense"])){
		foreach($_POST["expense"] as $key => $exp_name){
			array_push($expense_values, $exp_name);
		}
		//echo $expense_values[0] . "<br>";
	}

	if(isset($_POST["expenseAmount"]) && is_array($_POST["expenseAmount"])){
		foreach($_POST["expenseAmount"] as $key => $exp_amount){
			array_push($expenseAmount_values, $exp_amount);
		}
		//echo $expenseAmount_values[0] . "<br>";
	}

	// TOTAL EXPENSES BY LOOPING THROUGH AND ADDING THEM ALL
	foreach($expenseAmount_values as $expenseAmount) {
		//echo $expenseAmount . "<br>";
		$totalExpenses = $totalExpenses + $expenseAmount;
	}

	// ============ ALLOWANCES =============== //
	// CAPTURE ALLOWANCE NAMES AND VALUES
	if(isset($_POST["allowancePerson"]) && is_array($_POST["allowancePerson"])){
		foreach($_POST["allowancePerson"] as $key => $allowance_person){
			array_push($allowance_values, $allowance_person);
		}
	}

	if(isset($_POST["allowanceAmount"]) && is_array($_POST["allowanceAmount"])){
		foreach($_POST["allowanceAmount"] as $key => $allowance_amount){
			array_push($allowanceAmount_values, $allowance_amount);
		}
	}

	// TOTAL ALLOWANCES BY LOOPING THROUGH AND ADDING THEM ALL
	foreach($allowanceAmount_values as $allowanceAmount) {
		//echo $allowanceAmount . "<br>";
		$totalAllowances = $totalAllowances + $allowanceAmount;
	}

	// TOTAL ALL EXPENSES
	$diff = $gross - $net;
	$allExpenses = $totalExpenses + $totalAllowances;


	$totalNetIncome = $net - $totalAllowances;

	// FIGURE PERCENTAGES FOR EACH JAR
	$nec = $totalExpenses + 25;
	if($_POST['giveOption'] == 'give-gross') {
		$give = $gross * .1;
	} else {
		$give = $net * .1;
	}

	$leftover = $net - $nec - $give;

	$ltss = $leftover / 4;
	$ffa = $leftover / 4;
	$edu = $leftover / 4;
	$play = $leftover / 4;

	/*echo "Total Expenses: " . $totalExpenses . "<br>";
	echo "Gross Pay: $gross<br>";
	echo "Net Pay: $net<br>";*/
}
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Beacon | Effortless Money Management</title>

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="css/styles.css">

<!--[if lt IE 9]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->

</head>
<body>

<header>
	<div class="container">
		<h1>Beacon<br><small>Effortless Money Management</small></h1>
	</div>
</header>

<div class="container">

<?php
if(!$_POST) {
?>

<form class="form" id="beacon-form" method="post" action="<?php $_SERVER['PHP_SELF'] ?>">

	<section id="income">
		<h2>Income <small><span class="help"><i class="glyphicon glyphicon-question-sign"></i></span></small></h2>

		<label for="grossPay">Gross Pay</label>
		<div class="input-group input-group-lg col-md-6 col-md-offset-4">
			<span class="input-group-addon">$</span>
			<input name="grossPay" type="text" class="form-control" placeholder="0" required>
		</div>

		<label for="netPay">Net Pay</label>
		<div class="input-group input-group-lg col-md-6 col-md-offset-4">
			<span class="input-group-addon">$</span>
			<input name="netPay" type="text" class="form-control" placeholder="0" required>
		</div>
		<!--div class="clear">
			<button class="btn btn-default pull-right next" href="#expenses" type="button">Next</button>
		</div-->
	</section>

	<section id="expenses">
		<h2>Expenses
			&nbsp;<button id="add-btn" class="btn btn-default btn-xs add-expense" type="button"><i class="glyphicon glyphicon-plus"></i> Add Expense</button> 
			<small><span class="help"><i class="glyphicon glyphicon-question-sign"></i></span></small>
		</h2>

		<div class="expense-container">
			<div class="expense row">
				<div class="col-md-5">
					<div class="form-group form-group-lg">
						<input name="expense[]" type="text" class="form-control" placeholder="Expense" required>
					</div>
				</div>
				<div class="col-md-5">
					<div class="input-group input-group-lg ex-amt">
						<span class="input-group-addon">$</span>
						<input name="expenseAmount[]" type="text" class="form-control" placeholder="0" required>
					</div>
				</div>
				<div class="col-md-1">
					<button id="minus-btn" class="btn btn-default btn-lg btn-block remove-expense" href="#" type="button">
						<i class="glyphicon glyphicon-minus"></i>
					</button>
				</div>
				<div class="col-md-1"></div>
			</div>
		</div>

		<!--div class="clear">
			<button class="btn btn-default pull-left prev" type="button">Previous</button>
			<button class="btn btn-default pull-right next" href="#allowances" type="button">Next</button>
		</div-->
	</section>

	<section id="allowances">
		<h2>Allowances
			&nbsp;<button class="btn btn-default btn-xs add-allowance" type="button"><i class="glyphicon glyphicon-plus"></i> Add Allowance</button> 
			<small><span class="help"><i class="glyphicon glyphicon-question-sign"></i></span></small>
		</h2>

		<div class="allowance-container">
			<div class="allowance row">
				<div class="col-md-5">
					<div class="form-group form-group-lg">
						<input name="allowancePerson[]" type="text" class="form-control" placeholder="Someone's allowance" required>
					</div>
				</div>
				<div class="col-md-5">
					<div class="input-group input-group-lg">
						<span class="input-group-addon">$</span>
						<input name="allowanceAmount[]" type="text" class="form-control" placeholder="0" required>
					</div>
				</div>
				<div class="col-md-1">
					<button id="minus-btn" class="btn btn-default btn-lg btn-block remove-allowance" href="#" type="button">
						<i class="glyphicon glyphicon-minus"></i>
					</button>
				</div>
				<div class="col-md-1"></div>
			</div>
		</div>

		<!--div class="clear">
			<button class="btn btn-default pull-left prev" type="button">Previous</button>
			<button class="btn btn-default pull-right next" href="#give" type="button">Next</button>
		</div-->
	</section>

	<section id="give">
		<h2>GIVE Jar <small><span class="help"><i class="glyphicon glyphicon-question-sign"></i></span></small></h2>

		<p>It's importnat to give in order to receive. The GIVE jar always gets 10%.</p>

		<div class="radio">
			<label>
				<input type="radio" name="giveOption" value="give-gross" checked>
				Do you want to GIVE from your Gross Income?
			</label>
		</div>
		<div class="radio">
			<label>
				<input type="radio" name="giveOption" value="give-net">
				Or do you want to GIVE from your Net Income?
			</label>
		</div>

		<!--div class="clear">
			<button class="btn btn-default pull-left prev" type="button">Previous</button>
			<button class="btn btn-default pull-right next" href="#jar-dist" type="submit" value="submitted">See your distribution</button>
		</div-->
	</section>

	<button type="submit" name="submitted">Show Me!</button>

</form>

<?php
} else {
?>

<section id="jar-dist">
	<h2>How Much Goes Into Each Jar? <small><span class="help"><i class="glyphicon glyphicon-question-sign"></i></span></small></h2>

	<div class="col-md-6">
		<table class="table">
			<thead>
				<tr>
					<th colspan="2">Your Income</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<th>Gross Income</th>
					<td><?php echo "$" . number_format($gross, 2); ?></td>
				</tr>
				<tr>
					<th>Net Income</th>
					<td><?php echo "$" . number_format($net, 2); ?></td>
				</tr>
				<tr>
					<th>Difference</th>
					<td><?php echo "$" . number_format($diff, 2); ?></td>
				</tr>
			</tbody>
		</table>

		<table class="table">
			<thead>
				<tr>
					<th colspan="2">Allowances</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<?php
					foreach($allowance_values as $index => $person) {
						echo "<tr><th>" . $person . "</th><td>$" . number_format($allowanceAmount_values[$index], 2) . "</td>";
					}
					?>
				</tr>
				<tr>
					<th>Total Allowances</th>
					<td><?php echo "$" . number_format($totalAllowances, 2); ?></td>
				</tr>
			</tbody>
		</table>

	</div>

	<div class="col-md-6">
		<table class="table">
			<thead>
				<tr>
					<th colspan="2">Your Expenses</th>
				</tr>
			</thead>
			<tbody>
				<?php
				foreach($expense_values as $index => $expense) {
					echo "<tr><td>" . $expense . "</td><td>$" . number_format($expenseAmount_values[$index], 2) . "</td>";
				}
				?>
				<tr>
					<td>Expenses Total</td>
					<td><?php echo "$" . number_format($totalExpenses, 2); ?></td>
				</tr>
			</tbody>
		</table>

	</div>

	<div class="col-md-12 total-net-income">
		<?php
		echo "Net Income: $" . number_format($totalNetIncome, 2);
		?>
	</div>

	<table class="table table-hover">
		<caption>Distribution of Your Money</caption>
		<thead>
			<tr>
				<th>Jar</th>
				<th>%</th>
				<th>Amount</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>NEC <small>(Necessities)</small></td>
				<td><?php echo round($nec / $totalNetIncome * 100, 2) . "%" ?></td>
				<td><?php echo "$" . number_format($nec, 2); ?></td>
			</tr>
			<tr>
				<td>GIVE <small>(Charitable Giving)</small></td>
				<td><?php echo round($give / $totalNetIncome * 100, 2) . "%" ?></td>
				<td><?php echo "$" . number_format($give, 2); ?></td>
			</tr>
			<tr>
				<td>LTSS <small>(Long Term Savings for Spending)</small></td>
				<td><?php echo round($ltss / $totalNetIncome * 100, 2) . "%" ?></td>
				<td><?php echo "$" . number_format($ltss, 2); ?></td>
			</tr>
			<tr>
				<td>FFA <small>(Financial Freedom Account)</small></td>
				<td><?php echo round($ffa / $totalNetIncome * 100, 2) . "%" ?></td>
				<td><?php echo "$" . number_format($ffa, 2); ?></td>
			</tr>
			<tr>
				<td>EDU <small>(Education)</small></td>
				<td><?php echo round($edu / $totalNetIncome * 100, 2) . "%" ?></td>
				<td><?php echo "$" . number_format($edu, 2); ?></td>
			</tr>
			<tr>
				<td>PLAY <small>(Play / Fun)</small></td>
				<td><?php echo round($play / $totalNetIncome * 100, 2) . "%" ?></td>
				<td><?php echo "$" . number_format($play, 2); ?></td>
			</tr>
		</tbody>
	</table>
</section>

<?php
}
?>

</div>

<footer>

</footer>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- Latest compiled and minified JavaScript -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="bower_components/jquery-validation/dist/jquery.validate.min.js"></script>
<script type="text/javascript" src="js/beacon-script.js"></script>
</body>
</html>