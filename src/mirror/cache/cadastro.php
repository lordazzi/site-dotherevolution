<?php if(!class_exists('raintpl')){exit;}?><form class="floating black-marinho" id="formulario-de-cadastro" method="post" action="actions/exercer-cadastro.php">
	<div class="form-element">
		<label for="nome">Um nome:</label><input pattern="^[A-Za-zÁÉÍÓÚÀÈIÒÙÃÕÑÇÜáéíóúàèìòúãõñçü -]+$" required="required" data-minlength="6" type="text" name="nome" id="nome" /><br />
	</div>
	<div class="form-element">
		<label for="email">E-mail:</label><input required="required" type="email" name="email" id="email" /><br />
	</div>
	<div class="form-element">
		<label for="senha">Senha:</label><input required="required" data-minlength="6" type="password" name="senha" id="senha" /><br />
	</div>
	<div class="form-element">
		<label for="confirm">Confirme:</label><input required="required" data-minlength="6" type="password" name="confirm" id="confirm" data-equal="senha" /><br />
	</div>
	<div class="form-element">
		<label for="voce-eh">Você é:</label>
		<select name="voce-eh" id="voce-eh" required="required" data-but="0">
			<option value="0" selected="selected" disabled="disabled"> :: Selecione uma opção :: </option>
			<option value="1">Contra a Manifestação</option>
			<option value="2">Neutro</option>
			<option value="3">Apóio a Manifestação</option>
			<option value="4">Manifestante pacífico</option>
			<option value="5">Manifestante extremo</option>
		</select>
	</div>
	<button class="floating button" type="submit" disabled="disabled" title="Do the Revolution, baby!">
		<span class="span-left">::</span>
		<span>Cadastrar!</span>
		<span class="span-right">::</span>
	</button>
</form>

