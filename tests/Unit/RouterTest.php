<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Router;
use PHPUnit\Framework\TestCase;
use App\Exceptions\RouteNotFoundException;
use PHPUnit\Framework\Attributes\DataProvider;

class RouterTest extends TestCase
{

    protected Router $router;

    protected function setUp(): void
    {
        parent::setUp();

        $this->router = new Router();
    }
    public function test_it_registers_a_route(): void
    {
        //when we register a route
        $this->router->register('get', '/home', ['UserController', 'index']);

        //then the route should be stored in the routes array
        $expected = ['get' => ['/home' => ['UserController', 'index']]];
        $this->assertEquals($expected, $this->router->routes());
    }

    public function test_registers_get_route(): void
    {
        //given that we have router object
        $this->router = new Router();

        //when we register a GET route
        $this->router->get('/home', ['UserController', 'index']);

        //then the route should be stored in the routes array
        $expected = ['get' => ['/home' => ['UserController', 'index']]];
        $this->assertEquals($expected, $this->router->routes());
    }
    public function test_registers_post_get_route(): void
    {
        //given that we have router object
        $this->router = new Router();

        //when we register a POST route
        $this->router->post('/home', ['UserController', 'index']);

        //then the route should be stored in the routes array
        $expected = ['post' => ['/home' => ['UserController', 'index']]];
        $this->assertEquals($expected, $this->router->routes());
    }

    public function test_registers_put_route(): void
    {
        //given that we have router object
        $this->router = new Router();

        //when we register a PUT route
        $this->router->put('/home', ['UserController', 'index']);

        //then the route should be stored in the routes array
        $expected = ['put' => ['/home' => ['UserController', 'index']]];
        $this->assertEquals($expected, $this->router->routes());
    }

    public function test_registers_delete_route(): void
    {
        //given that we have router object
        $this->router = new Router();

        //when we register a DELETE route
        $this->router->delete('/home', ['UserController', 'index']);

        //then the route should be stored in the routes array
        $expected = ['delete' => ['/home' => ['UserController', 'index']]];
        $this->assertEquals($expected, $this->router->routes());
    }

    public function test_there_are_no_routes_when_router_is_created(): void
    {
        //given that we have router object
        $this->router = new Router();

        //then the routes array should be empty
        $this->assertEmpty($this->router->routes());
    }

    #[DataProvider('routeNotFoundCases')]
    public function test_it_throws_route_not_found_exception(string $requestUri, string $requestMethod): void
    {
        $users = new class()
        {
            public function delete(): bool
            {
                return true;
            }
        };

        $this->router->get('/users', [$users::class, 'index']);
        $this->router->post('/home', ['UserController', 'index']);

        $this->expectException(RouteNotFoundException::class);

        $this->router->resolve($requestUri, $requestMethod);
    }

    static public function routeNotFoundCases(): array
    {
        return [
            ['/', 'josjng'],
            ['/fadgasd', 'getHomePage'],
            ['/', 'getHomePage'],
            ['/users', 'post'],

        ];
    }

    public function test_it_resolves_a_closure(): void
    {
       $this->router->get('/home', function () {
            return 'Hello World';
        });

        $route = $this->router->resolve('/home', 'get');

        $this->assertEquals('Hello World', $route);
    }
}
