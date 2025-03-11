<?php

function _csrfToken($overwrite = FALSE) {
	if (session_status() == PHP_SESSION_NONE) {
		session_start();
	}

	if ($overwrite || !isset($_SESSION['csrf_token'])) {
		$_SESSION['csrf_token'] = bin2hex(random_bytes(32));
	}

	return $_SESSION['csrf_token'];
}

function _parse($expression) {
  global $app;
  return $app->parse('{{'.$expression.'}}');
}