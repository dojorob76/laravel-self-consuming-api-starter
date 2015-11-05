<?php

return [
    /*
     |--------------------------------------------------------------------------
     | Laravel CORS
     |--------------------------------------------------------------------------
     |

     | allowedOrigins, allowedHeaders and allowedMethods can be set to array('*') 
     | to accept any value, the allowed methods however have to be explicitly listed.
     |
     */
    'supportsCredentials' => false,
    'allowedOrigins' => ['*'],
<<<<<<< HEAD
    'allowedHeaders' => ['Content-Type', 'Accept', 'Authorization', 'X-Requested-With'],
=======
    'allowedHeaders' => ['Content-Type', 'Accept', 'Authorization', 'X-Requested-With', 'X-CSRF-TOKEN'],
>>>>>>> d777b7f4a0795542a2f44a6d65c5eb838af4c5f7
    'allowedMethods' => ['GET', 'POST', 'PUT',  'DELETE'],
    'exposedHeaders' => ['Authorization'],
    'maxAge' => 0,
    'hosts' => [],
];

