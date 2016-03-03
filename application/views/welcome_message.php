<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>欢迎界面</title>

	<style type="text/css">
    * {
        margin: 0;
        padding: 0;
    }

	::selection { background-color: #E13300; color: white; }
	::-moz-selection { background-color: #E13300; color: white; }

	body {
		background-color: #fff;
		color: #4F5155;
		overflow: hidden;
	}

	p.footer {
	    position: fixed;
	    top: 0;
	    left: 0;
	    right: 0;
		text-align: right;
		font-size: 11px;
		/*border-top: 1px solid #D0D0D0;*/
		line-height: 32px;
		padding: 0 10px 0 10px;
		/*margin: 20px 0 0 0;*/
	}

	</style>
</head>
<body>

<div id="container">
    <video autoplay loop muted preload="auto" width="100%" height="100%" style="visibility: visible;">
        <source src="http://video.wixstatic.com/video/11062b_4f14b356c1df4854968cf1cc94ca98c5/1080p/mp4/file.mp4" type="video/mp4">
        <source src="http://video.wixstatic.com/video/11062b_4f14b356c1df4854968cf1cc94ca98c5/1080p/webm/file.webm" type="video/webm">
    </video>
</div>

<p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds. Memory use <strong>{memory_usage}</strong></p>
</body>
</html>