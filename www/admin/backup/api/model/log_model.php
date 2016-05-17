<?php

class log_model extends StormModel
{
	public function Log($path, $text, $prependTime = true)
	{
		if ($prependTime)
			$text = strftime('Le %d-%m-%Y à %H:%M:%S'). ': ' .$text;

		if (is_file($path))
			return file_put_contents($path, $text.PHP_EOL, FILE_APPEND | LOCK_EX);
		else
			return file_put_contents($path, $text.PHP_EOL);
	}
}