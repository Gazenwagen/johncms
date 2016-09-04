<?php

defined('_IN_JOHNCMS') or die('Error: restricted access');

require('../incfiles/head.php');

// Список альбомов юзера
if (isset($_SESSION['ap'])) {
    unset($_SESSION['ap']);
}

/** @var PDO $db */
$db = App::getContainer()->get(PDO::class);

echo '<div class="phdr"><a href="index.php"><b>' . _t('Photo Albums') . '</b></a> | ' . _t('Personal') . '</div>';
$req = $db->query("SELECT * FROM `cms_album_cat` WHERE `user_id` = '" . $user['id'] . "' " . ($user['id'] == $user_id || $rights >= 6 ? "" : "AND `access` > 1") . " ORDER BY `sort` ASC");
$total = $req->rowCount();

if ($user['id'] == $user_id && $total < $max_album && empty($ban) || $rights >= 7) {
    echo '<div class="topmenu"><a href="?act=edit&amp;user=' . $user['id'] . '">' . _t('Create Album') . '</a></div>';
}

echo '<div class="user"><p>' . functions::display_user($user, ['iphide' => 1,]) . '</p></div>';

if ($total) {
    $i = 0;
    while ($res = $req->fetch()) {
        $count = $db->query("SELECT COUNT(*) FROM `cms_album_files` WHERE `album_id` = '" . $res['id'] . "'")->fetchColumn();
        echo ($i % 2 ? '<div class="list2">' : '<div class="list1">') .
            '<img src="../images/album-' . $res['access'] . '.gif" width="16" height="16" class="left" />&#160;' .
            '<a href="?act=show&amp;al=' . $res['id'] . '&amp;user=' . $user['id'] . '"><b>' . functions::checkout($res['name']) . '</b></a>&#160;(' . $count . ')';

        if ($user['id'] == $user_id || $rights >= 6 || !empty($res['description'])) {
            $menu = [
                '<a href="?act=sort&amp;mod=up&amp;al=' . $res['id'] . '&amp;user=' . $user['id'] . '">' . _t('Up') . '</a>',
                '<a href="?act=sort&amp;mod=down&amp;al=' . $res['id'] . '&amp;user=' . $user['id'] . '">' . _t('Down') . '</a>',
                '<a href="?act=edit&amp;al=' . $res['id'] . '&amp;user=' . $user['id'] . '">' . _t('Edit') . '</a>',
                '<a href="?act=delete&amp;al=' . $res['id'] . '&amp;user=' . $user['id'] . '">' . _t('Delete') . '</a>',
            ];
            echo '<div class="sub">' .
                (!empty($res['description']) ? '<div class="gray">' . functions::checkout($res['description'], 1, 1) . '</div>' : '') .
                ($user['id'] == $user_id && empty($ban) || $rights >= 6 ? functions::display_menu($menu) : '') .
                '</div>';
        }

        echo '</div>';
        ++$i;
    }
} else {
    echo '<div class="menu"><p>' . _t('The list is empty') . '</p></div>';
}

echo '<div class="phdr">' . _t('Total') . ': ' . $total . '</div>';