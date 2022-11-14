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

        $stmt = Statement::create()
            ->offset(count($csv)-30);
        $records = $stmt->process($csv);

        foreach ($records as $record) {
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
        foreach ($this->companies as $company){
            $count=strlen($company->getName());
            $space=str_repeat(' ',50-$count).'- ';
            $companiesRegister=$companiesRegister.$company->getName().$space.$company->getRegistrationCode().PHP_EOL;
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