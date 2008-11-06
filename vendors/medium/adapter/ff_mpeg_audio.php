<?php
/**
 * Ff Mpeg Audio Medium Adapter File
 * 
 * Copyright (c) $CopyrightYear$ David Persson
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 * 
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE
 * 
 * PHP version $PHPVersion$
 * CakePHP version $CakePHPVersion$
 * 
 * @category   media handling
 * @package    attm
 * @subpackage attm.plugins.media.libs.medium.adapter
 * @author     David Persson <davidpersson@qeweurope.org>
 * @copyright  $CopyrightYear$ David Persson <davidpersson@qeweurope.org>
 * @license    http://www.opensource.org/licenses/mit-license.php The MIT License
 * @version    SVN: $Id$
 * @version    Release: $Version$
 * @link       http://cakeforge.org/projects/attm The attm Project
 * @since      media plugin 0.50
 * 
 * @modifiedby   $LastChangedBy$
 * @lastmodified $Date$
 */
/**
 * Ff Mpeg Audio Medium Adapter Class
 * 
 * @category   media handling
 * @package    attm
 * @subpackage attm.plugins.media.libs.medium.adapter
 * @author     David Persson <davidpersson@qeweurope.org>
 * @copyright  $CopyrightYear$ David Persson <davidpersson@qeweurope.org>
 * @license    http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link       http://cakeforge.org/projects/attm The attm Project
 * @link       http://ffmpeg.mplayerhq.hu/
 */
class FfMpegAudioMediumAdapter extends MediumAdapter {
	var $require = array(
							'mimeTypes' => array(
										'audio/ogg',
										'audio/mpeg',
										'audio/ms-wma',
										'audio/realaudio',
										'audio/wav',
										),
							'extensions' => array('ffmpeg'),
							);
							
	function initialize(&$Medium) {
		if (isset($Medium->objects['ffmpeg_movie'])) {
			return true;
		}
		if (!isset($Medium->file)) {
			return false;
		}
		
		$Medium->objects['ffmpeg_movie'] = new ffmpeg_movie($Medium->file);
		
		if (!$Medium->objects['ffmpeg_movie']->hasAudio()) {
			return false;
		}
		
		return true;
	}
	
	function artist(&$Medium) {
		return $Medium->objects['ffmpeg_movie']->getArtist();
	}
	
	function title(&$Medium) {
		return $Medium->objects['ffmpeg_movie']->getTitle();
	}
	
	function year(&$Medium) {
		return $Medium->objects['ffmpeg_movie']->getYear();
	}
	
	function duration(&$Medium) {
		return $Medium->objects['ffmpeg_movie']->getDuration();
	}
	
	function track(&$Medium) {
		return $Medium->objects['ffmpeg_movie']->getTrackNumber();
	}
		
	function samplingRate(&$Medium) {
		return $Medium->objects['ffmpeg_movie']->getAudioSampleRate();
	}
}
?>