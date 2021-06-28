<style>
    section .content1{
        margin-top: -150px;
        margin-bottom: -170px;
	

	
    }


	p{
		color: #d70000;
		margin-left: 20px;

	}

</style>

<?php

include_once('../conexao.php');

?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta charset="utf-8">
		<title>post1</title>
	</head>
	<body>

	<?php

		$numero_cpf_cnpj = $_POST['numero_cpf_cnpj'];

		 //tratamento para numero_cpf_cnpj
		 $ncc = str_replace("/", "", $numero_cpf_cnpj);
		 $ncc2 = str_replace(".", "", $ncc);
		 $ncc3 = str_replace("-", "", $ncc2);

		//trazendo id_unidade_consumidora de unidade_consumidora que esta relacionado com o cpf/cnpj, semelhante ao INNER JOIN
		$query_u = "SELECT * from unidade_consumidora where numero_cpf_cnpj = '$ncc3' ";
		$result_u = mysqli_query($conexao, $query_u);
		$row_u = mysqli_fetch_array($result_u);
		$id_unidade_consumidora = $row_u['id_unidade_consumidora'];

	?>

	<?php

		if($numero_cpf_cnpj == null){
			echo "<h3>&nbsp;&nbsp;&nbsp;Preencha pelomenos o campo de CPF/CNPJ!!!</h3>";
			echo "<br/>";
			exit();
		}

	?>



	<?php

		$sql = "SELECT * FROM unidade_consumidora WHERE numero_cpf_cnpj = '$ncc3' ";
		$query = mysqli_query($conexao, $sql);
		$row = mysqli_num_rows($query);
	?>
<section>
    	<?php
		if($row > 0){
		?>

	  <div class="content1">
		<div class="row mr-3">
		  <div class="col-md-12">
			<div class="card">
			  <div class="card-header">
			   
			  </div>
			  <div class="card-body">
				<div class="table-responsive">
				<table class="table table-striped">
					<thead class="text-secondary">
										
						<th >
							UC
						</th>
						<th >
							Nome/Razão Social
						</th>
						<th>
							CPF/CNPJ
						</th>
						<th>
							Data Cad
						</th>
				
				
											
										
						<th>
							Ações
						</th>
						</thead>
						<tbody>
				
				<?php 
					while($sqlline = mysqli_fetch_array($query)){

						$uc = $sqlline["id_unidade_consumidora"];
						$localidade = $sqlline["id_localidade"];
						$cpfcnpj = $sqlline["numero_cpf_cnpj"];
						$nome_user = $sqlline['nome_razao_social'];
						$nome_rg = $sqlline['numero_rg'];
						$nome_om = $sqlline['orgao_emissor_rg'];
						$nome_ufrg = $sqlline['uf_rg'];
						$nome_tf = $sqlline['fone_fixo'];
						$nome_tfm = $sqlline['fone_movel'];
						$nome_tfz = $sqlline['fone_zap'];
						$nome_email = $sqlline['email'];
						$data = $sqlline['data_cadastro'];

						//trabalhando a data
						$data2 = implode('/', array_reverse(explode('-', $data)));



						?>

						<tr>

						<td><?php echo $uc; ?></td>

													
						<td><?php echo $nome_user; ?></td>
						<td><?php echo $cpfcnpj; ?></td>
														
						<td><?php echo $data2; ?></td>
																				
														
						<td>
						<!--chamando modal para envio de mensagem-->
						<a class="text-primary" title="Ver Perfil"href="admin.php?acao=requerimento&func=perfil&id=<?php echo $uc; ?>" ><i class="fas fa-id-card"></i></a>

						<a class="text-secondary" title="Criar Requerimento" href="admin.php?acao=requerimento&func=criar&id=<?php echo $uc; ?>" ><i class="fas fa-plus-square"></i></a>
						</td>
						</tr>

													
						<?php }?>
						</tbody>
						</table>				
									
				
		</div>
		<?php }else{?>
			
		<p class="danger">Não foram encontrados registros com esses parametros!</p>

		<?php }?>
		</div>
          </div>
        </div>
	  </div>
	  </div>
	</section>
		
	</body>
</html>