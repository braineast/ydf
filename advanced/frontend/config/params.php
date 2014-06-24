<?php
return [
    'adminEmail' => 'admin@example.com',
    'loanType' => [\frontend\models\Deal::TYPE_LOAN_UN_AMORTIZED=>'到期本息',
        \frontend\models\Deal::TYPE_LOAN_AMORTIZED_HBFX=>'付息还本',
        \frontend\models\Deal::TYPE_LOAN_AMORTIZED_ETP=>'等额本息'],
];
