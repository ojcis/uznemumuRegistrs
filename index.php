<?php

require_once 'vendor/autoload.php';

use App\CompaniesRegister;

$companies=new CompaniesRegister('register.csv',';');
while (true) {
    while (true){
        echo "[1] Apskatīt pēdējos 30 ierakstus uzņēmuma reģistrā.".PHP_EOL;
        echo "[2] Meklēt uzņēmuma reģistrācijas numuru pēc uzņēmuma nosaukuma.".PHP_EOL;
        echo "[3] Meklēt uzņēmuma nosaukumu pēc reģistrācijas numura.".PHP_EOL;
        echo "[4] Iziet no aplikācijas.".PHP_EOL;
        $choice = readline('Izvēlies numuru darbībai ko vēlies veikt: ');
        switch ($choice){
            case 1:
                echo PHP_EOL."UZŅĒMUMU REĢISTRS:".PHP_EOL;
                echo $companies->getCompaniesRegister();
                break;
            case 2:
                $name=readline('Ievadi uzņēmuma nosaukumu: ');
                echo $companies->searchByName($name).PHP_EOL;
                break;
            case 3:
                $registrationCode=readline('Ievadi uzņēmuma reģistrācijas numuru: ');
                echo $companies->searchByRegistrationCode($registrationCode).PHP_EOL;
                break;
            case 4:
                exit('Uz redzēšanos!'.PHP_EOL);
            default:
                echo PHP_EOL."Nekorekta ievade!";
        }
        echo PHP_EOL;
    }
}
