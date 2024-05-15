<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit1ff696401163d3fbe8dab8da572d3ebf
{
    public static $files = array (
        '253c157292f75eb38082b5acb06f3f01' => __DIR__ . '/..' . '/nikic/fast-route/src/functions.php',
    );

    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Slim\\' => 5,
        ),
        'P' => 
        array (
            'Psr\\Http\\Message\\' => 17,
            'Psr\\Container\\' => 14,
        ),
        'I' => 
        array (
            'Interop\\Container\\' => 18,
        ),
        'F' => 
        array (
            'FastRoute\\' => 10,
        ),
        'A' => 
        array (
            'App\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Slim\\' => 
        array (
            0 => __DIR__ . '/..' . '/slim/slim/Slim',
        ),
        'Psr\\Http\\Message\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/http-message/src',
        ),
        'Psr\\Container\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/container/src',
        ),
        'Interop\\Container\\' => 
        array (
            0 => __DIR__ . '/..' . '/container-interop/container-interop/src/Interop/Container',
        ),
        'FastRoute\\' => 
        array (
            0 => __DIR__ . '/..' . '/nikic/fast-route/src',
        ),
        'App\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app',
        ),
    );

    public static $prefixesPsr0 = array (
        'P' => 
        array (
            'Pimple' => 
            array (
                0 => __DIR__ . '/..' . '/pimple/pimple/src',
            ),
        ),
    );

    public static $classMap = array (
        'App\\Controllers\\HomeController' => __DIR__ . '/../..' . '/app/Controllers/HomeController.php',
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
        'FastRoute\\BadRouteException' => __DIR__ . '/..' . '/nikic/fast-route/src/BadRouteException.php',
        'FastRoute\\DataGenerator' => __DIR__ . '/..' . '/nikic/fast-route/src/DataGenerator.php',
        'FastRoute\\DataGenerator\\CharCountBased' => __DIR__ . '/..' . '/nikic/fast-route/src/DataGenerator/CharCountBased.php',
        'FastRoute\\DataGenerator\\GroupCountBased' => __DIR__ . '/..' . '/nikic/fast-route/src/DataGenerator/GroupCountBased.php',
        'FastRoute\\DataGenerator\\GroupPosBased' => __DIR__ . '/..' . '/nikic/fast-route/src/DataGenerator/GroupPosBased.php',
        'FastRoute\\DataGenerator\\MarkBased' => __DIR__ . '/..' . '/nikic/fast-route/src/DataGenerator/MarkBased.php',
        'FastRoute\\DataGenerator\\RegexBasedAbstract' => __DIR__ . '/..' . '/nikic/fast-route/src/DataGenerator/RegexBasedAbstract.php',
        'FastRoute\\Dispatcher' => __DIR__ . '/..' . '/nikic/fast-route/src/Dispatcher.php',
        'FastRoute\\Dispatcher\\CharCountBased' => __DIR__ . '/..' . '/nikic/fast-route/src/Dispatcher/CharCountBased.php',
        'FastRoute\\Dispatcher\\GroupCountBased' => __DIR__ . '/..' . '/nikic/fast-route/src/Dispatcher/GroupCountBased.php',
        'FastRoute\\Dispatcher\\GroupPosBased' => __DIR__ . '/..' . '/nikic/fast-route/src/Dispatcher/GroupPosBased.php',
        'FastRoute\\Dispatcher\\MarkBased' => __DIR__ . '/..' . '/nikic/fast-route/src/Dispatcher/MarkBased.php',
        'FastRoute\\Dispatcher\\RegexBasedAbstract' => __DIR__ . '/..' . '/nikic/fast-route/src/Dispatcher/RegexBasedAbstract.php',
        'FastRoute\\Route' => __DIR__ . '/..' . '/nikic/fast-route/src/Route.php',
        'FastRoute\\RouteCollector' => __DIR__ . '/..' . '/nikic/fast-route/src/RouteCollector.php',
        'FastRoute\\RouteParser' => __DIR__ . '/..' . '/nikic/fast-route/src/RouteParser.php',
        'FastRoute\\RouteParser\\Std' => __DIR__ . '/..' . '/nikic/fast-route/src/RouteParser/Std.php',
        'Interop\\Container\\ContainerInterface' => __DIR__ . '/..' . '/container-interop/container-interop/src/Interop/Container/ContainerInterface.php',
        'Interop\\Container\\Exception\\ContainerException' => __DIR__ . '/..' . '/container-interop/container-interop/src/Interop/Container/Exception/ContainerException.php',
        'Interop\\Container\\Exception\\NotFoundException' => __DIR__ . '/..' . '/container-interop/container-interop/src/Interop/Container/Exception/NotFoundException.php',
        'Pimple\\Container' => __DIR__ . '/..' . '/pimple/pimple/src/Pimple/Container.php',
        'Pimple\\Exception\\ExpectedInvokableException' => __DIR__ . '/..' . '/pimple/pimple/src/Pimple/Exception/ExpectedInvokableException.php',
        'Pimple\\Exception\\FrozenServiceException' => __DIR__ . '/..' . '/pimple/pimple/src/Pimple/Exception/FrozenServiceException.php',
        'Pimple\\Exception\\InvalidServiceIdentifierException' => __DIR__ . '/..' . '/pimple/pimple/src/Pimple/Exception/InvalidServiceIdentifierException.php',
        'Pimple\\Exception\\UnknownIdentifierException' => __DIR__ . '/..' . '/pimple/pimple/src/Pimple/Exception/UnknownIdentifierException.php',
        'Pimple\\Psr11\\Container' => __DIR__ . '/..' . '/pimple/pimple/src/Pimple/Psr11/Container.php',
        'Pimple\\Psr11\\ServiceLocator' => __DIR__ . '/..' . '/pimple/pimple/src/Pimple/Psr11/ServiceLocator.php',
        'Pimple\\ServiceIterator' => __DIR__ . '/..' . '/pimple/pimple/src/Pimple/ServiceIterator.php',
        'Pimple\\ServiceProviderInterface' => __DIR__ . '/..' . '/pimple/pimple/src/Pimple/ServiceProviderInterface.php',
        'Pimple\\Tests\\Fixtures\\Invokable' => __DIR__ . '/..' . '/pimple/pimple/src/Pimple/Tests/Fixtures/Invokable.php',
        'Pimple\\Tests\\Fixtures\\NonInvokable' => __DIR__ . '/..' . '/pimple/pimple/src/Pimple/Tests/Fixtures/NonInvokable.php',
        'Pimple\\Tests\\Fixtures\\PimpleServiceProvider' => __DIR__ . '/..' . '/pimple/pimple/src/Pimple/Tests/Fixtures/PimpleServiceProvider.php',
        'Pimple\\Tests\\Fixtures\\Service' => __DIR__ . '/..' . '/pimple/pimple/src/Pimple/Tests/Fixtures/Service.php',
        'Pimple\\Tests\\PimpleServiceProviderInterfaceTest' => __DIR__ . '/..' . '/pimple/pimple/src/Pimple/Tests/PimpleServiceProviderInterfaceTest.php',
        'Pimple\\Tests\\PimpleTest' => __DIR__ . '/..' . '/pimple/pimple/src/Pimple/Tests/PimpleTest.php',
        'Pimple\\Tests\\Psr11\\ContainerTest' => __DIR__ . '/..' . '/pimple/pimple/src/Pimple/Tests/Psr11/ContainerTest.php',
        'Pimple\\Tests\\Psr11\\ServiceLocatorTest' => __DIR__ . '/..' . '/pimple/pimple/src/Pimple/Tests/Psr11/ServiceLocatorTest.php',
        'Pimple\\Tests\\ServiceIteratorTest' => __DIR__ . '/..' . '/pimple/pimple/src/Pimple/Tests/ServiceIteratorTest.php',
        'Psr\\Container\\ContainerExceptionInterface' => __DIR__ . '/..' . '/psr/container/src/ContainerExceptionInterface.php',
        'Psr\\Container\\ContainerInterface' => __DIR__ . '/..' . '/psr/container/src/ContainerInterface.php',
        'Psr\\Container\\NotFoundExceptionInterface' => __DIR__ . '/..' . '/psr/container/src/NotFoundExceptionInterface.php',
        'Psr\\Http\\Message\\MessageInterface' => __DIR__ . '/..' . '/psr/http-message/src/MessageInterface.php',
        'Psr\\Http\\Message\\RequestInterface' => __DIR__ . '/..' . '/psr/http-message/src/RequestInterface.php',
        'Psr\\Http\\Message\\ResponseInterface' => __DIR__ . '/..' . '/psr/http-message/src/ResponseInterface.php',
        'Psr\\Http\\Message\\ServerRequestInterface' => __DIR__ . '/..' . '/psr/http-message/src/ServerRequestInterface.php',
        'Psr\\Http\\Message\\StreamInterface' => __DIR__ . '/..' . '/psr/http-message/src/StreamInterface.php',
        'Psr\\Http\\Message\\UploadedFileInterface' => __DIR__ . '/..' . '/psr/http-message/src/UploadedFileInterface.php',
        'Psr\\Http\\Message\\UriInterface' => __DIR__ . '/..' . '/psr/http-message/src/UriInterface.php',
        'Slim\\App' => __DIR__ . '/..' . '/slim/slim/Slim/App.php',
        'Slim\\CallableResolver' => __DIR__ . '/..' . '/slim/slim/Slim/CallableResolver.php',
        'Slim\\CallableResolverAwareTrait' => __DIR__ . '/..' . '/slim/slim/Slim/CallableResolverAwareTrait.php',
        'Slim\\Collection' => __DIR__ . '/..' . '/slim/slim/Slim/Collection.php',
        'Slim\\Container' => __DIR__ . '/..' . '/slim/slim/Slim/Container.php',
        'Slim\\Exception\\ContainerValueNotFoundException' => __DIR__ . '/..' . '/slim/slim/Slim/Exception/ContainerValueNotFoundException.php',
        'Slim\\Exception\\MethodNotAllowedException' => __DIR__ . '/..' . '/slim/slim/Slim/Exception/MethodNotAllowedException.php',
        'Slim\\Exception\\NotFoundException' => __DIR__ . '/..' . '/slim/slim/Slim/Exception/NotFoundException.php',
        'Slim\\Exception\\SlimException' => __DIR__ . '/..' . '/slim/slim/Slim/Exception/SlimException.php',
        'Slim\\Handlers\\Error' => __DIR__ . '/..' . '/slim/slim/Slim/Handlers/Error.php',
        'Slim\\Handlers\\NotAllowed' => __DIR__ . '/..' . '/slim/slim/Slim/Handlers/NotAllowed.php',
        'Slim\\Handlers\\NotFound' => __DIR__ . '/..' . '/slim/slim/Slim/Handlers/NotFound.php',
        'Slim\\Handlers\\Strategies\\RequestResponse' => __DIR__ . '/..' . '/slim/slim/Slim/Handlers/Strategies/RequestResponse.php',
        'Slim\\Handlers\\Strategies\\RequestResponseArgs' => __DIR__ . '/..' . '/slim/slim/Slim/Handlers/Strategies/RequestResponseArgs.php',
        'Slim\\Http\\Body' => __DIR__ . '/..' . '/slim/slim/Slim/Http/Body.php',
        'Slim\\Http\\Cookies' => __DIR__ . '/..' . '/slim/slim/Slim/Http/Cookies.php',
        'Slim\\Http\\Environment' => __DIR__ . '/..' . '/slim/slim/Slim/Http/Environment.php',
        'Slim\\Http\\Headers' => __DIR__ . '/..' . '/slim/slim/Slim/Http/Headers.php',
        'Slim\\Http\\Message' => __DIR__ . '/..' . '/slim/slim/Slim/Http/Message.php',
        'Slim\\Http\\Request' => __DIR__ . '/..' . '/slim/slim/Slim/Http/Request.php',
        'Slim\\Http\\RequestBody' => __DIR__ . '/..' . '/slim/slim/Slim/Http/RequestBody.php',
        'Slim\\Http\\Response' => __DIR__ . '/..' . '/slim/slim/Slim/Http/Response.php',
        'Slim\\Http\\Stream' => __DIR__ . '/..' . '/slim/slim/Slim/Http/Stream.php',
        'Slim\\Http\\UploadedFile' => __DIR__ . '/..' . '/slim/slim/Slim/Http/UploadedFile.php',
        'Slim\\Http\\Uri' => __DIR__ . '/..' . '/slim/slim/Slim/Http/Uri.php',
        'Slim\\Interfaces\\CallableResolverInterface' => __DIR__ . '/..' . '/slim/slim/Slim/Interfaces/CallableResolverInterface.php',
        'Slim\\Interfaces\\CollectionInterface' => __DIR__ . '/..' . '/slim/slim/Slim/Interfaces/CollectionInterface.php',
        'Slim\\Interfaces\\Http\\CookiesInterface' => __DIR__ . '/..' . '/slim/slim/Slim/Interfaces/Http/CookiesInterface.php',
        'Slim\\Interfaces\\Http\\EnvironmentInterface' => __DIR__ . '/..' . '/slim/slim/Slim/Interfaces/Http/EnvironmentInterface.php',
        'Slim\\Interfaces\\Http\\HeadersInterface' => __DIR__ . '/..' . '/slim/slim/Slim/Interfaces/Http/HeadersInterface.php',
        'Slim\\Interfaces\\InvocationStrategyInterface' => __DIR__ . '/..' . '/slim/slim/Slim/Interfaces/InvocationStrategyInterface.php',
        'Slim\\Interfaces\\RouteGroupInterface' => __DIR__ . '/..' . '/slim/slim/Slim/Interfaces/RouteGroupInterface.php',
        'Slim\\Interfaces\\RouteInterface' => __DIR__ . '/..' . '/slim/slim/Slim/Interfaces/RouteInterface.php',
        'Slim\\Interfaces\\RouterInterface' => __DIR__ . '/..' . '/slim/slim/Slim/Interfaces/RouterInterface.php',
        'Slim\\MiddlewareAwareTrait' => __DIR__ . '/..' . '/slim/slim/Slim/MiddlewareAwareTrait.php',
        'Slim\\Routable' => __DIR__ . '/..' . '/slim/slim/Slim/Routable.php',
        'Slim\\Route' => __DIR__ . '/..' . '/slim/slim/Slim/Route.php',
        'Slim\\RouteGroup' => __DIR__ . '/..' . '/slim/slim/Slim/RouteGroup.php',
        'Slim\\Router' => __DIR__ . '/..' . '/slim/slim/Slim/Router.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit1ff696401163d3fbe8dab8da572d3ebf::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit1ff696401163d3fbe8dab8da572d3ebf::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInit1ff696401163d3fbe8dab8da572d3ebf::$prefixesPsr0;
            $loader->classMap = ComposerStaticInit1ff696401163d3fbe8dab8da572d3ebf::$classMap;

        }, null, ClassLoader::class);
    }
}
