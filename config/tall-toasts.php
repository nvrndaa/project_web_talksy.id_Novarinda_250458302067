<?php

return [
    /*
     * How long each toast will be displayed before fading out, in ms
     * Dipercepat menjadi 3000ms (3 detik) agar user tidak perlu menunggu lama.
     */
    'duration' => 3000,

    /*
     * How long to wait before displaying the toasts after page loads, in ms
     * Dikurangi menjadi 100ms agar terasa instan namun tetap smooth.
     */
    'load_delay' => 100,

    /*
     * Session keys used.
     * No need to edit unless the keys are already being used and conflict.
     */
    'session_keys' => [
        'toasts' => 'toasts',
        'toasts_next_page' => 'toasts-next',
    ],
];
