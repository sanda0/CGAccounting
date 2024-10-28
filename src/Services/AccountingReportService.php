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

  //format pdf or html
  public function generateProfitAndLossReport($startDate, $endDate, $outputPath = null, $format = 'pdf')
  {
    // Generate profit and loss report
    //incomes
    //sales income

    $income = Account::where('name', 'Income')->first();

    $incomeAccountsBalances = [];
    $totalIncome = 0;
    $incomeAccounts = Account::where('parent_id', $income->id)->get();

    foreach ($incomeAccounts as $incomeAccount) {
      $incomeAccountsBalances[$incomeAccount->name] = $incomeAccount->balanceAtDateRange($startDate, $endDate);
      $totalIncome += $incomeAccountsBalances[$incomeAccount->name];
    }



    //expenses
    //Cost of Goods Sold
    $costOfGoodsSold = Account::where('name', 'Cost of Goods Sold')->first()->balanceAtDateRange($startDate, $endDate);

    // gross profit
    $grossProfit = $totalIncome - $costOfGoodsSold;

    //other expenses account balances
    $otherExpensesAccountBlances = [];
    $totalExpenses = 0;

    $expenses = Account::where('name', 'Expenses')->first();
    $expensesAccounts = Account::where('parent_id', $expenses->id)
      ->where('name', '!=', 'Cost of Goods Sold')
      ->get();
    
    foreach ($expensesAccounts as $expensesAccount) {
      $otherExpensesAccountBlances[$expensesAccount->name] = $expensesAccount->balanceAtDateRange($startDate, $endDate);
      $totalExpenses += $otherExpensesAccountBlances[$expensesAccount->name];
    }

  


    $netProfit = $grossProfit - $totalExpenses;

    $view = View::make('cgaccounting::profit_and_loass', array(

      'companyName' => $this->companyName,
      'companyAddress' => $this->companyAddress,
      'companyPhone' => $this->companyPhone,
      'companyEmail' => $this->companyEmail,
      'startDate' => $startDate,
      'endDate' => $endDate,
      'incomeAccountsBalances' => $incomeAccountsBalances,
      'totalIncome' => $totalIncome,
      'costOfGoodsSold' => $costOfGoodsSold,
      'grossProfit' => $grossProfit,
      'otherExpensesAccountBlances' => $otherExpensesAccountBlances,
      'totalExpenses' => $totalExpenses,
      'netProfit' => $netProfit

    ));
    $html = $view->render();

    if ($format == 'html') {
      return $html;
    }


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

    if (Storage::exists($path . $fileName)) {
      Storage::delete($path . $fileName);
    }

    if (!Storage::exists($path)) {
      Storage::makeDirectory($path);
    }

    $fullPath = storage_path('app/' . $path . $fileName);
    $mpdf->Output($fullPath, \Mpdf\Output\Destination::FILE);

    // Generate file URL
    $fileUrl = url('storage/uploads/' . $fileName);

    return $fileUrl;


  }

  public function generateCashFlow($startDate, $endDate, $outputPath = null,$format = 'pdf')
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

    if ($format == 'html') {
      return $html;
    }

    $pathTmp = 'tmp/';
    if (!Storage::exists($pathTmp)) {
      Storage::makeDirectory($pathTmp);
    }
    $mpdf = new Mpdf(['tempDir' => $pathTmp, 'mode' => 'UTF-8', 'format' => 'A4-P', 'autoScriptToLang' => true, 'autoLangToFont' => true]);

    $mpdf->WriteHTML($html);

    $path = 'public/uploads/';
    $fileName = "cash_flow_" . $startDate . '_' . $endDate . '.pdf';

    if (Storage::exists($path . $fileName)) {
      Storage::delete($path . $fileName);
    }

    if (!Storage::exists($path)) {
      Storage::makeDirectory($path);
    }

    $fullPath = storage_path('app/' . $path . $fileName);
    $mpdf->Output($fullPath, \Mpdf\Output\Destination::FILE);

    // Generate file URL
    $fileUrl = url('storage/uploads/' . $fileName);

    return $fileUrl;
  }


  public function generateBalanceSheet($toDate, $outPutPath = null,$format = 'pdf')
  {

    $currentAssetsAccount = Account::where('name', 'Current Assets')->first();
    $currentAssetsAccounts = Account::where('parent_id', $currentAssetsAccount->id)->get();
    $currentAssetsAcountBalances = [];
    $totalCurrentAssets = 0;
    foreach ($currentAssetsAccounts as $currentAssetsAccount) {
      $currentAssetsAcountBalances[$currentAssetsAccount->name] = $currentAssetsAccount->balance($toDate);
      $totalCurrentAssets += $currentAssetsAcountBalances[$currentAssetsAccount->name];
    }


    $fixAssetsAcountBalances = [];
    $totalFixedAssets = 0;
    $fixedAssetsAccount = Account::where('name', 'Fixed Assets')->first();
    $fixAssetsAccounts = Account::where('parent_id', $fixedAssetsAccount->id)->get();
    foreach ($fixAssetsAccounts as $fixAssetsAccount) {
      $fixAssetsAcountBalances[$fixAssetsAccount->name] = $fixAssetsAccount->balance($toDate);
      $totalFixedAssets += $fixAssetsAcountBalances[$fixAssetsAccount->name];
    }

    $totalAssets = $totalCurrentAssets + $totalFixedAssets;

    $currentLiabilitiesAccount = Account::where('name', 'Current Liabilities')->first();
    $currentLiabilitiesAccounts = Account::where('parent_id', $currentLiabilitiesAccount->id)->get();
    $currentLiabilitiesAcountBalances = [];
    $totalCurrentLiabilities = 0;
    foreach ($currentLiabilitiesAccounts as $currentLiabilitiesAccount) {
      $currentLiabilitiesAcountBalances[$currentLiabilitiesAccount->name] = $currentLiabilitiesAccount->balance($toDate);
      $totalCurrentLiabilities += $currentLiabilitiesAcountBalances[$currentLiabilitiesAccount->name];
    }

    $longTermLiabilitiesAccount = Account::where('name', 'Long-term Liabilities')->first();
    $longTermLiabilitiesAccounts = Account::where('parent_id', $longTermLiabilitiesAccount->id)->get();
    $longTermLiabilitiesAcountBalances = [];
    $totalLongTermLiabilities = 0;
    foreach ($longTermLiabilitiesAccounts as $longTermLiabilitiesAccount) {
      $longTermLiabilitiesAcountBalances[$longTermLiabilitiesAccount->name] = $longTermLiabilitiesAccount->balance($toDate);
      $totalLongTermLiabilities += $longTermLiabilitiesAcountBalances[$longTermLiabilitiesAccount->name];
    }

    $totalLiabilities = $totalCurrentLiabilities + $totalLongTermLiabilities;

    $income = Account::where('name', 'Income')->first();
    $expenses = Account::where('name', 'Expenses')->first();

    $netProfit = $income->balance($toDate) - $expenses->balance($toDate);

    $equityAccount = Account::where('name', 'Equity')->first();
    $equityAccounts = Account::where('parent_id', $equityAccount->id)->get();
    $equityAcountBalances = [];
    $totalEquity = 0;
    foreach ($equityAccounts as $equityAccount) {
      if ($equityAccount->name == 'Retained Earnings') {
        $equityAcountBalances[$equityAccount->name] = $netProfit;
      } else {
        $equityAcountBalances[$equityAccount->name] = $equityAccount->balance($toDate);
      }
      $totalEquity += $equityAcountBalances[$equityAccount->name];
    }

    $totalLiabilitiesAndEquity = $totalLiabilities + $totalEquity;

    $view = View::make('cgaccounting::balance_sheet', array(

      'companyName' => $this->companyName,
      'companyAddress' => $this->companyAddress,
      'companyPhone' => $this->companyPhone,
      'companyEmail' => $this->companyEmail,
      'toDate' => $toDate,
      'currentAssetsAcountBalances' => $currentAssetsAcountBalances, // key => value array,
      'totalCurrentAssets' => $totalCurrentAssets,
      'fixAssetsAcountBalances' => $fixAssetsAcountBalances, // key => value array,
      'totalFixedAssets' => $totalFixedAssets,
      'totalAssets' => $totalAssets,
      'currentLiabilitiesAcountBalances' => $currentLiabilitiesAcountBalances, // key => value array,
      'totalCurrentLiabilities' => $totalCurrentLiabilities,
      'longTermLiabilitiesAcountBalances' => $longTermLiabilitiesAcountBalances, // key => value array,
      'totalLongTermLiabilities' => $totalLongTermLiabilities,
      'totalLiabilities' => $totalLiabilities,
      'equityAcountBalances' => $equityAcountBalances, // key => value array,
      'totalEquity' => $totalEquity,
      'totalLiabilitiesAndEquity' => $totalLiabilitiesAndEquity

    ));

    $html = $view->render();

    if ($format == 'html') {
      return $html;
    }

    $pathTmp = 'tmp/';
    if (!Storage::exists($pathTmp)) {
      Storage::makeDirectory($pathTmp);
    }
    $mpdf = new Mpdf(['tempDir' => $pathTmp, 'mode' => 'UTF-8', 'format' => 'A4-P', 'autoScriptToLang' => true, 'autoLangToFont' => true]);

    $mpdf->WriteHTML($html);

    $path = 'public/uploads/';
    $fileName = "balance_sheet_" . $toDate . '.pdf';

    if (Storage::exists($path . $fileName)) {
      Storage::delete($path . $fileName);
    }

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