<?php

return [
    'frontend' => [
        'causal/last_modified/content-enhancer' => [
            'target' => \Causal\LastModified\Middleware\ContentEnhancer::class,
            'before' => [
                'typo3/cms-frontend/content-length-headers',
            ],
        ],
    ],
];
