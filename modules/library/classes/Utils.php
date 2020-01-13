<?php

/**
 * This file is part of JohnCMS Content Management System.
 *
 * @copyright JohnCMS Community
 * @license   https://opensource.org/licenses/GPL-3.0 GPL-3.0
 * @link      https://johncms.com JohnCMS Project
 */

declare(strict_types=1);

namespace Library;

use Exception;
use PDO;
use Intervention\Image\ImageManagerStatic as Image;

/**
 * Статические методы помошники
 * Class Utils
 *
 * @package Library
 * @author  Koenig(Compolomus)
 */
class Utils
{
    /**
     * редирект на 404
     */
    public static function redir404(): void
    {
        $config = di('config')['johncms'];
        ob_get_level() && ob_end_clean();
        header('Location: ' . $config['homeurl'] . '/?err');
        exit;
    }

    /**
     * Позиция символа в тексте
     *
     * @param string $text
     * @param string $chr
     * @return int
     */
    public static function position(string $text, string $chr): int
    {
        $result = mb_strpos($text, $chr);

        return $result !== false ? $result : 100;
    }

    /**
     * Сортировка по рейтингу
     *
     * @param array $a
     * @param array $b
     * @return int
     */
    public static function cmprang(array $a, array $b): int
    {
        return ($a['rang'] <=> $b['rang']);
    }

    /**
     * Сортировка по алфавиту
     *
     * @param $a
     * @param $b
     * @return int
     */
    public static function cmpalpha(array $a, array $b): int
    {
        return ($a['name'] <=> $b['name']);
    }

    /**
     * Счетчики для каталогов
     *
     * @param int $id
     * @param int $dir
     * @return string
     */
    public static function libCounter(int $id, int $dir): string
    {
        $db = di(PDO::class);
        return $db->query(
            'SELECT COUNT(*) FROM `' . ($dir ? 'library_cats' : 'library_texts') . '` WHERE '
                . ($dir ? '`parent` = ' . $id : '`cat_id` = ' . $id)
        )->fetchColumn()
            . ' ' . ($dir ? ' ' . _t('Sections') : ' ' . _t('Articles'));
    }

    public static function imageUpload(int $id, $image): void
    {
        $smallSize = 32;
        $bigSize = 240;

            Image::configure(['driver' => 'imagick']);
            $img = Image::make($image->getStream());
            // original
            $img->save(UPLOAD_PATH . 'library/images/orig/' . $id . '.png', 100, 'png');
            // big
            $img->resize(
                $bigSize,
                null,
                static function ($constraint) {
                    /** @var $constraint Intervention\Image\Constraint */
                    $constraint->aspectRatio();
                    $constraint->upsize();
                }
            );
            $img->save(UPLOAD_PATH . 'library/images/big/' . $id . '.png', 100, 'png');
            // small
            $img->resize(
                $smallSize,
                null,
                static function ($constraint) {
                    /** @var $constraint Intervention\Image\Constraint */
                    $constraint->aspectRatio();
                    $constraint->upsize();
                }
            );
            $img->save(UPLOAD_PATH . 'library/images/small/' . $id . '.png', 100, 'png');
    }
}
