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
        $assetsId = DB::table('accpkg_accounts')->firstOrCreate(
            ['name' => 'Assets', 'type' => 'assets', 'parent_id' => null],
            ['ref_id' => null, 'ref_type' => null, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]
        )->id;

        $liabilitiesId = DB::table('accpkg_accounts')->firstOrCreate(
            ['name' => 'Liabilities', 'type' => 'liabilities', 'parent_id' => null],
            ['ref_id' => null, 'ref_type' => null, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]
        )->id;

        $equityId = DB::table('accpkg_accounts')->firstOrCreate(
            ['name' => 'Equity', 'type' => 'equity', 'parent_id' => null],
            ['ref_id' => null, 'ref_type' => null, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]
        )->id;

        $incomeId = DB::table('accpkg_accounts')->firstOrCreate(
            ['name' => 'Income', 'type' => 'income', 'parent_id' => null],
            ['ref_id' => null, 'ref_type' => null, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]
        )->id;

        $expensesId = DB::table('accpkg_accounts')->firstOrCreate(
            ['name' => 'Expenses', 'type' => 'expenses', 'parent_id' => null],
            ['ref_id' => null, 'ref_type' => null, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]
        )->id;

        // Sub-accounts
        $currentAssetsId = DB::table('accpkg_accounts')->firstOrCreate(
            ['name' => 'Current Assets', 'type' => 'assets', 'parent_id' => $assetsId],
            ['ref_id' => null, 'ref_type' => null, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]
        )->id;

        $fixedAssetsId = DB::table('accpkg_accounts')->firstOrCreate(
            ['name' => 'Fixed Assets', 'type' => 'assets', 'parent_id' => $assetsId],
            ['ref_id' => null, 'ref_type' => null, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]
        )->id;

        $currentLiabilitiesId = DB::table('accpkg_accounts')->firstOrCreate(
            ['name' => 'Current Liabilities', 'type' => 'liabilities', 'parent_id' => $liabilitiesId],
            ['ref_id' => null, 'ref_type' => null, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]
        )->id;

        $longTermLiabilitiesId = DB::table('accpkg_accounts')->firstOrCreate(
            ['name' => 'Long-term Liabilities', 'type' => 'liabilities', 'parent_id' => $liabilitiesId],
            ['ref_id' => null, 'ref_type' => null, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]
        )->id;

        // Detailed accounts for Assets
        DB::table('accpkg_accounts')->firstOrCreate(
            ['name' => 'Cash', 'type' => 'assets', 'parent_id' => $currentAssetsId],
            ['ref_id' => null, 'ref_type' => null, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]
        );

        DB::table('accpkg_accounts')->firstOrCreate(
            ['name' => 'Accounts Receivable', 'type' => 'assets', 'parent_id' => $currentAssetsId],
            ['ref_id' => null, 'ref_type' => null, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]
        );

        DB::table('accpkg_accounts')->firstOrCreate(
            ['name' => 'Inventory', 'type' => 'assets', 'parent_id' => $currentAssetsId],
            ['ref_id' => null, 'ref_type' => null, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]
        );

        DB::table('accpkg_accounts')->firstOrCreate(
            ['name' => 'Property, Plant, and Equipment', 'type' => 'assets', 'parent_id' => $fixedAssetsId],
            ['ref_id' => null, 'ref_type' => null, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]
        );

        DB::table('accpkg_accounts')->firstOrCreate(
            ['name' => 'Accumulated Depreciation', 'type' => 'assets', 'parent_id' => $fixedAssetsId],
            ['ref_id' => null, 'ref_type' => null, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]
        );

        // Detailed accounts for Liabilities
        DB::table('accpkg_accounts')->firstOrCreate(
            ['name' => 'Accounts Payable', 'type' => 'liabilities', 'parent_id' => $currentLiabilitiesId],
            ['ref_id' => null, 'ref_type' => null, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]
        );

        DB::table('accpkg_accounts')->firstOrCreate(
            ['name' => 'Short-term Loans', 'type' => 'liabilities', 'parent_id' => $currentLiabilitiesId],
            ['ref_id' => null, 'ref_type' => null, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]
        );

        DB::table('accpkg_accounts')->firstOrCreate(
            ['name' => 'Long-term Debt', 'type' => 'liabilities', 'parent_id' => $longTermLiabilitiesId],
            ['ref_id' => null, 'ref_type' => null, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]
        );

        // Detailed accounts for Equity
        DB::table('accpkg_accounts')->firstOrCreate(
            ['name' => 'Owner’s Equity', 'type' => 'equity', 'parent_id' => $equityId],
            ['ref_id' => null, 'ref_type' => null, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]
        );

        DB::table('accpkg_accounts')->firstOrCreate(
            ['name' => 'Retained Earnings', 'type' => 'equity', 'parent_id' => $equityId],
            ['ref_id' => null, 'ref_type' => null, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]
        );

        // Detailed accounts for Income
        DB::table('accpkg_accounts')->firstOrCreate(
            ['name' => 'Sales Revenue', 'type' => 'income', 'parent_id' => $incomeId],
            ['ref_id' => null, 'ref_type' => null, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]
        );

        DB::table('accpkg_accounts')->firstOrCreate(
            ['name' => 'Service Revenue', 'type' => 'income', 'parent_id' => $incomeId],
            ['ref_id' => null, 'ref_type' => null, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]
        );

        DB::table('accpkg_accounts')->firstOrCreate(
            ['name' => 'Other Income', 'type' => 'income', 'parent_id' => $incomeId],
            ['ref_id' => null, 'ref_type' => null, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]
        );

        // Detailed accounts for Expenses
        DB::table('accpkg_accounts')->firstOrCreate(
            ['name' => 'Cost of Goods Sold', 'type' => 'expenses', 'parent_id' => $expensesId],
            ['ref_id' => null, 'ref_type' => null, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]
        );

        DB::table('accpkg_accounts')->firstOrCreate(
            ['name' => 'Salaries Expense', 'type' => 'expenses', 'parent_id' => $expensesId],
            ['ref_id' => null, 'ref_type' => null, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]
        );

        DB::table('accpkg_accounts')->firstOrCreate(
            ['name' => 'Rent Expense', 'type' => 'expenses', 'parent_id' => $expensesId],
            ['ref_id' => null, 'ref_type' => null, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]
        );

        DB::table('accpkg_accounts')->firstOrCreate(
            ['name' => 'Utilities Expense', 'type' => 'expenses', 'parent_id' => $expensesId],
            ['ref_id' => null, 'ref_type' => null, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]
        );

        DB::table('accpkg_accounts')->firstOrCreate(
            ['name' => 'Depreciation Expense', 'type' => 'expenses', 'parent_id' => $expensesId],
            ['ref_id' => null, 'ref_type' => null, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]
        );

        DB::table('accpkg_accounts')->firstOrCreate(
            ['name' => 'Sales Discount', 'type' => 'expenses', 'parent_id' => $expensesId],
            ['ref_id' => null, 'ref_type' => null, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]
        );

        DB::table('accpkg_accounts')->firstOrCreate(
            ['name' => 'Sales Returns and Allowances', 'type' => 'expenses', 'parent_id' => $expensesId],
            ['ref_id' => null, 'ref_type' => null, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]
        );

        DB::table('accpkg_accounts')->firstOrCreate(
            ['name' => 'Other Expenses', 'type' => 'expenses', 'parent_id' => $expensesId],
            ['ref_id' => null, 'ref_type' => null, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]
        );

        // Enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
