<?php
declare(strict_types=1);
namespace Goran\SaveCloseCe\EventListeners;

use Goran\SaveCloseCe\Service\ButtonBarService;
use TYPO3\CMS\Backend\Template\Components\ModifyButtonBarEvent;

/**
 * Event Listener for TYPO3\CMS\Backend\Template\Components\ModifyButtonBarEvent, used since TYPO3 >= v12.
 */
final class ButtonBarEventListener
{
    public function __construct(private ButtonBarService $buttonBarService)
    {}

    public function __invoke(ModifyButtonBarEvent $event): void
    {
        $buttons = $event->getButtons();
        $buttonBar = $event->getButtonBar();
        $buttons = $this->buttonBarService->addSaveCloseButton($buttons, $buttonBar);
        $buttons = $this->buttonBarService->addSaveViewButton($buttons, $buttonBar);
        $event->setButtons($buttons);
    }
}
