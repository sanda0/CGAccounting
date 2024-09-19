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
        $assetsId = DB::table('accpkg_accounts')->insertOrIgnore(
            ['name' => 'Assets', 'type' => 'assets', 'parent_id' => null, 'ref_id' => null, 'ref_type' => null, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]
        );

        $liabilitiesId = DB::table('accpkg_accounts')->insertOrIgnore(
            ['name' => 'Liabilities', 'type' => 'liabilities', 'parent_id' => null, 'ref_id' => null, 'ref_type' => null, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]
        );

        $equityId = DB::table('accpkg_accounts')->insertOrIgnore(
            ['name' => 'Equity', 'type' => 'equity', 'parent_id' => null, 'ref_id' => null, 'ref_type' => null, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]
        );

        $incomeId = DB::table('accpkg_accounts')->insertOrIgnore(
            ['name' => 'Income', 'type' => 'income', 'parent_id' => null, 'ref_id' => null, 'ref_type' => null, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]
        );

        $expensesId = DB::table('accpkg_accounts')->insertOrIgnore(
            ['name' => 'Expenses', 'type' => 'expenses', 'parent_id' => null, 'ref_id' => null, 'ref_type' => null, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]
        );

        // Sub-accounts
        $currentAssetsId = DB::table('accpkg_accounts')->insertOrIgnore(
            ['name' => 'Current Assets', 'type' => 'assets', 'parent_id' => $assetsId, 'ref_id' => null, 'ref_type' => null, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]
        );

        $fixedAssetsId = DB::table('accpkg_accounts')->insertOrIgnore(
            ['name' => 'Fixed Assets', 'type' => 'assets', 'parent_id' => $assetsId, 'ref_id' => null, 'ref_type' => null, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]
        );

        $currentLiabilitiesId = DB::table('accpkg_accounts')->insertOrIgnore(
            ['name' => 'Current Liabilities', 'type' => 'liabilities', 'parent_id' => $liabilitiesId, 'ref_id' => null, 'ref_type' => null, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]
        );

        $longTermLiabilitiesId = DB::table('accpkg_accounts')->insertOrIgnore(
            ['name' => 'Long-term Liabilities', 'type' => 'liabilities', 'parent_id' => $liabilitiesId, 'ref_id' => null, 'ref_type' => null, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]
        );

        // Detailed accounts for Assets
        DB::table('accpkg_accounts')->insertOrIgnore(
            ['name' => 'Cash', 'type' => 'assets', 'parent_id' => $currentAssetsId, 'ref_id' => null, 'ref_type' => null, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]
        );

        DB::table('accpkg_accounts')->insertOrIgnore(
            ['name' => 'Accounts Receivable', 'type' => 'assets', 'parent_id' => $currentAssetsId, 'ref_id' => null, 'ref_type' => null, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]
        );

        DB::table('accpkg_accounts')->insertOrIgnore(
            ['name' => 'Inventory', 'type' => 'assets', 'parent_id' => $currentAssetsId, 'ref_id' => null, 'ref_type' => null, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]
        );

        DB::table('accpkg_accounts')->insertOrIgnore(
            ['name' => 'Property, Plant, and Equipment', 'type' => 'assets', 'parent_id' => $fixedAssetsId, 'ref_id' => null, 'ref_type' => null, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]
        );

        DB::table('accpkg_accounts')->insertOrIgnore(
            ['name' => 'Accumulated Depreciation', 'type' => 'assets', 'parent_id' => $fixedAssetsId, 'ref_id' => null, 'ref_type' => null, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]
        );

        // Detailed accounts for Liabilities
        DB::table('accpkg_accounts')->insertOrIgnore(
            ['name' => 'Accounts Payable', 'type' => 'liabilities', 'parent_id' => $currentLiabilitiesId, 'ref_id' => null, 'ref_type' => null, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]
        );

        DB::table('accpkg_accounts')->insertOrIgnore(
            ['name' => 'Short-term Loans', 'type' => 'liabilities', 'parent_id' => $currentLiabilitiesId, 'ref_id' => null, 'ref_type' => null, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]
        );

        DB::table('accpkg_accounts')->insertOrIgnore(
            ['name' => 'Long-term Debt', 'type' => 'liabilities', 'parent_id' => $longTermLiabilitiesId, 'ref_id' => null, 'ref_type' => null, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]
        );

        // Detailed accounts for Equity
        DB::table('accpkg_accounts')->insertOrIgnore(
            ['name' => 'Owner’s Equity', 'type' => 'equity', 'parent_id' => $equityId, 'ref_id' => null, 'ref_type' => null, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]
        );

        DB::table('accpkg_accounts')->insertOrIgnore(
            ['name' => 'Retained Earnings', 'type' => 'equity', 'parent_id' => $equityId, 'ref_id' => null, 'ref_type' => null, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]
        );

        // Detailed accounts for Income
        DB::table('accpkg_accounts')->insertOrIgnore(
            ['name' => 'Sales Revenue', 'type' => 'income', 'parent_id' => $incomeId, 'ref_id' => null, 'ref_type' => null, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]
        );

        DB::table('accpkg_accounts')->insertOrIgnore(
            ['name' => 'Service Revenue', 'type' => 'income', 'parent_id' => $incomeId, 'ref_id' => null, 'ref_type' => null, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]
        );

        DB::table('accpkg_accounts')->insertOrIgnore(
            ['name' => 'Other Income', 'type' => 'income', 'parent_id' => $incomeId, 'ref_id' => null, 'ref_type' => null, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]
        );

        // Detailed accounts for Expenses
        DB::table('accpkg_accounts')->insertOrIgnore(
            ['name' => 'Cost of Goods Sold', 'type' => 'expenses', 'parent_id' => $expensesId, 'ref_id' => null, 'ref_type' => null, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]
        );

        DB::table('accpkg_accounts')->insertOrIgnore(
            ['name' => 'Salaries Expense', 'type' => 'expenses', 'parent_id' => $expensesId, 'ref_id' => null, 'ref_type' => null, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]
        );

        DB::table('accpkg_accounts')->insertOrIgnore(
            ['name' => 'Rent Expense', 'type' => 'expenses', 'parent_id' => $expensesId, 'ref_id' => null, 'ref_type' => null, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]
        );

        DB::table('accpkg_accounts')->insertOrIgnore(
            ['name' => 'Utilities Expense', 'type' => 'expenses', 'parent_id' => $expensesId, 'ref_id' => null, 'ref_type' => null, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]
        );

        DB::table('accpkg_accounts')->insertOrIgnore(
            ['name' => 'Depreciation Expense', 'type' => 'expenses', 'parent_id' => $expensesId, 'ref_id' => null, 'ref_type' => null, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]
        );

        DB::table('accpkg_accounts')->insertOrIgnore(
            ['name' => 'Sales Discount', 'type' => 'expenses', 'parent_id' => $expensesId, 'ref_id' => null, 'ref_type' => null, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]
        );

        DB::table('accpkg_accounts')->insertOrIgnore(
            ['name' => 'Sales Returns and Allowances', 'type' => 'expenses', 'parent_id' => $expensesId, 'ref_id' => null, 'ref_type' => null, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]
        );

        DB::table('accpkg_accounts')->insertOrIgnore(
            ['name' => 'Other Expenses', 'type' => 'expenses', 'parent_id' => $expensesId, 'ref_id' => null, 'ref_type' => null, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]
        );

        // Enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
