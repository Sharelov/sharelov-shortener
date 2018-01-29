<?php

return [
    /*
     * Domain used when generating short urls. The short domain makes the urls
     * with hashes that are saved to the database. Ideally, this should be a
     * shorter domain that whatever is currently set in config -> app.url
     *
     * You can configure your site to also answer requests to this domain and
     * then make a route group to handle said requests to this domain all
     * while keeping the routes separate from the rest of your site. You
     * could also host the url shortener on a separate api-like service
     * and work out your own implementation.
     */
    'domain' => env('SHORTENER_URL', env('APP_URL')),

    /*
     * Path that will be used after the domain and before hashes in the short
     * urls saved to db can be safely left null to use domain.tld/{hash} for
     * shorter urls. If you set this to "short", it would use the value
     * of domain/path/hash to generate your shortened urls.
     */
    'path'=> null,

    /*
     * Name of the table to use in the migration. We use short_links as default
     * but you can change it to anything you wish to use in your project.
     */
    'links_table' => 'short_links',

    /*
     * Whether or not to enable soft deletes for the short links
     * table. Setting this to on, will activate a different
     * model (one that extends the basic one) which will
     * use the soft deletes trait.
     */
    'enable_soft_deletes' => false,

    /*
     * Initial length of hashes, they will grow larger once possible
     * permutations have run its course...
     */
    'hash_length' => 5,

    /*
     * Amount of tries before growing the hash length. We are by default
     * using 3 attempts before adding 1 to whatever the hash_length is
     * set to. This would mean that we tried 3 times to generate a
     * unique hash, but each time it generated something already
     * in our database, so we add +1 to the length to force a
     * unique hash to be generated on the next attempt.
     */
    'max_attempts' => 3,

];
