<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8" />
		<title>Hello React! DEV env only</title>
	</head>
	<body>
		<div id="example"></div>

		<?php
		phpinfo();
		?>

		<!-- Dependencies -->
        <script src="./node_modules/react/umd/react.development.js"></script>
        <script src="./node_modules/react-dom/umd/react-dom.development.js"></script>

        <!-- Main -->
        <script src="./dist/bundle.js"></script>
	</body>
</html>