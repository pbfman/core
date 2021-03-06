<?php
/**
 * Routes configuration
 *
 * Wasabi Core
 * Copyright (c) Frank Förster (http://frankfoerster.com)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Frank Förster (http://frankfoerster.com)
 * @link          https://github.com/wasabi-cms/core Wasabi Project
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

use Cake\Routing\Router;
use Cake\Routing\RouteBuilder;

Router::scope('/backend', ['plugin' => 'Wasabi/Core'], function (RouteBuilder $routes) {
    $routes->connect('/', ['controller' => 'Dashboard', 'action' => 'index']);
    $routes->connect('/login', ['controller' => 'Users', 'action' => 'login']);
    $routes->connect('/logout', ['controller' => 'Users', 'action' => 'logout']);
    $routes->connect('/register', ['controller' => 'Users', 'action' => 'register']);
    $routes->connect('/forbidden', ['controller' => 'Users', 'action' => 'unauthorized']);
    $routes->connect('/heartbeat', ['controller' => 'Users', 'action' => 'heartBeat']);
    $routes->connect('/profile', ['controller' => 'Users', 'action' => 'profile']);
    $routes->connect('/request-new-verification-email', ['controller' => 'Users', 'action' => 'requestNewVerificationEmail']);
    $routes->connect('/verify/:token', ['controller' => 'Users', 'action' => 'verifyByToken'], ['token' => '[a-zA-Z0-9\-]+', 'pass' => ['token']]);

    $routes->scope('/password', ['controller' => 'Users'], function(RouteBuilder $route) {
        $route->connect('/lost', ['action' => 'lostPassword']);
        $route->connect('/reset/:token', ['action' => 'resetPassword'], ['token' => '[a-zA-Z0-9\-]+', 'pass' => ['token']]);
    });

    $routes->scope('/users', ['controller' => 'Users'], function (RouteBuilder $routes) {
        $routes->connect('/:sluggedFilter', ['action' => 'index'], ['pass' => ['sluggedFilter']]);
        $routes->connect('/', ['action' => 'index']);
        $routes->connect('/add', ['action' => 'add']);
        $routes->connect('/edit/:id', ['action' => 'edit'], ['pass' => ['id'], 'id' => '[0-9]+']);
        $routes->connect('/delete/:id', ['action' => 'delete'], ['pass' => ['id'], 'id' => '[0-9]+']);
        $routes->connect('/activate/:id', ['action' => 'activate'], ['pass' => ['id'], 'id' => '[0-9]+']);
        $routes->connect('/deactivate/:id', ['action' => 'deactivate'], ['pass' => ['id'], 'id' => '[0-9]+']);
        $routes->connect('/verify/:id', ['action' => 'verify'], ['pass' => ['id'], 'id' => '[0-9]+']);
    });

    $routes->scope('/groups', ['controller' => 'Groups'], function (RouteBuilder $routes) {
        $routes->connect('/:sluggedFilter', ['action' => 'index'], ['pass' => ['sluggedFilter']]);
        $routes->connect('/', ['action' => 'index']);
        $routes->connect('/add', ['action' => 'add']);
        $routes->connect('/edit/:id', ['action' => 'edit'], ['pass' => ['id'], 'id' => '[0-9]+']);
        $routes->connect('/delete/:id', ['action' => 'delete'], ['pass' => ['id'], 'id' => '[0-9]+']);
    });

    $routes->scope('/languages', ['controller' => 'Languages'], function (RouteBuilder $routes) {
        $routes->connect('/', ['action' => 'index']);
        $routes->connect('/add', ['action' => 'add']);
        $routes->connect('/edit/:id', ['action' => 'edit'], ['pass' => ['id'], 'id' => '[0-9]+']);
        $routes->connect('/delete/:id', ['action' => 'delete'], ['pass' => ['id'], 'id' => '[0-9]+']);
        $routes->connect('/sort', ['action' => 'sort']);
        $routes->connect('/change/:id', ['action' => 'change'], ['pass' => ['id'], 'id' => '[0-9]+']);
    });

    $routes->scope('/permissions', ['controller' => 'GroupPermissions'], function (RouteBuilder $routes) {
        $routes->connect('/', ['action' => 'index']);
        $routes->connect('/sync', ['action' => 'sync']);
        $routes->connect('/update', ['action' => 'update']);
    });

    $routes->scope('/settings', ['controller' => 'Settings'], function (RouteBuilder $routes) {
        $routes->connect('/general', ['action' => 'general']);
        $routes->connect('/cache', ['action' => 'cache']);
    });

    $routes->scope('/routes', ['controller' => 'Routes'], function (RouteBuilder $routes) {
        $routes->connect('/add', ['action' => 'add']);
        $routes->connect('/make-default/:id', ['action' => 'makeDefault'], ['pass' => ['id'], 'id' => '[0-9]+']);
        $routes->connect('/delete/:id', ['action' => 'delete'], ['pass' => ['id'], 'id' => '[0-9]+']);
    });

    /**
     * Connect a route for the index action of any controller.
     * And a more general catch all route for any action.
     *
     * The `fallbacks` method is a shortcut for
     *    `$routes->connect('/:controller', ['action' => 'index'], ['routeClass' => 'InflectedRoute']);`
     *    `$routes->connect('/:controller/:action/*', [], ['routeClass' => 'InflectedRoute']);`
     *
     * You can remove these routes once you've connected the
     * routes you want in your application.
     */
    $routes->fallbacks();
});
