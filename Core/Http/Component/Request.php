<?php
namespace ANSR\Core\Http\Component;

class Request implements RequestInterface
{
    private $request = [];
    private $httpInfo = [];
    private $uri;
    private $host;

    public function __construct(array $request, array $httpInfo, $uri, $host)
    {
        $this->request = $request;
        $this->httpInfo = $httpInfo;
        $this->uri = $uri;
        $this->host = $host;
    }

    public function getParameter(string $key): string
    {
        return $this->request[$key];
    }

    public function getHttpMethod(): string
    {
        return $this->httpInfo["REQUEST_METHOD"];
    }

    public function getUri(): string
    {
        return $this->uri;
    }

    public function getScriptName(): string
    {
        return $this->httpInfo["PHP_SELF"];
    }

    public function getHost(): string
    {
        return $this->host;
    }
}