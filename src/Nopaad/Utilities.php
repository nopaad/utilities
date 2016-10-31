<?php
namespace Nopaad;
class Utilities
{
	public static function userAgent()
	{
		$agent = @$_SERVER['HTTP_USER_AGENT'];
		$output = '';
		if (preg_match('/MSIE/i', $agent) || preg_match('/rv:/i', $agent)) {
			$browser = substr($agent, 25, 8);
			if ($browser == "MSIE 7.0") {
				$output = 'ie';
			} elseif ($browser == "MSIE 6.0") {
				$output = 'ie';
			} elseif ($browser == "MSIE 8.0") {
				$output = 'ie';
			} elseif ($browser == "MSIE 9.0") {
				$output = 'ie';
			} elseif ($browser == "MSIE 9.0") {
				$output = 'ie';
			} else {
				$output = "ieo";
			}
		} elseif (preg_match('/Firefox/i', $agent)) {
			$output = "ff";
		} elseif (preg_match('/Chrome/i', $agent)) {
			$output = "chrome";
		} elseif (preg_match('/Safari/i', $agent)) {
			$output = "safari";
		} elseif (preg_match('/Flock/i', $agent)) {
			$output = "flock";
		} elseif (preg_match('/Opera/i', $agent)) {
			$output = "opera";
		} elseif (preg_match('/Netscape/i', $agent)) {
			$output = "netscape";
		}
		if (stristr(@$_SERVER['HTTP_USER_AGENT'], "mac")) {
			$output .= ' osx';
		} elseif (stristr(@$_SERVER['HTTP_USER_AGENT'], "linux")) {
			$output .= ' linux';
		} elseif (stristr(@$_SERVER['HTTP_USER_AGENT'], "windows")) {
			$output .= ' windows';
		}

		return 'datx-' . $output;
	}

	/*
	 * test 2
	 */
	public static function persianNumberToFloat($string)
	{
		$persian_digits_1 = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
		$persian_digits_2 = ['٩', '٨', '٧', '٦', '٥', '٤', '٣', '٢', '١', '٠'];
		$all_persian_digits = array_merge($persian_digits_1, $persian_digits_2);
		$replaces = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '9', '8', '7', '6', '5', '4', '3', '2', '1'];
		$output = str_replace([" ", ",", "'"], ["", "", ""], $string);
		$output = str_replace($all_persian_digits, $replaces, $output);
		$output = floatval($output);

		return $output;
	}

    protected function checkNationalCode($code = '')
    {
        $code = (string) preg_replace('/[^0-9]/', '', $code);
        if (strlen($code) > 10 or strlen($code) < 8) {
            return false;
        }
        if (strlen($code) == 8) {
            $code = "00" . $code;
        }
        if (strlen($code) == 9) {
            $code = "0" . $code;
        }
        $list_code = str_split($code);
        $last = (int) $list_code[9];
        unset($list_code[9]);
        $i = 10;
        $sum = 0;
        foreach ($list_code as $key => $_) {
            $sum += intval($_) * $i--;
        }
        $mod = (int) $sum % 11;
        if ($mod >= 2) {
            $mod = 11 - $mod;
        }
        return $mod == $last;
    }

}