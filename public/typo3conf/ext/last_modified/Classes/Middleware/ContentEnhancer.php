<?php

declare(strict_types=1);

namespace Causal\LastModified\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use TYPO3\CMS\Core\Http\SelfEmittableStreamInterface;
use TYPO3\CMS\Core\Http\Stream;
use TYPO3\CMS\Core\Information\Typo3Version;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;

class ContentEnhancer implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $response = $handler->handle($request);
        if (substr($response->getHeaderLine('Content-Type'), 0, 9) === 'text/html') {
            $body = $response->getBody();
            if (!($body instanceof SelfEmittableStreamInterface)) {
                $content = $body->__toString();
                $pattern = '/<!--###EXT:last_modified:(.*?)###-->/';
                if (preg_match($pattern, $content, $matches)) {
                    $config = json_decode($matches[1], true) ?? [];
                    $format = $config['format'] ?? ($GLOBALS['TYPO3_CONF_VARS']['SYS']['ddmmyy'] ?: 'Y-m-d');

                    /** @var TypoScriptFrontendController $typoScriptFrontendController */
                    if (version_compare((new Typo3Version())->getBranch(), '11.5', '<')) {
                        $typoScriptFrontendController = $GLOBALS['TSFE'];
                    } else {
                        $typoScriptFrontendController = $request->getAttribute('frontend.controller');
                    }
                    $sysLastChanged = $typoScriptFrontendController->register['SYS_LASTCHANGED'];
                    if (str_contains($format, '%')) {
                        // @todo Replace deprecated strftime in php 8.1. Suppress warning in v11.
                        $lastModification = @strftime($format, $sysLastChanged);
                    } else {
                        $lastModification = date($format, $sysLastChanged);
                    }
                    $newContent = preg_replace($pattern, $lastModification, $content);

                    $newBody = new Stream('php://temp', 'wb+');
                    $newBody->write($newContent);

                    $response = $response->withBody($newBody);
                }
            }
        }
        return $response;
    }
}
