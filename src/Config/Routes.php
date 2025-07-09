<?php

declare(strict_types=1);

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Placeholder untuk judul accordion (id)
$routes->addPlaceholder('accordionTitle', '[a-zA-Z0-9\-_]+');

// Route GET untuk mengambil semua status accordion dari cookie
$routes->get(
    'accordion-state',
    'AccordionState::get',
    ['namespace' => 'Forge\Uiunit\Controllers']
);

// Route POST untuk toggle status accordion berdasarkan judul
$routes->post(
    'accordion-state/save/(:accordionTitle)',
    'AccordionState::save/$1',
    ['namespace' => 'Forge\Uiunit\Controllers']
);
