<?php

namespace CodGlo\CGAccounting\Services;

use CodGlo\CGAccounting\Models\Account;
use CodGlo\CGAccounting\Models\Record;
use DB;
use Illuminate\Support\Facades\View;
use Mpdf\Mpdf;
use Storage;

class AccountingReportService
{

  private $companyName;
  private $companyAddress;
  private $companyPhone;
  private $companyEmail;

  public function __construct($companyName, $companyAddress, $companyPhone, $companyEmail)
  {
    $this->companyName = $companyName;
    $this->companyAddress = $companyAddress;
    $this->companyPhone = $companyPhone;
    $this->companyEmail = $companyEmail;
  }

  public function generateProfitAndLossReport($startDate, $endDate, $outputPath)
  {
    // Generate profit and loss report
    //incomes
    //sales income
    $salesRevenue = DB::table('accpkg_entries as ae')
      ->join('accpkg_accounts as aa', 'aa.id', '=', 'ae.from_account')
      ->where('aa.name', 'Sales Revenue')
      ->whereBetween('ae.created_at', [$startDate, $endDate])
      ->orderBy('ae.created_at', 'desc')
      ->limit(1)
      ->value('ae.balance');

    $serviceRevenue = DB::table('accpkg_entries as ae')
      ->join('accpkg_accounts as aa', 'aa.id', '=', 'ae.from_account')
      ->where('aa.name', 'Service Revenue')
      ->whereBetween('ae.created_at', [$startDate, $endDate])
      ->orderBy('ae.created_at', 'desc')
      ->limit(1)
      ->value('ae.balance');

    $otherIncome = DB::table('accpkg_entries as ae')
      ->join('accpkg_accounts as aa', 'aa.id', '=', 'ae.from_account')
      ->where('aa.name', 'Other Income')
      ->whereBetween('ae.created_at', [$startDate, $endDate])
      ->orderBy('ae.created_at', 'desc')
      ->limit(1)
      ->value('ae.balance');

    $totalIncome = $salesRevenue + $serviceRevenue + $otherIncome;

    //expenses
    $costOfGoodsSold = DB::table('accpkg_entries as ae')
      ->join('accpkg_accounts as aa', 'aa.id', '=', 'ae.from_account')
      ->where('aa.name', 'Cost of Goods Sold')
      ->whereBetween('ae.created_at', [$startDate, $endDate])
      ->orderBy('ae.created_at', 'desc')
      ->limit(1)
      ->value('ae.balance');

    // gross profit
    $grossProfit = $totalIncome - $costOfGoodsSold;

    $salariesExpense = DB::table('accpkg_entries as ae')
      ->join('accpkg_accounts as aa', 'aa.id', '=', 'ae.from_account')
      ->where('aa.name', 'Salaries Expense')
      ->whereBetween('ae.created_at', [$startDate, $endDate])
      ->orderBy('ae.created_at', 'desc')
      ->limit(1)
      ->value('ae.balance');

    $rentExpense = DB::table('accpkg_entries as ae')
      ->join('accpkg_accounts as aa', 'aa.id', '=', 'ae.from_account')
      ->where('aa.name', 'Rent Expense')
      ->whereBetween('ae.created_at', [$startDate, $endDate])
      ->orderBy('ae.created_at', 'desc')
      ->limit(1)
      ->value('ae.balance');

    $utilitiesExpense = DB::table('accpkg_entries as ae')
      ->join('accpkg_accounts as aa', 'aa.id', '=', 'ae.from_account')
      ->where('aa.name', 'Utilities Expense')
      ->whereBetween('ae.created_at', [$startDate, $endDate])
      ->orderBy('ae.created_at', 'desc')
      ->limit(1)
      ->value('ae.balance');

    $depreciationExpense = DB::table('accpkg_entries as ae')
      ->join('accpkg_accounts as aa', 'aa.id', '=', 'ae.from_account')
      ->where('aa.name', 'Depreciation Expense')
      ->whereBetween('ae.created_at', [$startDate, $endDate])
      ->orderBy('ae.created_at', 'desc')
      ->limit(1)
      ->value('ae.balance');

    $salesDiscount = DB::table('accpkg_entries as ae')
      ->join('accpkg_accounts as aa', 'aa.id', '=', 'ae.from_account')
      ->where('aa.name', 'Sales Discount')
      ->whereBetween('ae.created_at', [$startDate, $endDate])
      ->orderBy('ae.created_at', 'desc')
      ->limit(1)
      ->value('ae.balance');

    $salesReturnsAndAllowances = DB::table('accpkg_entries as ae')
      ->join('accpkg_accounts as aa', 'aa.id', '=', 'ae.from_account')
      ->where('aa.name', 'Sales Returns and Allowances')
      ->whereBetween('ae.created_at', [$startDate, $endDate])
      ->orderBy('ae.created_at', 'desc')
      ->limit(1)
      ->value('ae.balance');

    $otherExpenses = DB::table('accpkg_entries as ae')
      ->join('accpkg_accounts as aa', 'aa.id', '=', 'ae.from_account')
      ->where('aa.name', 'Other Expenses')
      ->whereBetween('ae.created_at', [$startDate, $endDate])
      ->orderBy('ae.created_at', 'desc')
      ->limit(1)
      ->value('ae.balance');

    $totalExpenses = $salariesExpense + $rentExpense + $utilitiesExpense + $depreciationExpense + $salesDiscount + $salesReturnsAndAllowances + $otherExpenses;

    $netProfit = $grossProfit - $totalExpenses;

    $view = View::make('cgaccounting::profit_and_loass.blade.php', array(

      'companyName' => $this->companyName,
      'companyAddress' => $this->companyAddress,
      'companyPhone' => $this->companyPhone,
      'companyEmail' => $this->companyEmail,
      'startDate' => $startDate,
      'endDate' => $endDate,
      'salesRevenue' => $salesRevenue,
      'serviceRevenue' => $serviceRevenue,
      'otherIncome' => $otherIncome,
      'totalIncome' => $totalIncome,
      'costOfGoodsSold' => $costOfGoodsSold,
      'grossProfit' => $grossProfit,
      'salariesExpense' => $salariesExpense,
      'rentExpense' => $rentExpense,
      'utilitiesExpense' => $utilitiesExpense,
      'depreciationExpense' => $depreciationExpense,
      'salesDiscount' => $salesDiscount,
      'salesReturnsAndAllowances' => $salesReturnsAndAllowances,
      'otherExpenses' => $otherExpenses,
      'totalExpenses' => $totalExpenses,
      'netProfit' => $netProfit

    ));
    $html = $view->render();

    $pathTmp = 'tmp/';
    if (!Storage::exists($pathTmp)) {
      Storage::makeDirectory($pathTmp);
    }
    $mpdf = new Mpdf(['tempDir' => $pathTmp, 'mode' => 'UTF-8', 'format' => 'A4-P', 'autoScriptToLang' => true, 'autoLangToFont' => true]);

    $mpdf->WriteHTML($html);

    // $pdf->setPaper('A4', 'portrait');

    // $pdfContent = $pdf->output();

    $path = 'public/uploads/';
    $fileName = "profit_and_loss_" . $startDate . '_' . $endDate . '.pdf';

    if (!Storage::exists($path)) {
      Storage::makeDirectory($path);
    }

    $fullPath = storage_path('app/' . $path . $fileName);
    $mpdf->Output($fullPath, \Mpdf\Output\Destination::FILE);

    // Generate file URL
    $fileUrl = url('storage/uploads/' . $fileName);

    return $fileUrl;


  }

}