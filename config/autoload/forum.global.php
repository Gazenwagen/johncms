<?php

/**
 * This file is part of JohnCMS Content Management System.
 *
 * @copyright JohnCMS Community
 * @license   https://opensource.org/licenses/GPL-3.0 GPL-3.0
 * @link      https://johncms.com JohnCMS Project
 */

declare(strict_types=1);

return [
    'forum' => [
        'extensions' => [
            // Архивы
            'archives'  => [
                'zip',
                'rar',
                '7z',
                'tar',
                'gz',
                'apk',
            ],

            // Аудио файлы
            'audio'     => [
                'flac',
                'aac',
                'mp3',
                'amr',
            ],

            // Файлы документов и тексты
            'documents' => [
                'txt',
                'pdf',
                'doc',
                'docx',
                'rtf',
                'djvu',
                'xls',
                'xlsx',
            ],

            // Файлы Java
            'java'      => [
                'sis',
                'sisx',
                'apk',
            ],

            // Картинки
            'pictures'  => [
                'jpg',
                'jpeg',
                'gif',
                'png',
                'bmp',
            ],

            // Файлы SIS
            'sis'       => [
                'sis',
                'sisx',
            ],

            // Файлы видео
            'video'     => [
                '3gp',
                'avi',
                'flv',
                'mpeg',
                'mp4',
            ],

            // Файлы Windows приложений
            'windows'   => [
                'exe',
                'msi',
            ],

            // Прочие типы файлов
            'others'    => [
                'wmf',
            ],
        ],
    ],
];
