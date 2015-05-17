<?php
/** @var $app Application */

$app['locale'] = 'ru';

// Router
$app->register(new Silicone\Provider\RouterServiceProvider());
$app['router.resource'] = array(
  $app->getRootDir().'/src/Controller/',
);
$app['router.cache_dir'] = $app->getCacheDir();

// Assets
$app['assets.base_path'] = '/public/';

// Http Cache
$app->register(
  new Silex\Provider\HttpCacheServiceProvider(),
  array(
    'http_cache.cache_dir' => $app->getCacheDir().'/http/',
  )
);

// Controllers
$app['resolver'] = $app->share(
  function () use ($app) {
      return new Silicone\Controller\ControllerResolver($app, $app['logger']);
  }
);
$app->register(new Silex\Provider\ServiceControllerServiceProvider());

// Doctrine Common
$app->register(new Silicone\Provider\DoctrineCommonServiceProvider());

// Doctrine ORM
$app->register(new Silicone\Provider\DoctrineOrmServiceProvider());
$app['doctrine.options'] = array(
  'debug' => $app['debug'],
  'proxy_namespace' => 'Proxy',
  'proxy_dir' => $app->getCacheDir().'/proxy/',
);
$app['doctrine.connection'] = array(
  'driver' => 'pdo_mysql',
  'dbname' => 'symfony',
  'user' => 'root',
  'password' => 'root',
  'charset' => 'utf8',
);
$app['doctrine.paths'] = array(
  $app->getRootDir().'/src/Entity/',
);

// Monolog
$app->register(new Silex\Provider\MonologServiceProvider());
$app['monolog.logfile'] = $app->getLogDir().'/log.txt';
$app['monolog.name'] = 'Silicone';

// Session
$app->register(
  new Silex\Provider\SessionServiceProvider(),
  array(
    'session.storage.options' => array(
      'name' => 'Silicone',
    ),
    'session.storage.handler' => null
  )
);

// Twig
$app->register(
  new Silex\Provider\TwigServiceProvider(),
  array(
    'twig.options' => array(
      'cache' => $app->getCacheDir().'/twig/',
      'auto_reload' => true,
    ),
    'twig.path' => $app->getRootDir().'/views/',
  )
);
$app->register(new Silicone\Provider\TwigServiceProviderExtension());

// Translation
$app->register(new Silicone\Provider\TranslationServiceProvider());
$app['translator.resource'] = $app->getRootDir().'/lang/';

// Validator
$app->register(new Silex\Provider\ValidatorServiceProvider());
$app->register(new Silicone\Provider\ValidatorServiceProviderExtension());
$app['validator.unique'] = function () use ($app) {
    return new Validator\UniqueValidator($app['em']);
};

// Form
$app->register(new Silex\Provider\FormServiceProvider());

// Mailer
$app->register(
  new Silex\Provider\SwiftmailerServiceProvider(),
  array(
    'swiftmailer.options' => array(
      'host' => 'smtp.yandex.ru',
      'port' => 465,
      'username' => '',
      'password' => '',
      'encryption' => 'ssl',
        //'auth_mode' => 'login'
    )
  )
);
//$app['swiftmailer.use_spool'] = false;

// Security
$app['security.user_class'] = 'Entity\User';
$app->register(
  new Silex\Provider\SecurityServiceProvider(),
  array(
    'security.firewalls' => array(
      'login_path' => array(
        'pattern' => '^/login$',
        'anonymous' => true
      ),
      'default' => array(
        'pattern' => '^/.*$',
        'anonymous' => true,
        'form' => array(
          'login_path' => '/login',
          'check_path' => '/login_check'
        ),
        'logout' => array(
          'logout_path' => '/logout'
        ),
        'users' => $app->share(
          function () use ($app) {
              return new Security\UserProvider(
                $app['em']->getRepository($app['security.user_class'])
              );
          }
        ),
        'remember_me' => array(
          'key' => 'remember_me',
          'lifetime' => 31536000, # 365 days in seconds
          'path' => '/',
          'name' => 'REMEMBER_ME',
        ),
      ),
    ),
    'security.role_hierarchy' => array(
      'ROLE_USER' => array('ROLE_GUEST'),
      'ROLE_ADMIN' => array('ROLE_USER'),
    ),
    'security.access_rules' => array(
      array('^/edit', 'ROLE_ADMIN'),
      array('^/register', 'ROLE_ADMIN'), // Запрещяем юзерам регаться
      array('^/', 'IS_AUTHENTICATED_ANONYMOUSLY'),
        // Пароль админа x95vVFS0
    )
  )
);
$app->register(new Silex\Provider\RememberMeServiceProvider());
$r = new \ReflectionClass('Symfony\Component\Security\Core\SecurityContext');
$app['translator']->addResource(
  'xliff',
  dirname(
    $r->getFilename()
  ).'/../Resources/translations/security.'.$app['locale'].'.xlf',
  $app['locale'],
  'security'
);


$app->error(
  function (\Exception $e, $code) use ($app) {
      if ($app['debug']) {
          return;
      }
      $page = 404 == $code ? '404.html.twig' : '500.html.twig';

      return new Response(
        $app['twig']->render($page, array('code' => $code)),
        $code
      );
  }
);
