<?php

$offices = range(1,20);
$employees = ['1-10','11-50','51-100','101-200','201-300','301-600','601-1000','1001-1500','1501-2000','2001-2500','2501-3000','3001-3500','3501-4000','4001-4500','4501-5000','5000+'];
$years = range(date('Y'), 1900);

return ['offices' => $offices, 'employees' => $employees, 'years' => $years];

