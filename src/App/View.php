<?php

declare(strict_types=1);

namespace App;


use App\Exceptions\ViewNotFoundException;
use App\Models\Classes\CustomClass;

/**
 * Class View
 * 
 * Represents a view in the application.
 */
class View
{
    /**
     * The path to the view file.
     *
     * @var string
     */
    protected string $view;

    /**
     * The parameters to be passed to the view.
     *
     * @var array
     */
    protected array | CustomClass $params;

    /**
     * Create a new View instance.
     *
     * @param string $view The path to the view file.
     * @param array|CustomClass $params The parameters to be passed to the view.
     */
    public function __construct(string $view, array|CustomClass $params = [])
    {
        $this->view = $view;
        $this->params = $params;
    }

    /**
     * Render the view and return the output as a string.
     *
     * @return string The rendered view.
     * @throws ViewNotFoundException If the view file does not exist.
     */
    public function render(): string
    {
        $viewPath = VIEW_PATH . '/' . $this->view . '.php';

        if (!file_exists($viewPath)) {
            throw new ViewNotFoundException();
        }

        // Extracting the parameters so they are available in the view with a variable variable

        $params = $this->params;
      
        /*  foreach ($this->params as $key => $value) {
            $$key = $value;
        } */

        // Buffering the output so it is returned as a string
        ob_start();
        include $viewPath;
        return (string) ob_get_clean();
    }
}
