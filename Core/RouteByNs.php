<?php
namespace Core;
/**
 * Class RouteByNs
 * @package Core
 */
class RouteByNs extends RouteAbstract
{
    protected $baseNs;
    protected $baseUrl;

    protected $url;

    public function __construct(string $currentUrl, string $baseNs, string $baseUrl)
    {
        $this->baseNs = $baseNs;
        $this->baseUrl = $baseUrl;
        $this->url = $currentUrl;
    }

    public function isActive()
    {

        if(isset($this->isActive)) {
            return $this->isActive;
        }

        if(0 === strpos($this->url, $this->baseUrl)) {
            $endBaseUrl = strlen($this->baseUrl);
            // get raw controller and action
            $rawCtrlAct = static::toCamelCase(
                static::toCamelCase(
                    str_replace('/', '\\', substr($this->url, $endBaseUrl))
                , '\\', false)
            );
            // remove last back slash.
            if(substr($rawCtrlAct, -1) === '\\') {
                $rawCtrlAct = substr($rawCtrlAct, 0, -1);
            }
            // check IndexController->indexAction
            if($rawCtrlAct) {
                $tmpCtrl = $this->baseNs . '\\' . $rawCtrlAct . '\\' . static::CTRL_DEFAULT_NAME;
            } else {
                $tmpCtrl = $this->baseNs . '\\' . static::CTRL_DEFAULT_NAME;
            }
            $this->trySetCtrlAct($tmpCtrl, static::CTRL_DEFAULT_ACTION);
            // check NameController->indexAction
            if(!$this->isActive && $rawCtrlAct) {
                $tmpCtrl = $this->baseNs . '\\' . $rawCtrlAct . static::CTRL_SUFFIX;
                $this->trySetCtrlAct($tmpCtrl, static::CTRL_DEFAULT_ACTION);
            }
            // check NameController->nameAction
            if(!$this->isActive && $rawCtrlAct) {
                $lastSlashPos = strrpos($rawCtrlAct, '\\');
                if($lastSlashPos) {
                    $rawCtrlActLength = strlen($rawCtrlAct);
                    $reversePosAct = -1*($rawCtrlActLength - $lastSlashPos - 1);
                    $rawCtrl = substr($rawCtrlAct, 0, $lastSlashPos);
                    $rawAct = substr($rawCtrlAct, $reversePosAct);
                } else {
                    $rawCtrl = $rawAct = false;
                }
                if($rawCtrl && $rawAct) {
                    // check NameController->nameAction
                    $tmpCtrl = $this->baseNs . '\\' . $rawCtrl . static::CTRL_SUFFIX;
                    $tmpAct = $rawAct . static::CTRL_ACTION_SUFFIX;
                } else {
                    // check IndexController->nameAction
                    $tmpCtrl = $this->baseNs . '\\' . static::CTRL_DEFAULT_NAME;
                    $tmpAct = $rawCtrlAct . static::CTRL_ACTION_SUFFIX;
                }
                $this->trySetCtrlAct($tmpCtrl, lcfirst($tmpAct));
            }
        }
        return $this->isActive;
    }
}