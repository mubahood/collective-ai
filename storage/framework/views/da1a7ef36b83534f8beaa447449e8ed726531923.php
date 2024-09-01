<?php
    use App\Models\Utils;
    $isPrint = false;
    if (Str::contains($_SERVER['REQUEST_URI'], 'reports-finance-print')) {
        $isPrint = true;
    }
    $sacco = $r->sacco;
    $isPrint = true;
?>
<?php if($isPrint): ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <link rel="stylesheet" href="<?php echo e(public_path('/assets/styles.css'), false); ?>">
        <link rel="stylesheet" href="<?php echo e(public_path('css/bootstrap-print.css'), false); ?>">
    </head>

    <body>
<?php endif; ?>

<table class="w-100">
    <tr>
        <td style="width: 16%">
        </td>
        <td>
            <div class="text-center">
                <p class="fs-18 text-center fw-700 mt-2 text-uppercase  " style="color: black;">
                    <?php echo e($sacco->name, false); ?></p>
                <p class="fs-14 lh-6 mt-1">TEL: <?php echo e($sacco->phone_number, false); ?>,&nbsp;<?php echo e($sacco->chairperson_phone_number, false); ?>

                </p>
                <p class="fs-14 lh-6 mt-1">EMAIL: <?php echo e($sacco->email_address, false); ?></p>
                <p class="fs-14 mt-1"><?php echo e($sacco->physical_address, false); ?></p>
            </div>
        </td>
        <td style="width: 16%">
            <img style="width: 80%; " src="<?php echo e(public_path('storage/' . $sacco->logo), false); ?>">
        </td>
    </tr>
</table>

<hr style="height: 3px; background-color:  black;" class=" mt-3 mb-0">
<hr style="height: .3px; background-color:  black;" class=" mt-1 mb-4">
<p class="fs-18 text-center mt-2 text-uppercase black mb-4 fw-700"><u>
        <?php echo e($r->title, false); ?></u></p>
<p class="text-right mb-4"> <small><u>DATE: <?php echo e(Utils::my_date($r->created_at), false); ?></u></small></p>


<table style="width: 100%">
    <thead>
        <tr>
            <td style="width: 30%;">
                <div class="my-card mr-1">
                    <p class="black fs-14 fw-700">Balance</p>
                    <p class="py-3"><span>UGX</span><span
                            class="fs-26 fw-800"><?php echo e(number_format($r->balance), false); ?></span>
                    </p>
                    <p class="fw-400 fs-14 text-dark"><?php echo e($r->Balance_DESCRIPTION, false); ?></p>
                </div>
            </td>
            <td style="width: 30%;">
                <div class="my-card mx-1">
                    <p class="black fs-14 fw-700">Profits</p>
                    <p class="py-3"><span>UGX</span><span
                            class="fs-26 fw-800"><?php echo e(number_format($r->CYCLE_PROFIT), false); ?></span></p>
                    <p class="fw-400 fs-14 text-dark"><?php echo e($r->CYCLE_PROFIT_DESCRIPTION, false); ?></p>
                </div>
            </td>
            <td style="width: 30%;">
                <div class="my-card ml-1">
                    <p class="black fs-14 fw-700">Total Savings</p>
                    <p class="py-3"><span>UGX</span><span
                            class="fs-26 fw-800"><?php echo e(number_format($r->TOTAL_SAVING), false); ?></span>
                    </p>
                    <p class="fw-400 fs-14 text-dark"><?php echo e($r->TOTAL_SAVING_DESCRIPTION, false); ?></p>
                </div>
            </td>
        </tr>
        <tr>
            <td style="width: 30%;" class="pt-2">
                <div class="my-card mr-1">
                    <p class="black fs-14 fw-700">Total Withdraw</p>
                    <p class="py-3"><span>UGX</span><span
                            class="fs-26 fw-800"><?php echo e(number_format($r->WITHDRAWAL), false); ?></span>
                    </p>
                    <p class="fw-400 fs-14 text-dark"><?php echo e($r->WITHDRAWAL_DESCRIPTION, false); ?></p>
                </div>
            </td>
            <td style="width: 30%;">
                <div class="my-card ml-1">
                    <p class="black fs-14 fw-700">Shares</p>
                    <p class="py-3"><span>UGX</span><span class="fs-26 fw-800"><?php echo e(number_format($r->SHARE), false); ?></span>
                    </p>
                    <p class="fw-400 fs-14 text-dark"><?php echo e($r->SHARE_DESCRIPTION, false); ?>.
                        (<?php echo e(number_format($r->SHARE_COUNT), false); ?> Shares)</p>
                </div>
            </td>
            <td style="width: 30%;">
                <div class="my-card mx-1">
                    <p class="black fs-14 fw-700">Total Loan</p>
                    <p class="py-3"><span>UGX</span><span
                            class="fs-26 fw-800"><?php echo e(number_format($r->LOAN_TOTAL_AMOUNT), false); ?></span></p>
                    <p class="fw-400 fs-14 text-dark"><?php echo e($r->LOAN_TOTAL_AMOUNT_DESCRIPTION, false); ?>.
                        (<?php echo e(number_format($r->LOAN_COUNT), false); ?> Loans).</p>
                </div>
            </td>
        </tr>

        <tr>
            <td style="width: 30%;" class="pt-2">
                <div class="my-card mr-1">
                    <p class="black fs-14 fw-700">Loan Payments</p>
                    <p class="py-3"><span>UGX</span><span
                            class="fs-26 fw-800"><?php echo e(number_format($r->LOAN_REPAYMENT), false); ?></span>
                    </p>
                    <p class="fw-400 fs-14 text-dark"><?php echo e($r->LOAN_REPAYMENT_DESCRIPTION, false); ?></p>
                </div>
            </td>
            <td style="width: 30%;">
                <div class="my-card ml-1">
                    <p class="black fs-14 fw-700">Unpaid Loan Balance</p>
                    <p class="py-3"><span>UGX</span><span
                            class="fs-26 fw-800"><?php echo e(number_format($r->LOAN_BALANCE), false); ?></span></p>
                    <p class="fw-400 fs-14 text-dark"><?php echo e($r->LOAN_BALANCE_DESCRIPTION, false); ?></p>
                </div>
            </td>
            <td style="width: 30%;">
                <div class="my-card mx-1">
                    <p class="black fs-14 fw-700">Loan Interest</p>
                    <p class="py-3"><span>UGX</span><span
                            class="fs-26 fw-800"><?php echo e(number_format($r->LOAN_INTEREST), false); ?></span></p>
                    <p class="fw-400 fs-14 text-dark"><?php echo e($r->LOAN_INTEREST_DESCRIPTION, false); ?></p>
                </div>
            </td>
        </tr>
    </thead>
</table>



<?php if($isPrint): ?>
    </body>

    </html>
<?php endif; ?>
<?php /**PATH /Applications/MAMP/htdocs/marcci-dashboard/resources/views/reports/finance.blade.php ENDPATH**/ ?>