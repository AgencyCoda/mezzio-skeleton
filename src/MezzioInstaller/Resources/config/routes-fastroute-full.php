<?php

declare(strict_types=1);

use Mezzio\Application;
use Mezzio\MiddlewareFactory;
use Psr\Container\ContainerInterface;

use Mia\Auth\Model\MIAUser;
use Mia\Auth\Handler\RegisterHandler;
use Mia\Auth\Handler\Social\GoogleSignInHandler;

/**
 * FastRoute route configuration
 *
 * @see https://github.com/nikic/FastRoute
 *
 * Setup routes with a single request method:
 *
 * $app->get('/', App\Handler\HomePageHandler::class, 'home');
 * $app->post('/album', App\Handler\AlbumCreateHandler::class, 'album.create');
 * $app->put('/album/{id:\d+}', App\Handler\AlbumUpdateHandler::class, 'album.put');
 * $app->patch('/album/{id:\d+}', App\Handler\AlbumUpdateHandler::class, 'album.patch');
 * $app->delete('/album/{id:\d+}', App\Handler\AlbumDeleteHandler::class, 'album.delete');
 *
 * Or with multiple request methods:
 *
 * $app->route('/contact', App\Handler\ContactHandler::class, ['GET', 'POST', ...], 'contact');
 *
 * Or handling all request methods:
 *
 * $app->route('/contact', App\Handler\ContactHandler::class)->setName('contact');
 *
 * or:
 *
 * $app->route(
 *     '/contact',
 *     App\Handler\ContactHandler::class,
 *     Mezzio\Router\Route::HTTP_METHOD_ANY,
 *     'contact'
 * );
 */
return static function (Application $app, MiddlewareFactory $factory, ContainerInterface $container): void {
    $app->get('/', App\Handler\HomePageHandler::class, 'home');
    $app->get('/api/ping', App\Handler\PingHandler::class, 'api.ping');

    /** AUTHENTICATION **/
    $app->route('/mia-auth/login', [Mia\Auth\Handler\LoginHandler::class], ['GET', 'POST', 'OPTIONS', 'HEAD'], 'mia_auth.login');
    $app->route('/mia-auth/register', [\Mia\Mail\Handler\SendgridHandler::class, new RegisterHandler(false)], ['GET', 'POST', 'OPTIONS', 'HEAD'], 'mia_auth.register');
    $app->route('/mia-auth/update-profile', [\Mia\Auth\Handler\AuthHandler::class, Mia\Auth\Handler\UpdateProfileHandler::class], ['GET', 'POST', 'OPTIONS', 'HEAD'], 'mia_auth.update-profile');
    $app->route('/mia-auth/recovery', [\Mia\Mail\Handler\SendgridHandler::class, Mia\Auth\Handler\MiaRecoveryHandler::class], ['GET', 'POST', 'OPTIONS', 'HEAD'], 'mia_auth.recovery');
    $app->route('/mia-auth/change-password-recovery', [Mia\Auth\Handler\MiaPasswordRecoveryHandler::class], ['GET', 'POST', 'OPTIONS', 'HEAD'], 'mia_auth.change-password-recovery');
    $app->route('/mia-auth/me', [\Mia\Auth\Handler\AuthHandler::class, Mia\Auth\Handler\FetchProfileHandler::class], ['GET', 'POST', 'OPTIONS', 'HEAD'], 'mia_auth.me');
    
    $app->route('/mia-auth/login-with-google', [GoogleSignInHandler::class], ['POST', 'OPTIONS', 'HEAD'], 'mia_auth.login-with-gogle');
    //$app->route('/mia-auth/apple-signin', [Mia\Auth\Handler\AppleSignInHandler::class], ['GET', 'POST', 'OPTIONS', 'HEAD'], 'mia_auth.apple-signin');
    $app->route('/mia-auth/register-device', [\Mia\Auth\Handler\AuthHandler::class, Mia\Auth\Handler\RegisterDeviceHandler::class], ['GET', 'POST', 'OPTIONS', 'HEAD'], 'mia_auth.register-device');

    /** ROLES AND PERMISSIONS  */
    $app->route('/mia-auth/role/list', [Mia\Auth\Handler\Role\ListHandler::class], ['GET', 'POST', 'OPTIONS', 'HEAD'], 'mia_auth.role-list');
    $app->route('/mia-auth/role/all', [Mia\Auth\Handler\Role\AllHandler::class], ['GET', 'POST', 'OPTIONS', 'HEAD'], 'mia_auth.role-all');
    $app->route('/mia-auth/role/access', [\Mia\Auth\Handler\AuthHandler::class, Mia\Auth\Handler\Role\AccessHandler::class], ['GET', 'POST', 'OPTIONS', 'HEAD'], 'mia_auth.role-access');

    /** EMAILs Templates  */
    $app->route('/mia-mail-admin/list', [\Mia\Mail\Handler\FetchTemplatesHandler::class], ['GET', 'POST', 'OPTIONS', 'HEAD'], 'mia-mail.list');
    $app->route('/mia-mail-admin/save', [\Mia\Mail\Handler\SaveTemplateHandler::class], ['GET', 'POST', 'OPTIONS', 'HEAD'], 'mia-mail.save');

    /** NOTIFICATIONS */
    $app->route('/mia-notification/list', [\Mia\Auth\Handler\AuthHandler::class, Mia\Auth\Handler\Notification\ListHandler::class], ['GET', 'POST', 'OPTIONS', 'HEAD'], 'mia_notification.list');
    $app->route('/mia-notification/read', [\Mia\Auth\Handler\AuthHandler::class, Mia\Auth\Handler\Notification\ReadHandler::class], ['GET', 'POST', 'OPTIONS', 'HEAD'], 'mia_notification.read');
    $app->route('/mia-notification/read-all', [\Mia\Auth\Handler\AuthHandler::class, Mia\Auth\Handler\Notification\ReadAllHandler::class], ['GET', 'POST', 'OPTIONS', 'HEAD'], 'mia_notification.read-all');

    /** USERS */
    $app->route('/user/list', [\Mia\Auth\Handler\AuthHandler::class, new \Mia\Auth\Middleware\MiaRoleAuthMiddleware([MIAUser::ROLE_ADMIN]), \Mia\Auth\Handler\User\ListHandler::class], ['GET', 'POST', 'OPTIONS', 'HEAD'], 'user.list');
    $app->route('/user/block', [\Mia\Auth\Handler\AuthHandler::class, new \Mia\Auth\Middleware\MiaRoleAuthMiddleware([MIAUser::ROLE_ADMIN]), \Mia\Auth\Handler\User\BlockHandler::class], ['GET', 'POST', 'OPTIONS', 'HEAD'], 'user.block');
    $app->route('/user/save', [\Mia\Auth\Handler\AuthHandler::class, new \Mia\Auth\Middleware\MiaRoleAuthMiddleware([MIAUser::ROLE_ADMIN]), \Mia\Auth\Handler\User\SaveHandler::class], ['GET', 'POST', 'OPTIONS', 'HEAD'], 'user.save');
};
