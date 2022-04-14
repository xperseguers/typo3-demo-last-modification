<?php

(static function (string $_EXTKEY) {
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        $_EXTKEY,
        'DemoIncomplete',
        [
            \Causal\LastModified\Controller\DemoController::class => 'incomplete',
        ],
        []
    );
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        $_EXTKEY,
        'DemoCached',
        [
            \Causal\LastModified\Controller\DemoController::class => 'cached',
        ],
        []
    );
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        $_EXTKEY,
        'DemoUncached',
        [
            \Causal\LastModified\Controller\DemoController::class => 'uncached',
        ],
        [
            \Causal\LastModified\Controller\DemoController::class => 'uncached',
        ]
    );
})('last_modified');
