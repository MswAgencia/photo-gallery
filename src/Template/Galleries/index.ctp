<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Galerias Cadastradas <?= $this->Html->link('Cadastrar', '/interno/galeria-de-fotos/galerias/novo', ['class' => 'btn btn-primary btn-lg']) ?></h1>
		<?php
			echo $this->Flash->render();

			echo $this->Html->tag('table', null, ['class' => 'table stripped table-bordered realties-table']);
			
			echo $this->Html->tag('thead', $this->Html->tableHeaders($tableHeaders));
			$cells = [];

			foreach($data as $gallery){
				$cell = [];
				$cell[] = 'Sem Imagem';
				$cell[] = $gallery->name;
				$cell[] = $gallery->getStatusAsString();
				$options = [];
                $options[] = $this->Html->link('Gerenciar Fotos', "/interno/galeria-de-fotos/galerias/{$gallery->id}/fotos/", ['class' => 'btn btn-primary btn-sm']);
                if(\Cake\Core\Plugin::loaded('VideoManager'))
                    $options[] = $this->Html->link('Gerenciar Vídeos', "/interno/galeria-de-fotos/{$gallery->id}/videos/", ['class' => 'btn btn-primary btn-sm']);
				$options[] = $this->Html->link('Editar', '/interno/galeria-de-fotos/galerias/editar/' . $gallery->id, ['class' => 'btn btn-primary btn-sm']);
				$options[] = $this->Html->link('Excluir', '/interno/galeria-de-fotos/galerias/remover/' . $gallery->id, ['class' => 'btn btn-danger btn-sm','confirm' => 'Tem certeza que deseja excluir a galeria?']);

				$cell[] = implode(' ', $options);
				$cells[] = $cell;
			}

			if(!empty($cells))
				echo $this->Html->tableCells($cells);
			else
				echo $this->Flash->render('notice');

			echo $this->Html->tag('/table');
		?>
	</div>
</div>