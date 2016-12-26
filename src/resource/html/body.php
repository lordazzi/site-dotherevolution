
	</head>
	<body>
		<div id="container">
			<?php if((bool) @$_SESSION["idusuario"] == FALSE) { ?>
				<form class="black-marinho" id="login-form">
					<label for="auth-login">E-mail:</label> <input id="auth-login" name="auth-login" type="text" /><br />
					<label for="auth-senha">Senha:</label> <input id="auth-senha" name="auth-senha" type="password" />
					<button id="submit-form" type="button">Entrar</button>
				</form>
			<?php } else { ?>
				<form class="black-marinho" style="width: 50px; text-align: center" id="login-form">
					<a href="javascript:void(0)" id="sair-do-sistema">Sair</a>
				</form>
			<?php } ?>
			<header id="main-header">
				<h1>DO THE REVOLUTION</h1>
			</header>
			<nav id="main-menu">
				<ul>
					<?php if((bool) @$_SESSION["idusuario"] == FALSE) { ?>
					<li><a href="cadastro.php">Cadastrar</a></li>
					<?php }?>
					<li><a href="index.php">Inicio</a></li>
					<li><a href="javascript:void(0)" title="Em desenvolvimento">Forúm</a></li>
					<li><a href="frases.php" title="As frases que as pessoas mais gostarem aparecem na página inicial do site">Sua frase</a></li>
				</ul>
			</nav>
			<section id="content">