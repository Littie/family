<?php

declare(strict_types = 1);

/**
 * Class View.
 */
class View
{
    /**
     * Generate view page.
     *
     * @param $content_view
     * @param null $data
     */
    function generate($content_view, $data = null)
    {
        if (null !== $data) {
            if (!is_array($data)) {
                (array) $data;
            }

            extract($data);
        }


        include 'views/template.php';
    }
}
