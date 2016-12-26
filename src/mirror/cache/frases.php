<?php if(!class_exists('raintpl')){exit;}?><?php if( $this->var['login'] ){ ?>
	<div class="floating black-marinho" id="objetivo">
		<div class="explanation">
			O objetivo dessa parte e escrever frases curtas de incentivo, as frases que as pessoas gostarem mais (você pode curtir as frases) aparecem na página inicial do site.
		</div>
		<form>
			<button id="abrir-menu-da-frase" class="button" type="button">
				<span class="span-left">::</span>
				<span>Escreva a sua</span>
				<span class="span-right">::</span>
			</button>
		</form>
	</div>
<?php } ?>

<!-- <form id="search-form" class="floating black-marinho">
	<div class="form-element seacher">
		<label>Pesquisar:</label><input type="search" placeholder="Pesquise pelo conteúdo da frase ou pelo autor" />
		<!-- <input class="datepicker" type="text" />
		<input class="datepicker" type="text" /> ->
	</div>
</form> -->

<section id="phrases">
	<?php $counter1=-1; if( isset($this->var['frases']) && is_array($this->var['frases']) && sizeof($this->var['frases']) ) foreach( $this->var['frases'] as $key1 => $value1 ){ $counter1++; ?>
		<article class="floating">
			<span class="author"><?php echo $value1["txtapelido"];?>: </span>
			<span class="phrase">
				<?php echo $value1["txtcomentario"];?>
					<?php if( $this->var['login'] ){ ?>
						<img title="Clique aqui para curtir essa frase." src="/resource/ico/16/silver-<?php echo $value1["isactive"];?>like.png" class="<?php echo $value1["isactive"];?>like" data-idcomentario="<?php echo $value1["idcomentario"];?>" />
					<?php } ?>
					<span title="Total de pessoas que gostaram dessa frase: <?php echo $value1["nrquantidade"];?>" class="like-total floating"><?php echo $value1["nrquantidade"];?></span>
			</span><br />
			<span class="datetime"><?php echo $value1["dtcadastro"];?></span>
		</article>
	<?php } ?>
</section>

<?php if( $this->var['login'] ){ ?>
	<div class="block-background" id="phrase-write-place">
		<form class="floating black-marinho" id="write-your-phrase" method="post" action="actions/">
			<textarea maxlength="160" id="postar-minha-frase" placeholder="Conteúdo HTML é bloqueado, escreva apenas texto."></textarea>
			
			<div class="form-element">
				<button id="enviar-frase-escrita" class="button" type="button">
					<span class="span-left">::</span>
					<span>Enviar</span>
					<span class="span-right">::</span>
				</button>
				
				<button id="cancelar-frase" class="button" type="button">
					<span class="span-left">::</span>
					<span>Cancelar</span>
					<span class="span-right">::</span>
				</button>
			</div>
		</form>
	</div>
	
	<div class="block-background" id="error-msg-ao-tentar-enviar-frase">
		<span id="your-error-msg-comes-here"></span>
		<div class="form-element">
			<button id="ok-entendo-que-errei" class="button" type="button">
				<span class="span-left">::</span>
				<span>Ok</span>
				<span class="span-right">::</span>
			</button>
		</div>
	</div>
<?php } ?>