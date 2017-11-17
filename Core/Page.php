<?php
namespace Core;
use ErrorException;

/**
 * Class Page
 * @package Core
 */
class Page implements PagePositionsInterface {
    /** @var PathResolver  $pathResolver*/
    protected $pathResolver;
    /** @var  string $layout Path to layout */
    protected $layout;
    /** @var array $view View registry */
    protected $views;
    /** @var PageRenderer $pageRenderer */
    protected $pageRenderer;
    /** @var string $title */
    protected $title;
    protected $errors;

    public function __construct(
        PathResolver $pathResolver,
        PageRenderer $pageRenderer
    )
    {
        $this->pathResolver = $pathResolver;
        $this->pageRenderer = $pageRenderer;
        $this->views = [];
        $this->errors = [];
        $this->title = '';
        $this->layout = '';
    }

    /**
     * @param string|null $path
     * @throws ErrorException
     */
    public function setLayout(string $path = null) {
        if(!$path) {
            $this->layout = '';
            return;
        }
        $this->layout = $this->pathResolver->getCheckedFilePath($path);
    }

    public function getLayout(): string {
        return $this->layout;
    }

    /**
     * @param string $path
     * @param array $params
     */
    public function addView(string $path, array $params)
    {
        $this->views[] = [
            'path' => $this->pathResolver->getCheckedFilePath($path),
            'params' => $params,
        ];
    }

    /**
     * @return \Generator
     */
    public function getView(): \Generator
    {
        foreach($this->views as $view) {
            yield $view;
        }
    }

    public function setTitle(string $title = null)
    {
        $title = $title ?? '';
        $this->title = $title;
    }

    public function addError(string $message)
    {
        $this->errors[] = $message;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function render(): string {
        return $this->pageRenderer::render($this->pageRenderer, $this);
    }
}