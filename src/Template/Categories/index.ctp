<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Categorias Cadastradas <?= $this->Html->link('Cadastrar', '/interno/galeria-de-fotos/categorias/novo', ['class' => 'btn btn-primary btn-lg']) ?></h1>
		<?php
			echo $this->Flash->render();

			echo $this->Html->tag('table', null, ['class' => 'table stripped table-bordered realties-table']);

			echo $this->Html->tag('thead', $this->Html->tableHeaders($tableHeaders));
			$cells = [];
			foreach($data as $category){
				$options = [];
				$options[] = $this->Html->link('Editar', '/interno/galeria-de-fotos/categorias/editar/' . $category->id, ['class' => 'btn btn-primary btn-sm']);
				$options[] = $this->Html->link('Excluir', '/interno/galeria-de-fotos/categorias/remover/' . $category->id, ['class' => 'btn btn-danger btn-sm', 'confirm' => 'Tem certeza que deseja excluir a categoria?']);

				$cells[] = [$category->name, $category->getStatusAsString(), implode(' ', $options)];
			}

			if(!empty($cells))
				echo $this->Html->tableCells($cells);
			else
				echo $this->Flash->render('notice');

			echo $this->Html->tag('/table');
		?>
	</div>
</div>