<?php

use Laravel\Jetstream\Features;
use Laravel\Jetstream\Http\Middleware\AuthenticateSession;

return [

    'stack' => 'livewire',

    'middleware' => ['web'],

    'auth_session' => AuthenticateSession::class,

    'guard' => 'sanctum',

    /*
    |--------------------------------------------------------------------------
    | Features
    |--------------------------------------------------------------------------
    */
    'features' => [

        // // ✅ KASUTAJA PEAB KINNITAMA EMAILI
        // Features::emailVerification(),

        // ✅ Tingimustega nõustumine (checkbox registeris)
        Features::termsAndPrivacyPolicy(),

        // ❌ konto kustutamine VÄLJAS
        // Features::accountDeletion(),

        // (valikulised)
        // Features::profilePhotos(),
        // Features::api(),
        // Features::teams(['invitations' => true]),
    ],

    'profile_photo_disk' => 'public',

];
