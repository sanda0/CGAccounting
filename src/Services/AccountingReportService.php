<?php

namespace CodGlo\CGAccounting\Services;

use CodGlo\CGAccounting\Models\Account;
use CodGlo\CGAccounting\Models\Record;

class AccountingReportService
{

  private $companyName;
  private $companyAddress;
  private $companyPhone;
  private $companyEmail;

  public function __construct($companyName, $companyAddress, $companyPhone, $companyEmail){
    $this->companyName = $companyName;
    $this->companyAddress = $companyAddress;
    $this->companyPhone = $companyPhone;
    $this->companyEmail = $companyEmail;
  }
  
  public function generateProfiltAndLossReport($startDate, $endDate){
    // Generate profit and loss report
  }
  
}