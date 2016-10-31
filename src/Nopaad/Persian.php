<?php
namespace Nopaad;
use Cache;
class Persian
{
	static protected $persian_digits = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹', '٤', '٥', '٦'];
	static protected $english_digits = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '4', '5', '6'];
	static protected $wrong_characters = ['ي', 'ك'];
	static protected $acceptable_characters = ['ی', 'ک'];

	/**
	 * @param $string
	 *
	 * @return array or false
	 */
	public static function permutations($string)
	{
		$serialized_permutations = Cache::rememberForever('persian.string.permutations.' . base64_encode($string), function () use ($string) {
			$string = self::correct($string);
			$output = [$string];
			foreach (self::_positionsOfSpecialCharacters($string) as $character => $val) {
				foreach ($val as $position_of_occurance) {
					foreach ($output as $new_string) {
						$key_of_character_in_the_merged_array = self::_sameCharacters($character)['key'];
						$output[] = self::_mbSubstrReplace($new_string, self::_getMergedWrong()[$key_of_character_in_the_merged_array], $position_of_occurance);
					}
				}
			}

			return serialize($output);
		});

		return unserialize($serialized_permutations);
	}

	public static function correct($string)
	{
		$output = str_replace(self::_getMergedWrong(), self::_getMergedAcceptable(), $string);

		return $output;
	}

	public static function latinize($string)
	{
		$output = str_replace(self::$persian_digits, self::$english_digits, $string);

		return $output;
	}

	/**
	 * @return array
	 */
	private static function _getMergedWrong()
	{
		return array_merge(self::$english_digits, self::$wrong_characters);
	}

	/**
	 * @return array
	 */
	private static function _getMergedAcceptable()
	{
		return array_merge(self::$persian_digits, self::$acceptable_characters);
	}

	/**
	 * @param $string
	 *
	 * @return array
	 */
	private static function _positionsOfSpecialCharacters($string)
	{
		$positions = [];
		$last_position = 0;
		foreach (self::_getMergedAll() as $character) {
			while (($last_position = mb_strpos($string, $character, $last_position)) !== false) {
				$positions[$character][] = $last_position;
				$last_position = $last_position + mb_strlen($character);
			}
		}

		return $positions;
	}

	/**
	 * @return array
	 */
	private static function _getMergedAll()
	{
		return array_merge(self::_getMergedAcceptable(), self::_getMergedWrong());
	}

	/**
	 * @param $character
	 *
	 * @return array
	 */
	private static function _sameCharacters($character)
	{
		$key = array_search($character, self::_getMergedAcceptable());
		if ($key === false) {
			$key = array_search($character, self::_getMergedWrong());
		}
		$output = [
			'key' => $key,
			self::_getMergedAcceptable()[$key],
			self::_getMergedWrong()[$key]
		];

		return $output;
	}

	/**
	 * @param $string
	 * @param $replacement
	 * @param $start
	 *
	 * @return string
	 */
	private static function _mbSubstrReplace($string, $replacement, $start)
	{
		$first_part = mb_substr($string, 0, $start);
		$second_part = ($start == 0) ? mb_substr($string, 1) : mb_substr($string, $start + 1);

		return $first_part . $replacement . $second_part;
	}
}
