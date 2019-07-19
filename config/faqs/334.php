<?php

return [
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
        'question' => 'Do I need fridge stand for {PRODUCT_NAME} ?',
        'answers'  => [
            'No , you don’t need fridge stand',
        ],
        'data'     => [
            'field'  => 'desc_json',
            'json'   => false,
            'key'    => '',
            'search' => '',
        ]
    ],
    [
        'question' => 'Does {PRODUCT_NAME} come with Manual Defrost or Auto Defrost ?',
        'answers'  => [
            'The defrosting type for {PRODUCT_NAME} is {TYPE}',
        ],
        'data'     => [
            'field'   => 'desc_json',
            'json'    => true,
            'key'     => 'Defrosting Type',
            'search'  => '',
            'replace' => '{TYPE}',
        ]
    ],
    [
        'question' => 'Is {PRODUCT_NAME} comes with a warranty ? If yes, how many years ?',
        'answers'  => [
            'Yes, {WARRANTY}.',
        ],
        'data'     => [
            'field'   => 'desc_json',
            'json'    => true,
            'key'     => 'Warranty Summary',
            'search'  => '',
            'replace' => '{WARRANTY}',
        ]
    ],
    [
        'question' => 'Does {PRODUCT_NAME} make noise ?',
        'answers'  => [
            'No, The modern day refrigerators including {PRODUCT_NAME} does not make noticeable noise. Just very little sound at the time of switch-on.',
        ],
        'data'     => [
            'field'  => 'desc_json',
            'json'   => false,
            'key'    => '',
            'search' => '',
        ]
    ],
    [
        'question' => 'Does {PRODUCT_NAME} have an egg tray ?',
        'answers'  => [
            'Yes, {PRODUCT_NAME} has an egg tray.',
        ],
        'data'     => [
            'field'  => 'energy_rating',
            'json'   => false,
            'key'    => '',
            'search' => '',
        ]
    ],
    [
        'question' => 'What is the enery star rating for {PRODUCT_NAME} ?',
        'answers'  => [
            'The energy star rating for {PRODUCT_NAME} is {RATING}',
        ],
        'data'     => [
            'field'   => 'energy_rating',
            'json'    => false,
            'key'     => '',
            'search'  => '',
            'replace' => '{RATING}',
        ]
    ],
    [
        'question' => 'How many doors does {PRODUCT_NAME} has ?',
        'answers'  => [
            '{PRODUCT_NAME} has {DOORS} door(s)',
        ],
        'data'     => [
            'field'   => 'desc_json',
            'json'    => true,
            'key'     => 'Number of Doors',
            'search'  => '',
            'replace' => '{DOORS}',
        ]
    ],
];