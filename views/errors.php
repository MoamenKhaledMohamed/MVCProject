<?php
/**
 * @var $exception Exception
 * @var $this \app\core\View
 */
$this->title = "Errors";
echo "<h3>" . $exception->getCode() . "     " . $exception->getMessage() . "</h3>"?>