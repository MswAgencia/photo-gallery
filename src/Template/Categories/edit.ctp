<div class="row">
	<div class="col-lg-8">
		<h1 class="page-header">Editando Categoria <?= $category->name ?></h1>
		<?php
			echo $this->Flash->render();

			echo $this->Form->create($category, ['type' => 'file']);

			echo $this->Html->tag('legend', 'Informações Básicas');

			if($options['use_order_field'])
				echo $this->Form->input('sort_order', ['label' => 'Ordem', 'type' => 'number']);

			echo $this->Form->input('name', ['label' => 'Nome']);

			if($options['use_image']) {
				echo '<div class="form-group">';
				echo $this->Form->label('Imagem');
				echo $this->Form->file('image');
				echo '</div>';
			}
			
			echo $this->Form->checkbox('status', ['label' => 'Ativar']);

			echo $this->Form->submit('Editar', ['class' => 'btn btn-primary']);
			echo $this->Form->end();
		?>
	</div>
</div>

