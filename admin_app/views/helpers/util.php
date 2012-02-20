<?php
/* /app/views/helpers/util.php */

class UtilHelper extends AppHelper {
	function endsWith($haystack, $needle, $case=FALSE) {
		if ($case) {
			return (strcmp(substr($haystack, strlen($haystack) - strlen($needle)),$needle)===0);
		}
		return (strcasecmp(substr($haystack, strlen($haystack) - strlen($needle)),$needle)===0);
	}

	function startsWith($haystack, $needle, $case=FALSE) {
		if ($case) {
			return (strcmp(substr($haystack, 0, strlen($needle)),$needle)===0);
		}
		return (strcasecmp(substr($haystack, 0, strlen($needle)),$needle)===0);
	}
}

?>
