<?php

return [
    /*This Array Denotes One Question*/
    [
        'question' => 'Does {PRODUCT_NAME} supports 4G ?',
        'answers'  => [
            /*First Answer Is always yes..*/
            'Yes, the device supports 4G. The range coverage is pretty good as per 4G standards.',
            'No, the device does not support 4G. However, it does support lower versions of networks with a pretty good coverage.',
        ],
        'data'     => [
            'field'  => 'desc_json',
            'json'   => true,
            'key'    => '4G',
            'search' => 'yes',
        ]
    ],
    [
        'question' => 'Does it support voice on LTE ?',
        'answers'  => [
            /*First Answer Is always yes..*/
            'Yes, it supports voice on LTE. You can use this phone with Reliance Jio SIM. With Voice over LTE (VOLTE) technology, you can save on calls costs as the calls are done using data. Reliance Jio and other operators have started giving very attractive data pricing.',
            'No, it does not support voice on LTE (VOLTE). However, it does support standard data connection using which voice calls can be done via Apps like WhatsApp, Skype.',
        ],
        'data'     => [
            'field'  => 'desc_json',
            'json'   => true,
            'key'    => 'Voice Over LTE (VoLTE)',
            'search' => 'yes',
        ]
    ],
    [
        'question' => 'Does it support Facebook or WhatsApp ?',
        'answers'  => [
            /*First Answer Is always yes..*/
            'Yes, it is a Smartphone. It has the App store from where all the published Apps including, Facebook, WhatsApp can be downloaded. You need either data connection or WiFi.',
            'No, it is a feature phone. It does not support, Facebook, WhatsApp etc. The price for the phone is very attractive for the feature phone.',
        ],
        'data'     => [
            'field'  => 'type',
            'json'   => false,
            'key'    => 'type',
            'search' => 'smartphone',
        ]
    ],
    [
        'question' => 'Does {PRODUCT_NAME} have a single micro sim or dual sim ?',
        'answers'  => [
            /*First Answer Is always yes..*/
            'It has {SIM} sim',
            '',
        ],
        'data'     => [
            'field'   => 'sim_type',
            'json'    => false,
            'key'     => '4G',
            'search'  => 'yes',
            'replace' => '{SIM}',
        ]
    ],
    [
        'question' => 'Does this mobile have fast or turbo charging ?',
        'answers'  => [
            /*First Answer Is always yes..*/
            'Yes, the mobile phone comes with fast / turbo charging.',
            'No, the mobile phone does not come with fast / turbo charging.',
        ],
        'data'     => [
            'field'  => 'desc_json',
            'json'   => true,
            'key'    => 'Turbo Charge',
            'search' => 'yes',
        ]
    ],
    [
        'question' => 'Does this mobile phone comes with finger print sensor ?',
        'answers'  => [
            /*First Answer Is always yes..*/
            'Yes, it has finger print sensor with latest fast sensing technology.',
            'No, it does not have a finger print sensor. However, it has other standard security and password features.',
        ],
        'data'     => [
            'field'  => 'desc_json',
            'json'   => true,
            'key'    => 'Fingerprint sensor',
            'search' => 'yes',
        ]
    ],
    [
        'question' => 'Is video calling possible with this device ?',
        'answers'  => [
            /*First Answer Is always yes..*/
            'Yes, the device is capable of Video Calling. Being a smartphone, all the video calling apps can be downloaded from App store and be used. All you need is a good data connection or a good Wi-Fi.',
            'No, this phone does not come with Video Calling. It’s a feature phone and is targeted as a budget phone for price sensitive customers. Hence it does not support Video Calling.',
        ],
        'data'     => [
            'field'  => 'type',
            'json'   => false,
            'key'    => 'type',
            'search' => 'smartphone',
        ]
    ],
    [
        'question' => 'Is front camera with flash feature available in {PRODUCT_NAME} ?',
        'answers'  => [
            /*First Answer Is always yes..*/
            'Yes, the mobile phone comes with flash feature built-in for the front camera. This is a very good feature as we do require to take Selfies at low lighting conditions at night.',
            'No, it does not come with flash built-in for the front camera.',
        ],
        'data'     => [
            'field'  => 'desc_json',
            'json'   => true,
            'key'    => 'Rear Flash',
            'search' => 'yes',
        ]
    ],
    [
        'question' => 'Can I update it to the latest version of the OS ?',
        'answers'  => [
            /*First Answer Is always yes..*/
            'Yes, being a smartphone, the advantage of this device is that it can be updated to latest OS. However, the latest OS to be used should be from the manufacturer only.',
            'No, being a feature phone it does not allow users to upgrade to different OS.',
        ],
        'data'     => [
            'field'  => 'type',
            'json'   => false,
            'key'    => 'type',
            'search' => 'smartphone',
        ]
    ],
    [
        'question' => 'Is the device water-proof ?',
        'answers'  => [
            /*First Answer Is always yes..*/
            'Yes, the phone is designed to be a water resistant phone. It can take light spills. However, full drenching in water will damage it.',
        ],
        'data'     => [
            'field'  => 'desc_json',
            'json'   => true,
            'key'    => '',
            'search' => '',
        ]
    ],
    [
        'question' => 'Is {PRODUCT_NAME} dust resistant ?',
        'answers'  => [
            /*First Answer Is always yes..*/
            'Yes, it is designed to be dust resistance. Users are advised to keep the phone clean and away from dust to avoid damage to sensitive parts.',
        ],
        'data'     => [
            'field'  => 'desc_json',
            'json'   => true,
            'key'    => '',
            'search' => '',
        ]
    ],
];