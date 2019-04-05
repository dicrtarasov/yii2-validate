<?php
namespace dicr\validate;

use yii\validators\Validator;

/**
 * Валидатор данных типа флаг со значениями null/datetime, который конвертирует значения типа true в текущее
 * дату/время с заданным форматом.
 *
 * Принимаемые значение:
 * false (null, 0, false, "", "false", "", "no", "off") => null,
 * true (1, true, "true", "yes", "on") => date(формат, time())
 * "Y-m-d H:i:s", int => date(формат, значение)
 *
 * Используется с полями типа DATETIME/null, например в поле типа disabled, published, ....
 *
 * @author Igor (Dicr) Tarasov <develop@dicr.org>
 * @version 180623
 */
class TimeFlagValidator extends Validator
{
	/** @var string формат даты */
	public $format = 'Y-m-d H:i:s';

	/** @var bool */
	public $skipOnEmpty = false;

	/** @var string сообщение об ошибке */
	public $message = 'Некорретное значение флага/даты';

	/**
	 * Форматирует дату
	 *
	 * @param int $time значение
	 * @return string
	 */
	protected function format(int $time=0)
	{
	    return date($this->format, $time ?: null);
	}

	/**
	 * {@inheritDoc}
	 * @see \yii\validators\Validator::validateAttribute()
	 */
	public function validateAttribute($model, $attribute)
	{
		$val = $model[$attribute] ?? null;

		if ($this->isEmpty($val) || empty($val)) { // null, "", [], 0, false
			$model->{$attribute} = null;
		} elseif ($val === true) {
			$model->{$attribute} = $this->format();
		} elseif (is_numeric($val)) {
			$val = (int)$val;
			if (empty($val)) {
			    $model->{$attribute} = null;
			} elseif ($val == 1) {
			    $model->$attribute = $this->format();
			} else {
			    $model->{$attribute} = $this->format($val);
			}
		} elseif (is_string($val)) {
			$val = trim($val);
			if ($val == '' || in_array($val, ['0', 'no', 'false', 'off'])) {
			    $model->{$attribute} = null;
			} elseif (in_array($val, ['1', 'yes', 'true', 'on'])) {
			    $model->{$attribute} = $this->format();
			} else {
				$tstamp = strtotime($val);
				if ($tstamp <= 0) {
				    $this->addError($model, $attribute, $this->message);
				} else {
				    $model->{$attribute} = $this->format($tstamp);
				}
			}
		} else {
			$this->addError($model, $attribute, $this->message);
		}
	}
}