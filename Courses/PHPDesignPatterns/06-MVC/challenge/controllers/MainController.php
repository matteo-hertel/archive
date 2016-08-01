<?php

class MainController
{
    protected $path;

    public function __construct($path)
    {
        $this->path = $path;
    }

    public function bootsrap()
    {
        //any bootstrap logic
    }

    public function handle()
    {
        if (!$this->path) {
            return $this->handleHomepage();
        }
        $fileName = sprintf('%s/../views/%s.php', __DIR__, $this->path);

        if (file_exists($fileName)) {
            echo $this->loadView($fileName);

            return;
        }
        $this->handle404();
    }

    private function handleHomepage()
    {
        $this->navigation();

        return;
    }

    private function handle404()
    {
        echo '404 File not Found';
        $this->navigation();
    }

    private function loadView($fileName)
    {
        ob_start();
        include $fileName;

        return ob_get_clean();
    }

    private function navigation()
    {
        include sprintf('%s/../views/common/nav.php', __DIR__);
    }
}
