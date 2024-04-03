<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\View;
use App\Exceptions\ViewNotFoundException;
use PHPUnit\Framework\TestCase;

define('VIEW_PATH', __DIR__ . '/../../public/views');

class ViewTest extends TestCase
{
    public function test_it_renders_view(): void
    {
        // Given a view instance
        $view = new View('login');

        // When we render the view
        $output = $view->render();

        // Then the output should be a string
        $this->assertIsString($output);
    }

    public function test_it_throws_exception_if_view_not_found(): void
    {
        // Given a view instance with a non-existent view file
        $view = new View('nonexistent');

        // Then it should throw a ViewNotFoundException
        $this->expectException(ViewNotFoundException::class);

        // When we render the view
        $view->render();
    }

    public function test_it_passes_parameters_to_view(): void
    {
        // Given a view instance with parameters
        $view = new View('home', ['hello']);

        // When we render the view
        $output = $view->render();

        // Then the output should contain the parameter values
        $this->assertStringContainsString('hello', $output);
       
    }
}
