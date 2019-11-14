<?php

declare(strict_types=1);

/*
 * This file is part of JohnCMS Content Management System.
 *
 * @copyright JohnCMS Community
 * @license   https://opensource.org/licenses/GPL-3.0 GPL-3.0
 * @link      https://johncms.com JohnCMS Project
 */

defined('_IN_JOHNCMS') || die('Error: restricted access');

/**
 * @var PDO                       $db
 * @var Johncms\Api\UserInterface $user
 * @var League\Plates\Engine      $view
 */

// Чистка новостей
if ($user->rights >= 7) {
    if (! empty($_POST)) {
        $cl = isset($_POST['cl']) ? (int) ($_POST['cl']) : '';

        switch ($cl) {
            case '1':
                // Чистим новости, старше 1 недели
                $db->query('DELETE FROM `news` WHERE `time` <= ' . (time() - 604800));
                $db->query('OPTIMIZE TABLE `news`');
                $message = _t('Delete all news older than 1 week');
                break;

            case '2':
                // Проводим полную очистку
                $db->query('TRUNCATE TABLE `news`');
                $message = _t('Delete all news');
                break;
            default:
                // Чистим сообщения, старше 1 месяца
                $db->query('DELETE FROM `news` WHERE `time` <= ' . (time() - 2592000));
                $db->query('OPTIMIZE TABLE `news`;');
                $message = _t('Delete all news older than 1 month');
        }

        echo $view->render('news::result', [
            'title'    => _t('Clear'),
            'message'  => $message,
            'type'     => 'success',
            'back_url' => '/news/',
        ]);
    } else {
        echo $view->render('news::clear');
    }
} else {
    pageNotFound();
}
