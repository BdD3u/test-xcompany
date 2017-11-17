<?php

namespace Core;
//error_reporting(\E_ALL);

/**
 * Class PageRenderer
 * @package Core
 *
 * @property-read string $content
 * @property-read string $title
 * @property-read array $errors
 */
class PageRenderer implements PagePositionsInterface
{
    /** @var  Page $page */
    protected $page;
    /** @var  string $content */
    protected $content;
    /** @var PageScope */
    protected $pageScope;

    public function __construct(PageScope $pageScope)
    {
        $this->pageScope = $pageScope;
    }

    protected function setContent()
    {
        ob_start();
        foreach ($this->page->getView() as $view) {
            $this->pageScope::content($view['path'], $view['params']);
        }
        $this->content = ob_get_clean();
    }

    /**
     * Хелпер для отрисовки страницы, статический для того чтобы не отображался при работе с объектом.
     *
     * @param PageRenderer $pageRenderer
     * @param Page $page
     * @return string - rendered page
     */
    public static function render(self $pageRenderer, Page $page): string
    {
        $pageRenderer->page = $page;
        $path = $page->getLayout();
        ob_start();
            if($path) {
                $pageRenderer->pageScope::page($pageRenderer, $path);
            } else {
                echo $pageRenderer->readContentProp();
            }
        return ob_get_clean();
    }

    protected function readContentProp(): string
    {
        if (!isset($this->content)) {
            $this->setContent();
        }
        return $this->content;
    }

    protected function readTitleProp(): string
    {
        return $this->page->getTitle();
    }

    protected function readErrorsProp(): array
    {
        return $this->page->getErrors();
    }

    public function __get($key)
    {
        $getPropName = 'read' . ucfirst($key) . 'Prop';
        if (method_exists($this, $getPropName)) {
            return $this->$getPropName();
        }
        return null;
    }
}