<?php

namespace CodGlo\CGAccounting\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Parent accounts
        $assetsId = DB::table('accpkg_accounts')->where('name', 'Assets')->value('id');
        if (!$assetsId) {
            $assetsId = DB::table('accpkg_accounts')->insertGetId(
                ['name' => 'Assets', 'type' => 'assets', 'parent_id' => null, 'ref_id' => null, 'ref_type' => null, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]
            );
        }

        $liabilitiesId = DB::table('accpkg_accounts')->where('name', 'Liabilities')->value('id');
        if (!$liabilitiesId) {
            $liabilitiesId = DB::table('accpkg_accounts')->insertGetId(
                ['name' => 'Liabilities', 'type' => 'liabilities', 'parent_id' => null, 'ref_id' => null, 'ref_type' => null, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]
            );
        }

        $equityId = DB::table('accpkg_accounts')->where('name', 'Equity')->value('id');
        if (!$equityId) {
            $equityId = DB::table('accpkg_accounts')->insertGetId(
                ['name' => 'Equity', 'type' => 'equity', 'parent_id' => null, 'ref_id' => null, 'ref_type' => null, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]
            );
        }

        $incomeId = DB::table('accpkg_accounts')->where('name', 'Income')->value('id');
        if (!$incomeId) {
            $incomeId = DB::table('accpkg_accounts')->insertGetId(
                ['name' => 'Income', 'type' => 'income', 'parent_id' => null, 'ref_id' => null, 'ref_type' => null, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]
            );
        }

        $expensesId = DB::table('accpkg_accounts')->where('name', 'Expenses')->value('id');
        if (!$expensesId) {
            $expensesId = DB::table('accpkg_accounts')->insertGetId(
                ['name' => 'Expenses', 'type' => 'expenses', 'parent_id' => null, 'ref_id' => null, 'ref_type' => null, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]
            );
        }

        // Sub-accounts
        $currentAssetsId = DB::table('accpkg_accounts')->where('name', 'Current Assets')->value('id');
        if (!$currentAssetsId) {
            $currentAssetsId = DB::table('accpkg_accounts')->insertGetId(
                ['name' => 'Current Assets', 'type' => 'assets', 'parent_id' => $assetsId, 'ref_id' => null, 'ref_type' => null, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]
            );
        }

        $fixedAssetsId = DB::table('accpkg_accounts')->where('name', 'Fixed Assets')->value('id');
        if (!$fixedAssetsId) {
            $fixedAssetsId = DB::table('accpkg_accounts')->insertGetId(
                ['name' => 'Fixed Assets', 'type' => 'assets', 'parent_id' => $assetsId, 'ref_id' => null, 'ref_type' => null, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]
            );
        }

        $currentLiabilitiesId = DB::table('accpkg_accounts')->where('name', 'Current Liabilities')->value('id');
        if (!$currentLiabilitiesId) {
            $currentLiabilitiesId = DB::table('accpkg_accounts')->insertGetId(
                ['name' => 'Current Liabilities', 'type' => 'liabilities', 'parent_id' => $liabilitiesId, 'ref_id' => null, 'ref_type' => null, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]
            );
        }

        $longTermLiabilitiesId = DB::table('accpkg_accounts')->where('name', 'Long-term Liabilities')->value('id');
        if (!$longTermLiabilitiesId) {
            $longTermLiabilitiesId = DB::table('accpkg_accounts')->insertGetId(
                ['name' => 'Long-term Liabilities', 'type' => 'liabilities', 'parent_id' => $liabilitiesId, 'ref_id' => null, 'ref_type' => null, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]
            );
        }

        // Detailed accounts for Assets
        $this->insertDetailedAccount('Cash', 'assets', $currentAssetsId);
        $this->insertDetailedAccount('Accounts Receivable', 'assets', $currentAssetsId);
        $this->insertDetailedAccount('Inventory', 'assets', $currentAssetsId);
        $this->insertDetailedAccount('Property, Plant, and Equipment', 'assets', $fixedAssetsId);
        $this->insertDetailedAccount('Accumulated Depreciation', 'assets', $fixedAssetsId);

        // Detailed accounts for Liabilities
        $this->insertDetailedAccount('Accounts Payable', 'liabilities', $currentLiabilitiesId);
        $this->insertDetailedAccount('Short-term Loans', 'liabilities', $currentLiabilitiesId);
        $this->insertDetailedAccount('Long-term Debt', 'liabilities', $longTermLiabilitiesId);

        // Detailed accounts for Equity
        $this->insertDetailedAccount('Owner’s Equity', 'equity', $equityId);
        $this->insertDetailedAccount('Retained Earnings', 'equity', $equityId);

        // Detailed accounts for Income
        $this->insertDetailedAccount('Sales Revenue', 'income', $incomeId);
        $this->insertDetailedAccount('Service Revenue', 'income', $incomeId);
        $this->insertDetailedAccount('Other Income', 'income', $incomeId);

        // Detailed accounts for Expenses
        $this->insertDetailedAccount('Cost of Goods Sold', 'expenses', $expensesId);
        $this->insertDetailedAccount('Salaries Expense', 'expenses', $expensesId);
        $this->insertDetailedAccount('Rent Expense', 'expenses', $expensesId);
        $this->insertDetailedAccount('Utilities Expense', 'expenses', $expensesId);
        $this->insertDetailedAccount('Depreciation Expense', 'expenses', $expensesId);
        $this->insertDetailedAccount('Sales Discount', 'expenses', $expensesId);
        $this->insertDetailedAccount('Sales Returns and Allowances', 'expenses', $expensesId);
        $this->insertDetailedAccount('Other Expenses', 'expenses', $expensesId);

        // Enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    private function insertDetailedAccount($name, $type, $parentId)
    {
        $accountId = DB::table('accpkg_accounts')->where('name', $name)->value('id');
        if (!$accountId) {
            DB::table('accpkg_accounts')->insertGetId(
                ['name' => $name, 'type' => $type, 'parent_id' => $parentId, 'ref_id' => null, 'ref_type' => null, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]
            );
        }
    }
}
