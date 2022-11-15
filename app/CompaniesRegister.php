<?php

namespace App;

use League\Csv\Reader;
use League\Csv\Statement;

class CompaniesRegister
{
    private array $companies;

    public function __construct(string $csvFile, string $delimiter)
    {
        $csv = Reader::createFromPath($csvFile);
        $csv->setDelimiter($delimiter);
        $csv->setHeaderOffset(0);
        foreach ($csv as $record) {
            $this->companies[]= new Company($record['name'],$record['regcode']);
        }
    }

    public function getCompanies(): array
    {
        return $this->companies;
    }

    public function getCompaniesRegister(): string
    {
        $companiesRegister='NOSAUKUMS'.str_repeat(' ',41).'- REĢISTRĀCIJAS NUMURS'.PHP_EOL;
        for ($i=count($this->companies)-30; $i<count($this->companies); $i++){
            $selectedCompany=$this->companies[$i];
            $count=strlen($selectedCompany->getName());
            $space=str_repeat(' ',50-$count).'- ';
            $companiesRegister=$companiesRegister.$selectedCompany->getName().$space.$selectedCompany->getRegistrationCode().PHP_EOL;
        }
        return $companiesRegister;
    }

    public function searchByName(string $name): string
    {
        foreach ($this->companies as $company){
            if ($company->getName()==$name){
                return PHP_EOL."Uzņēmums '$name' tika atrasts, tā reģistrācijas numurs ir {$company->getRegistrationCode()}.";
            }
        }
        return PHP_EOL."Uzņēmums '$name' netika atrasts!";
    }

    public function searchByRegistrationCode(string $registrationCode): string
    {
        foreach ($this->companies as $company){
            if ($company->getRegistrationCode()==$registrationCode){
                return PHP_EOL."Uzņēmums ar reģistrācijas numuru: $registrationCode tika atrasts, tās nosaukums ir '{$company->getName()}'.";
            }
        }
        return PHP_EOL."Uzņēmums ar reģistrācijas numuru $registrationCode netika atrasts!";
    }
}