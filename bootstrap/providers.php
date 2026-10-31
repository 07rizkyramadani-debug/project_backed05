<?php

return [
    App\Providers\AppServiceProvider::class,
    Modules\Products\Providers\ProductServiceProvider::class,
    Modules\Auth\Providers\AuthServiceProvider::class,
    Modules\Authors\Providers\AuthorServiceProvider::class,
    Modules\Books\Providers\BookServiceProvider::class,
];

