<?php

namespace Goran\SaveCloseCe\Hooks;

use Goran\SaveCloseCe\Service\ButtonBarService;
use TYPO3\CMS\Backend\Template\Components\ButtonBar;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Add an extra save and close button at the end
 *
 * Class SaveButtonHook
 * @package Goran\SaveCloseCe\Hooks
 *
 * @todo This class is only for < v12, remove when support for v11 and below is dropped
 */
class SaveCloseHook
{
    protected ButtonBarService $buttonBarService;
    public function __construct(?ButtonBarService $buttonBarService = null)
    {
        if (!$buttonBarService) {
            $buttonBarService = GeneralUtility::makeInstance(ButtonBarService::class);
        }
        $this->buttonBarService = $buttonBarService;
    }

    /**
     * @param array $params
     * @param ButtonBar $buttonBar
     * @return array
     */
    public function addSaveCloseButton(array $params, ButtonBar $buttonBar): array
    {
        $buttons = $params['buttons'] ?? [];
        return $this->buttonBarService->addSaveCloseButton($buttons, $buttonBar);
    }
}
