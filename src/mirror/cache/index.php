<?php if(!class_exists('raintpl')){exit;}?><section id="news-section">
	<div id="slider" class="floating black-marinho">
		<div class="controller"></div>
		<div class="slide">
			<img style="width: 100%; margin-top: 30px" src="/arquivo/slides/manifestacao-em-dublin.jpg" />
			<span style="left: 50px; bottom: 10px;" class="description">Manifestação em Dublin em prol do Brasil</span>
			<div class="news-content">
				<a class="youtube" title="Ver vídeo no youtube" href="http://www.youtube.com/watch?v=fYhofDNiYjQ" target="_blank"></a>
				<a class="gazeta-do-povo" title="Ver essa notícia na Gazeta do Povo" href="http://www.gazetadopovo.com.br/mundo/conteudo.phtml?tl=1&id=1382482&tit=Milhares-vao-as-ruas-de-Dublin-em-solidariedade-a-manifestacoes-no-Brasil" target="_blank"></a>
			</div>
		</div>
		
		<div class="slide">
			<img style="height: 100%;" src="/arquivo/slides/sorocaba-vai-parar.jpg" />
		</div>
		
		<div class="slide">
			<img style="width: 100%; margin-top: 50px" src="/arquivo/slides/dilma-vaiada.jpg" />
			<span style="bottom: 45px; right: 10px;" class="description">Presidenta Dilma é vaiada na Copa das Confederações</span>
			<div class="news-content">
				<a class="youtube" title="Ver essa vídeo no Youtube" href="http://www.youtube.com/watch?v=zDb5hjQraAs" target="_blank"></a>
			</div>
		</div>
		
		<div class="slide">
			<img style="width: 100%" src="/arquivo/slides/povo-sendo-vandalizado.jpg" />
			<span style="bottom: 45px; right: 10px;" class="description">Povo sendo vandalizado pelo governo</span>
		</div>
		
		<div class="slide">
			<img style="width: 100%; margin-top: 25px;" src="/arquivo/slides/rio-vai-parar.jpg" />
		</div>
		
		<div class="slide">
			<img style="width: 100%" src="/arquivo/slides/protesto-em-porto-alegre.jpg" />
			<span style="bottom: 10px; left: 25px;" class="description">Revolta contra aumento da passagem gera grande protesto em Porto Alegre</span>
			<div class="news-content">
				<a class="sul21" title="Ver essa notícia no Sul21" href="http://www.sul21.com.br/jornal/2013/03olta-contra-aumento-da-passagem-gera-grande-protesto-na-noite-de-porto-alegre/" target="_blank"></a>
			</div>
		</div>
		
		<div class="slide">
			<img style="width: 100%; margin-top: 30px;" src="/arquivo/slides/plenario-camara-votacao-salarios.jpg" />
			<span style="width: 570px; left: 6px; bottom: 10px;" class="description">Reportágem da Veja de 2010: O salário dos políticos parece alto. É muito maior</span>
			<div class="news-content">
				<a class="veja" title="Ver essa notícia na Veja" href="http://veja.abril.com.br/noticia/brasil/o-salario-dos-politicos-parece-alto-e-muito-maior" target="_blank"></a>
			</div>
		</div>
	</div>
</section>
<aside id="sidebar" class="floating black-marinho">
	<span class="destaques">FRASES EM DESTAQUE</span>
	<ul>
		<?php $counter1=-1; if( isset($this->var['frases']) && is_array($this->var['frases']) && sizeof($this->var['frases']) ) foreach( $this->var['frases'] as $key1 => $value1 ){ $counter1++; ?>
			<li>
				<article>
					<span class="author"><?php echo $value1["txtapelido"];?>: </span>
					<span class="phrase"><?php echo $value1["txtcomentario"];?></span><br />
					<span class="datetime"><?php echo $value1["dtcadastro"];?></span>
				</article>
			</li>
		<?php } ?>
	</ul>
</aside>