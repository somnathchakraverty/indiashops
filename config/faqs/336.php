<?php

return [
    /*This Array Denotes One Question*/
    [
        'question' => 'Does {PRODUCT_NAME} need a stabilizer ?',
        'answers'  => [
            /*First Answer Is always yes..*/
            'In case you get steady voltage without fluctuations then there is no need of stabilizer. However , it is always advisable to use stabilizer for safety of the {PRODUCT_NAME}.',
        ],
        'data'     => [
            'field'  => 'desc_json',
            'json'   => false,
            'key'    => '',
            'search' => '',
        ]
    ],
    [
        'question' => 'Does {PRODUCT_NAME} have copper condenser or aluminium condenser ?',
        'answers'  => [
            'The condenser coil of {PRODUCT_NAME} is of {COIL}',
        ],
        'data'     => [
            'field'   => 'desc_json',
            'json'    => true,
            'key'     => 'Condenser Coil',
            'search'  => '',
            'replace' => '{COIL}',
        ]
    ],
    [
        'question' => 'Do I get free installation for {PRODUCT_NAME} ?',
        'answers'  => [
            '{DETAILS}',
            'No, {PRODUCT_NAME} doesn\'t comes with free installation',
        ],
        'data'     => [
            'field'   => 'desc_json',
            'json'    => true,
            'key'     => 'Installation Details',
            'search'  => '',
            'replace' => '{DETAILS}',
        ]
    ],
    [
        'question' => 'Can I use {PRODUCT_NAME} in winters for heating ?',
        'answers'  => [
            'Yes, you can use {PRODUCT_NAME} in winters for heating.',
            'No , there is no heating available in {PRODUCT_NAME}',
        ],
        'data'     => [
            'field'  => 'desc_json',
            'json'   => true,
            'key'    => 'Cooling and Heating',
            'search' => 'Yes',
        ]
    ],
    [
        'question' => 'Is {PRODUCT_NAME} comes with a warranty ? If yes, how many years ?',
        'answers'  => [
            '{WARRANTY}',
        ],
        'data'     => [
            'field'   => 'desc_json',
            'json'    => true,
            'key'     => 'Warranty',
            'search'  => '',
            'replace' => '{WARRANTY}',
        ]
    ],
    [
        'question' => 'What is the star-rating  of {PRODUCT_NAME} ?',
        'answers'  => [
            'The star rating of {PRODUCT_NAME} is {Rating}',
        ],
        'data'     => [
            'field'   => 'energy_rating',
            'json'    => false,
            'key'     => '',
            'search'  => '',
            'replace' => '{Rating}',
        ]
    ],
    [
        'question' => 'Is {PRODUCT_NAME} an anti-bacterial AC ?',
        'answers'  => [
            'Yes, {PRODUCT_NAME} comes with anti-bacterial feature.',
            'No , {PRODUCT_NAME} does not have anti-bacterial feature.',
        ],
        'data'     => [
            'field'  => 'desc_json',
            'json'   => true,
            'key'    => 'Anti-bacteria Filter',
            'search' => 'Yes',
        ]
    ],
];