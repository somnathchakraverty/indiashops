<?php

return [
    /*This Array Denotes One Question*/
    [
        'question' => 'Can I make a call with {PRODUCT_NAME} ?',
        'answers'  => [
            /*First Answer Is always yes..*/
            'Yes, using Apps like Skype and with active internet you can make calls.',
        ],
        'data'     => [
            'field'  => 'desc_json',
            'json'   => true,
            'key'    => '',
            'search' => '',
        ]
    ],
    [
        'question' => 'Does it has single sim configuration ?',
        'answers'  => [
            /*First Answer Is always yes..*/
            'Yes, it has a SIM configuration.',
            'No, it doesn\'t have SIM configuration.',
        ],
        'data'     => [
            'field'  => 'desc_json',
            'json'   => true,
            'key'    => 'SIM Configuration',
            'search' => 'Yes',
        ]
    ],
    [
        'question' => 'Can I charge it with USB cable ?',
        'answers'  => [
            /*First Answer Is always yes..*/
            'Tablets require high charging capacity with specific voltage and current ratings. The charger which comes in the package is ideal for charging {PRODUCT_NAME}. With USB it may not get appropriate charging and may damage the device.',
        ],
        'data'     => [
            'field'  => 'desc_json',
            'json'   => true,
            'key'    => '',
            'search' => '',
        ]
    ],
    [
        'question' => 'What is the weight of {PRODUCT_NAME} ?',
        'answers'  => [
            /*First Answer Is always yes..*/
            'It weighs {Weight}',
        ],
        'data'     => [
            'field'  => 'desc_json',
            'json'   => true,
            'key'    => 'Weight',
            'search' => '',
            'replace' => '{Weight}',
        ]
    ],
    [
        'question' => 'What is the internal Storage capacity of this tablet ?',
        'answers'  => [
            /*First Answer Is always yes..*/
            'The internal storage capacity of this tablet is {INTERNAL}',
        ],
        'data'     => [
            'field'  => 'desc_json',
            'json'   => true,
            'key'    => 'Internal',
            'search' => '',
            'replace' => '{INTERNAL}',
        ]
    ],
    [
        'question' => 'Can I watch online videos on it ?',
        'answers'  => [
            /*First Answer Is always yes..*/
            'Yes definitely , All you need is good internet connection to watch online videos.',
        ],
        'data'     => [
            'field'  => 'desc_json',
            'json'   => true,
            'key'    => '',
            'search' => '',
        ]
    ],
    [
        'question' => 'Does it have extended memory slot ?',
        'answers'  => [
            /*First Answer Is always yes..*/
            'Yes, it has an expandable memory slot.',
            'No, it does not have an expandable memory slot.',
        ],
        'data'     => [
            'field'  => 'desc_json',
            'json'   => true,
            'key'    => 'Expandable',
            'search' => 'Yes',
        ]
    ],
    [
        'question' => 'Can we use Facebook or WhatsApp ?',
        'answers'  => [
            /*First Answer Is always yes..*/
            'Yes, You can download Facebook and WhatsApp apps and use',
        ],
        'data'     => [
            'field'  => 'desc_json',
            'json'   => true,
            'key'    => '',
            'search' => '',
        ]
    ],
    [
        'question' => 'Can I make Skype call ?',
        'answers'  => [
            /*First Answer Is always yes..*/
            'Yes , you can download Skype App and with good internet connection can make Skype calls for free.',
        ],
        'data'     => [
            'field'  => 'desc_json',
            'json'   => true,
            'key'    => '',
            'search' => '',
        ]
    ],
    [
        'question' => 'Does it have Bluetooth and Wi-Fi features ?',
        'answers'  => [
            /*First Answer Is always yes..*/
            'Yes, it has Wi-Fi and Bluetooth connectivities.',
        ],
        'data'     => [
            'field'  => 'desc_json',
            'json'   => true,
            'key'    => '',
            'search' => '',
        ]
    ],
];