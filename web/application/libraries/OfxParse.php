<?php
use OfxParser\Parser;

class OfxParse {

	public static function parseOFX($file_path) {
		$ofxParser = new Parser();
		$ofx = $ofxParser->loadFromFile($file_path);
		return $ofx->getTransactions();
	}
}
