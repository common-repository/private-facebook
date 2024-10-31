</head>
<body>
	<div id="private-facebook" class="restricted">
		<h1 style="margin:0px">Restricted area</h1>
		<small>You need to connect your Facebook account to this website to access this page.</small>
		<a class="facebook-connect" href="<?= $facebook->getLoginUrl(array('scope' => 'email')) ?>">&nbsp;</a>
	</div>
</body></html>
<?php exit(); ?>