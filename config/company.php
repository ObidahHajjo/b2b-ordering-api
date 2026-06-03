<?php

return [
    'name' => 'Ty Delice',
    'location' => 'Landaul, Morbihan',
    'activity' => 'Patisserie industrielle pour professionnels',
    'phone' => '+33 2 00 00 00 00',
    'email' => 'contact@tydelice.fr',
    'suppliers' => [
        'Producteurs bretons',
        'Importateurs specialises',
        'Fournisseurs de confiserie',
    ],
    'shipping' => [
        'strategy' => 'weight_tiers',
        'tiers' => [
            ['max_weight' => 10, 'price' => 15.00],
            ['max_weight' => 25, 'price' => 25.00],
            ['max_weight' => 50, 'price' => 40.00],
            ['max_weight' => null, 'price' => 65.00],
        ],
    ],
];
