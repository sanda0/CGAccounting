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

  public function generateProfitAndLossReport($startDate, $endDate, $outputPath = null)
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

    $view = View::make('cgaccounting::profit_and_loass', array(

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

  public function generateCashFlow($startDate, $endDate, $outputPath = null)
  {
    $cashFlowData = DB::table('accpkg_entries as ae')
      ->join('accpkg_accounts as aa', function ($join) {
        $join->on('aa.id', '=', 'ae.from_account');

      })
      ->where('aa.name', 'Cash')
      ->whereBetween('ae.created_at', [$startDate, $endDate])
      ->select('aa.name', 'ae.*')
      ->get();

    $view = View::make('cgaccounting::cash_flow', array(

      'companyName' => $this->companyName,
      'companyAddress' => $this->companyAddress,
      'companyPhone' => $this->companyPhone,
      'companyEmail' => $this->companyEmail,
      'startDate' => $startDate,
      'endDate' => $endDate,
      'cashFlowData' => $cashFlowData
    ));

    $html = $view->render();
    $pathTmp = 'tmp/';
    if (!Storage::exists($pathTmp)) {
      Storage::makeDirectory($pathTmp);
    }
    $mpdf = new Mpdf(['tempDir' => $pathTmp, 'mode' => 'UTF-8', 'format' => 'A4-P', 'autoScriptToLang' => true, 'autoLangToFont' => true]);

    $mpdf->WriteHTML($html);

    $path = 'public/uploads/';
    $fileName = "cash_flow_" . $startDate . '_' . $endDate . '.pdf';

    if (!Storage::exists($path)) {
      Storage::makeDirectory($path);
    }

    $fullPath = storage_path('app/' . $path . $fileName);
    $mpdf->Output($fullPath, \Mpdf\Output\Destination::FILE);

    // Generate file URL
    $fileUrl = url('storage/uploads/' . $fileName);

    return $fileUrl;
  }


  public function generateBalanceSheet($toDate, $outPutPath)
  {

    $cash = DB::table('accpkg_entries as ae')
      ->join('accpkg_accounts as aa', 'aa.id', '=', 'ae.from_account')
      ->where('aa.name', 'Cash')
      ->orderBy('ae.created_at', 'desc')
      ->limit(1)
      ->value('ae.balance');

    $back = DB::table('accpkg_entries as ae')
      ->join('accpkg_accounts as aa', 'aa.id', '=', 'ae.from_account')
      ->where('aa.name', 'Bank')
      ->orderBy('ae.created_at', 'desc')
      ->limit(1)
      ->value('ae.balance');

    $accountsReceivableAccount = Account::where('name', 'Accounts Receivable')->first();
    $accountsReceivable = DB::table('accpkg_entries as ae')
      ->join('accpkg_accounts as aa', function ($join) {
        $join->on('aa.id', '=', 'ae.from_account')
          ->where(function ($query) {
            $query->where('ae.debit', '!=', 0)
              ->orWhere('ae.credit', '!=', 0);
          });
      })
      ->where('aa.parent_id', 12)
      ->select(DB::raw('SUM(ae.balance) as balance'))
      ->orderBy('ae.created_at', 'desc')
      ->limit(1)
      ->value('balance');


    $inventory = DB::table('accpkg_entries as ae')
      ->join('accpkg_accounts as aa', 'aa.id', '=', 'ae.from_account')
      ->where('aa.name', 'Inventory')
      ->orderBy('ae.created_at', 'desc')
      ->limit(1)
      ->value('ae.balance');

    $totalCurrentAssets = $cash + $back + $accountsReceivable + $inventory;

    $fixAssetsAcountBalances = [];
    $totalFixedAssets = 0;
    $fixedAssetsAccount = Account::where('name', 'Fixed Assets')->first();
    $fixAssetsAccounts = Account::where('parent_id', $fixedAssetsAccount->id)->get();
    foreach ($fixAssetsAccounts as $fixAssetsAccount) {
      $fixAssetsAcountBalances[$fixAssetsAccount->name] =
        DB::table('accpkg_entries as ae')
          ->join('accpkg_accounts as aa', 'aa.id', '=', 'ae.from_account')
          ->where('aa.name', $fixAssetsAccount->name)
          ->orderBy('ae.created_at', 'desc')
          ->limit(1)
          ->value('ae.balance');
        $totalFixedAssets += $fixAssetsAcountBalances[$fixAssetsAccount->name];
    }

    $totalAssets = $totalCurrentAssets + $totalFixedAssets;

    $currentLiabilitiesAccount = Account::where('name', 'Current Liabilities')->first();
    $currentLiabilitiesAccounts = Account::where('parent_id', $currentLiabilitiesAccount->id)->get();
    $currentLiabilitiesAcountBalances = [];
    $totalCurrentLiabilities = 0;
    foreach ($currentLiabilitiesAccounts as $currentLiabilitiesAccount) {
      $currentLiabilitiesAcountBalances[$currentLiabilitiesAccount->name] =
        DB::table('accpkg_entries as ae')
          ->join('accpkg_accounts as aa', 'aa.id', '=', 'ae.from_account')
          ->where('aa.name', $currentLiabilitiesAccount->name)
          ->orderBy('ae.created_at', 'desc')
          ->limit(1)
          ->value('ae.balance');
        $totalCurrentLiabilities += $currentLiabilitiesAcountBalances[$currentLiabilitiesAccount->name];
    }

    $longTermLiabilitiesAccount = Account::where('name', 'Long-term Liabilities')->first();
    $longTermLiabilitiesAccounts = Account::where('parent_id', $longTermLiabilitiesAccount->id)->get();
    $longTermLiabilitiesAcountBalances = [];
    $totalLongTermLiabilities = 0;
    foreach ($longTermLiabilitiesAccounts as $longTermLiabilitiesAccount) {
      $longTermLiabilitiesAcountBalances[$longTermLiabilitiesAccount->name] =
        DB::table('accpkg_entries as ae')
          ->join('accpkg_accounts as aa', 'aa.id', '=', 'ae.from_account')
          ->where('aa.name', $longTermLiabilitiesAccount->name)
          ->orderBy('ae.created_at', 'desc')
          ->limit(1)
          ->value('ae.balance');
        $totalLongTermLiabilities += $longTermLiabilitiesAcountBalances[$longTermLiabilitiesAccount->name];
    }

    $totalLiabilities = $totalCurrentLiabilities + $totalLongTermLiabilities;

    $equityAccount = Account::where('name', 'Equity')->first();
    $equityAccounts = Account::where('parent_id', $equityAccount->id)->get();
    $equityAcountBalances = [];
    $totalEquity = 0;
    foreach ($equityAccounts as $equityAccount) {
      $equityAcountBalances[$equityAccount->name] =
        DB::table('accpkg_entries as ae')
          ->join('accpkg_accounts as aa', 'aa.id', '=', 'ae.from_account')
          ->where('aa.name', $equityAccount->name)
          ->orderBy('ae.created_at', 'desc')
          ->limit(1)
          ->value('ae.balance');
        $totalEquity += $equityAcountBalances[$equityAccount->name];
    }

    $totalLiabilitiesAndEquity = $totalLiabilities + $totalEquity;

    $view = View::make('cgaccounting::balance_sheet', array(

      'companyName' => $this->companyName,
      'companyAddress' => $this->companyAddress,
      'companyPhone' => $this->companyPhone,
      'companyEmail' => $this->companyEmail,
      'toDate' => $toDate,
      'cash' => $cash,
      'back' => $back,
      'accountsReceivable' => $accountsReceivable,
      'inventory' => $inventory,
      'totalCurrentAssets' => $totalCurrentAssets,
      'fixAssetsAcountBalances' => $fixAssetsAcountBalances,
      'totalFixedAssets' => $totalFixedAssets,
      'totalAssets' => $totalAssets,
      'currentLiabilitiesAcountBalances' => $currentLiabilitiesAcountBalances,
      'totalCurrentLiabilities' => $totalCurrentLiabilities,
      'longTermLiabilitiesAcountBalances' => $longTermLiabilitiesAcountBalances,
      'totalLongTermLiabilities' => $totalLongTermLiabilities,
      'totalLiabilities' => $totalLiabilities,
      'equityAcountBalances' => $equityAcountBalances,
      'totalEquity' => $totalEquity,
      'totalLiabilitiesAndEquity' => $totalLiabilitiesAndEquity

    ));

    $html = $view->render();
    $pathTmp = 'tmp/';
    if (!Storage::exists($pathTmp)) {
      Storage::makeDirectory($pathTmp);
    }
    $mpdf = new Mpdf(['tempDir' => $pathTmp, 'mode' => 'UTF-8', 'format' => 'A4-P', 'autoScriptToLang' => true, 'autoLangToFont' => true]);

    $mpdf->WriteHTML($html);

    $path = 'public/uploads/';
    $fileName = "balance_sheet_" . $toDate . '.pdf';

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