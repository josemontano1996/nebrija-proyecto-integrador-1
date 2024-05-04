<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\View;
use App\Exceptions\ViewNotFoundException;
use PHPUnit\Framework\TestCase;

define('VIEW_PATH', __DIR__ . '/../../src/front/views');

define('ROOT_PATH', __DIR__ . '/../../');

class ViewTest extends TestCase
{
    /**
     * Test that a view can be rendered.
     *
     * @return void
     */
    public function test_it_renders_view(): void
    {
        // Given a view instance
        $view = new View('login');

        // When we render the view
        $output = $view->render();

        // Then the output should be a string
        $this->assertIsString($output);
    }

    /**
     * Test that an exception is thrown if the view is not found.
     *
     * @return void
     */
    public function test_it_throws_exception_if_view_not_found(): void
    {
        // Given a view instance with a non-existent view file
        $view = new View('nonexistent');

        // Then it should throw a ViewNotFoundException
        $this->expectException(ViewNotFoundException::class);

        // When we render the view
        $view->render();
    }

    /**
     * Test that parameters are accessible in the view.
     *
     * @return void
     */
    public function test_params_is_accestible_in_view(): void
    {
        // Given a view instance with parameters
        $view = new View('testing', ['Jane Doe']);

        // When we render the view
        $renderedView = $view->render();

        // Then the parameters should be accessible in the view
        $this->assertStringContainsString('Jane Doe', $renderedView);
    }
}
