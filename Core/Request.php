<?php
namespace Core;

/**
 * Class Request
 * @package Core
 */
class Request
{
    protected $url;
    protected $query;
    protected $parsedUrl;
    protected $isAjax;
    protected $isPost;

    public function __construct()
    {
        $this->setUrlParams()
            ->setIsAjax()->setIsPost();
    }

    protected function setUrlParams(): self
    {
        $requestUri = $_SERVER['REQUEST_URI'] ?? '/'; // fix for cli...

        $parsedUri = parse_url($requestUri);
        if (!$parsedUri) {
            throw new \ErrorException('Ошибка разбора $_SERVER[\'REQUEST_URI\']');
        }
        $this->query = $parsedUri['query'] ?? '';
        $this->url = $parsedUri['path'] ?? '/';
        $tmpArUrl = explode('/', $this->url);
        if (!is_array($tmpArUrl)) {
            throw new \ErrorException('Ошибка разбора URL.');
        }
        $this->parsedUrl = array_diff($tmpArUrl, ['']);

        return $this;
    }

    protected function setIsPost(): self
    {
        if (isset($_SERVER['REQUEST_METHOD']) && 'POST' == $_SERVER['REQUEST_METHOD']) {
            $this->isPost = true;
        } else {
            $this->isPost = false;
        }
        return $this;
    }

    public function isPost(): bool
    {
      return $this->isPost;
    }

    protected function setIsAjax(): self
    {
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && 'XMLHttpRequest' === $_SERVER['HTTP_X_REQUESTED_WITH']) {
            $this->isAjax = true;
        } else {
            $this->isAjax = false;
        }
        return $this;
    }

    public function isAjax(): bool
    {
        return $this->isAjax;
    }

    public function getQuery(): string
    {
        return $this->query;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getParsedUrl(): array
    {
        return $this->parsedUrl;
    }
}