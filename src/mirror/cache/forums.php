<?php if(!class_exists('raintpl')){exit;}?><!-- <div class="forum">
		<h2>Importante</h2>
		<h3>Você não pode criar tópicos nessa área, essa área terá link dos tópicos mais discutidos.</h3>
		<ul>
		</ul>
	</div> -->
<?php $counter1=-1; if( isset($this->var['forums']) && is_array($this->var['forums']) && sizeof($this->var['forums']) ) foreach( $this->var['forums'] as $key1 => $value1 ){ $counter1++; ?>
	<div class="forum floating black-marinho">
		<h2><?php echo $value1["txtforum"];?></h2>
		<h3><?php echo $value1["txtdescricao"];?></h3>
		<ul>
			<?php $counter2=-1; if( isset($value1["topicos"]) && is_array($value1["topicos"]) && sizeof($value1["topicos"]) ) foreach( $value1["topicos"] as $key2 => $value2 ){ $counter2++; ?>
				<li>
					<article class="topico" data-idtopico="<?php echo $value2["idtopico"];?>">
						<div class="title">
							<?php echo $value2["txttopico"];?>
						</div>
						
						<div class="autor">
							criado por <?php echo $value2["txtapelido"];?><br />
							<?php echo date('d/m/Y H:i', $value2["dtcadastro"]); ?>
						</div>
					</article>
				</li>
			<?php } ?>
		</ul>
	</div>
<?php } ?>