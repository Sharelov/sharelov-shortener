<?php

return [
    /**
     * Domain for short urls saved to database.
     */
    'domain' => env('APP_URL', 'http://localhost:8000'),

    /**
     * Path that will be used after the domain and before
     * hashes in the short urls saved to db can be
     * safely left null to use domain.tld/hash
     * for shorter urls.
     */
    'path'=>null,
];
