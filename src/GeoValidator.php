<?php
/**
 * @copyright 2019-2020 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license proprietary
 * @version 04.07.20 09:27:14
 */

declare(strict_types = 1);
namespace dicr\validate;

use InvalidArgumentException;
use yii\base\Exception;
use function array_values;
use function count;
use function is_array;

/**
 * Валидатор гео-координат.
 *
 * @noinspection PhpUnused
 */
class GeoValidator extends AbstractValidator
{
    /**
     * Парсит координаты в формате через запятую
     *
     * @param string|float[] $value
     * @param array|null $config
     * @return float[]|null список email
     * @throws Exception
     */
    public static function parse($value, array $config = null)
    {
        if ($value === null || $value === '' || $value === []) {
            return null;
        }

        if (! is_array($value)) {
            $matches = null;
            if (! preg_match('~^(\d+\.\d+)[\,\s]+(\d+\.\d+)$~', (string)$value, $matches)) {
                throw new Exception('Некорректный формат гео-координат: ' . $value);
            }

            $value = [(float)$matches[1], (float)$matches[2]];
        }

        if (count($value) !== 2) {
            throw new Exception('Некорректное значение гео-координат');
        }

        $value = array_values($value);
        return [
            (float)$value[0],
            (float)$value[1]
        ];
    }

    /**
     * Форматирует значение гео-координат в строку через запятую.
     *
     * @param string|float[2] $value
     * @param array|null $config
     * @return string
     */
    public static function format($value, array $config = null)
    {
        if (! is_array($value) || count($value) !== 2) {
            throw new InvalidArgumentException('value');
        }

        return implode(', ', $value);
    }
}
