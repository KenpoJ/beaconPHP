$(document).ready(function() {


// 2 Way Data Binding Plugin for jQuery: http://jquerymy.com

// PREVIOUS and NEXT Button Actions
$('#expenses .prev').click(function() {
	scrollToAnchor('income');
});
$('#income .next, #allowances .prev').click(function() {
	scrollToAnchor('expenses');
});
$('#expenses .next, #give .prev').click(function() {
	scrollToAnchor('allowances');
});
$('#allowances .next').click(function() {
	scrollToAnchor('give');
});
$('#give .next').click(function() {
	scrollToAnchor('jar-dist');
});

function scrollToAnchor(target){
	var anchor = $('section#' + target);
	$('html, body').animate({scrollTop: anchor.offset().top},'slow');
}

$('#beacon-form').validate({
	rules: {
		grossPay: {
			required: true,
			number: true
		},
		netPay: {
			required: true,
			number: true
		},
		expenseAmount: {
			required: true,
			number: true
		},
		allowanceAmount: {
			required: true,
			number: true
		}
	}
});
  


// ================ EXPENSES ====================
// https://daveismyname.blog/duplicate-form-sections-with-jquery

var expTemplate = $('.expense-container .expense:first').clone();
var expenseCnt = 1;

// Add expense inputs
$('.add-expense').click(function() {
	expenseCnt++;
	addExpense();
	return false;
});

// Remove expense inputs
$('.expense-container').on('click', '.remove-expense', function(e) {
	$(this).parent().parent().fadeOut(300, function() {
		$(this).empty();
		return false;
	});
	return false;
});

function addExpense() {
	var newExpense = expTemplate.clone().find(':input').each(function() {
		var newName = this.name + expenseCnt;
		this.name = newName;
	}).end()
	.appendTo('.expense-container');
}


// ================= ALLOWANCES ==================
var alwTemplate = $('.allowance-container .allowance:first').clone();
var allowanceCnt = 1;

// Add allowance inputs
$('.add-allowance').click(function() {
	allowanceCnt++;
	addAllowance();
	return false;
});

// Remove allowance inputs
$('.allowance-container').on('click', '.remove-allowance', function(e) {
	$(this).parent().parent().fadeOut(300, function() {
		$(this).empty();
		return false;
	});
	return false;
});
function addAllowance() {
	var newAllowance = alwTemplate.clone().find(':input').each(function() {
		var newId = this.name + allowanceCnt;
		this.id = newId;
	}).end()
	.appendTo('.allowance-container');
}





});