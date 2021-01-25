<?php

class Router
{
    /** @var Request $request */
    private $request;

    /** @var array $supportedHttpMethods */
    private $supportedHttpMethods = [
        "GET",
        "POST",
        "PATCH",
        "OPTIONS"
    ];

    /**
     * Router constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @param $name
     * @param $args
     */
    public function __call($name, $args)
    {
        [$route, $method] = $args;

        if (!in_array(strtoupper($name), $this->supportedHttpMethods)) {
            $this->invalidMethodHandler();
        }

        $this->{strtolower($name)}[$this->formatRoute($route)] = $method;
    }

    /**
     * Removes trailing forward slashes from the right of the route.
     * @param string route
     * @return string
     */
    private function formatRoute(string $route) : string
    {
        $result = rtrim($route, '/');

        if ($result === '') {
            return '/';
        }

        return $result;
    }

    private function invalidMethodHandler()
    {
        header("{$this->request->serverProtocol} 405 Method Not Allowed.", true, 405);
    }

    private function defaultRequestHandler()
    {
        header("Page not found.", true, 404);
    }


    public function resolve()
    {
        $methodDictionary = $this->{strtolower($this->request->requestMethod)};
        $formatedRoute = $this->formatRoute($this->request->requestUri);
        if (empty($methodDictionary[$formatedRoute])) {
            $this->defaultRequestHandler();
            return;
        } else {
            $method = $methodDictionary[$formatedRoute];
        }
        echo call_user_func_array($method, array($this->request));
    }

    public function __destruct()
    {
        $this->resolve();
    }
}
