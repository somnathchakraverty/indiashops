<?php

return [
    /*This Array Denotes One Question*/
    [
        'question' => 'What is the weight of {PRODUCT_NAME} ?',
        'answers'  => [
            /*First Answer Is always yes..*/
            'It weighs {weight}',
        ],
        'data'     => [
            'field'   => 'desc_json',
            'json'    => true,
            'key'     => 'Weight',
            'search'  => 'yes',
            'replace' => '{weight}'
        ]
    ],
    [
        'question' => 'What is the sensor type ?',
        'answers'  => [
            /*First Answer Is always yes..*/
            'Sensor type of this camera is {Sensor}',
        ],
        'data'     => [
            'field'   => 'desc_json',
            'json'    => true,
            'key'     => 'Sensor Type',
            'search'  => 'yes',
            'replace' => '{Sensor}',
        ]
    ],
    [
        'question' => 'What is the optical zoom range for this camera ?',
        'answers'  => [
            /*First Answer Is always yes..*/
            'The optical zoom range is {optical}',
        ],
        'data'     => [
            'field'   => 'desc_json',
            'json'    => true,
            'key'     => 'Optical Zoom',
            'search'  => 'mm',
            'replace' => '{optical}'
        ]
    ],
    [
        'question' => 'Can I use this camera for video recording ?',
        'answers'  => [
            /*First Answer Is always yes..*/
            'Yes, it can be used for video recording. The mode needs to be set to Video.',
        ],
        'data'     => [
            'field'  => 'desc_json',
            'json'   => true,
            'key'    => '',
            'search' => '',
        ]
    ],
    [
        'question' => 'Is it a digital SLR camera ?',
        'answers'  => [
            /*First Answer Is always yes..*/
            'Yes, it is Digital SLR (DSLR).',
        ],
        'data'     => [
            'field'  => 'desc_json',
            'json'   => true,
            'key'    => '',
            'search' => '',
        ]
    ],
    [
        'question' => 'Will I get lens kit with {PRODUCT_NAME} ?',
        'answers'  => [
            /*First Answer Is always yes..*/
            'Yes, it will come with lens kit.',
            'No, it does not comes with lens kit.',
        ],
        'data'     => [
            'field'  => 'desc_json',
            'json'   => true,
            'key'    => 'SLR Variant',
            'search' => 'lens',
        ]
    ],
    [
        'question' => 'Does it come with a rechargeable battery ?',
        'answers'  => [
            /*First Answer Is always yes..*/
            'Yes, it comes with rechargeable Lithium ion battery.',
        ],
        'data'     => [
            'field'  => 'type',
            'json'   => false,
            'key'    => '',
            'search' => '',
        ]
    ],
    [
        'question' => 'Does it have external storage feature ?',
        'answers'  => [
            /*First Answer Is always yes..*/
            'Yes, it has a memory card slot which can host extra storage as per card’s capacity.',
        ],
        'data'     => [
            'field'  => 'desc_json',
            'json'   => true,
            'key'    => 'Rear Flash',
            'search' => 'yes',
        ]
    ],
    [
        'question' => 'Does it have internal storage ?',
        'answers'  => [
            /*First Answer Is always yes..*/
            'No , it doesn\'t have internal storage.',
        ],
        'data'     => [
            'field'  => 'type',
            'json'   => false,
            'key'    => '',
            'search' => '',
        ]
    ],
    [
        'question' => 'Is it good for beginners ?',
        'answers'  => [
            /*First Answer Is always yes..*/
            'It is a good camera. No matter if you are beginner or professional it is worth the buy. The features are really useful especially Focus Mode. As a beginner you can learn gradually all the features. Picture quality of {PIXEL} will give good stunning photos.',
        ],
        'data'     => [
            'field'   => 'desc_json',
            'json'    => true,
            'key'     => 'Effective Pixels',
            'search'  => '',
            'replace' => '{PIXEL}',
        ]
    ],
    [
        'question' => 'Does it have a self-timer feature ?',
        'answers'  => [
            /*First Answer Is always yes..*/
            'Yes, it has an inbuilt self-timer as a feature for convenience.',
        ],
        'data'     => [
            'field'  => 'desc_json',
            'json'   => true,
            'key'    => '',
            'search' => '',
        ]
    ],
];