<style>
    section .content{
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
		<title>post4</title>
	</head>
	<body>

	<?php

		$enderecamento = $_POST['enderecamento'] . '%';

		//trazendo dados de bairro que esta relacionado com o nome , semelhante ao INNER JOIN
		$query_b = "SELECT * from bairro where nome_bairro LIKE '%$enderecamento%' ";
		$result_b = mysqli_query($conexao, $query_b);
		$row_b = mysqli_fetch_array($result_b);
		$id_bairro = $row_b["id_bairro"];	

		//trazendo dados de logradouro que esta relacionado com o nome, semelhante ao INNER JOIN
		$query_l = "SELECT * from logradouro where nome_logradouro LIKE '%$enderecamento%' ";
		$result_l = mysqli_query($conexao, $query_l);
		$row_l = mysqli_fetch_array($result_l);
		$id_logradouro = $row_l["id_logradouro"];	



	?>

	<?php

		$sql = "SELECT * FROM endereco_instalacao WHERE id_bairro LIKE '$id_bairro' OR id_logradouro LIKE '$id_logradouro' ";
		$query = mysqli_query($conexao, $sql);
		$row = mysqli_num_rows($query);
	?>
<section>
    	<?php
		if($row > 0){
		?>

	  <div class="content">
		<div class="row mr-3">
		  <div class="col-md-12">
			<div class="card">
			  <div class="card-body">
				<div class="table-responsive">
				<table class="table table-striped">
					<thead class="text-secondary">
										
						<th>
							UC
						</th>
						<th >
							Nome/Razão Social
						</th>
						<th>
							CPF/CNPJ
						</th>
						<th>
							Bairro
						</th>
						<th>
							Logradouro
						</th>
					
				
				
											
										
						<th>
							Ações
						</th>
						</thead>
						<tbody>
				
				<?php 
					while($sqlline = mysqli_fetch_array($query)){

						$bairro_id = $sqlline["id_bairro"];
						$logradouro_id = $sqlline["id_logradouro"];

						$uc = $sqlline["id_unidade_consumidora"];
						//trazendo dados de unidade_consumidora que esta relacionado com o id, semelhante ao INNER JOIN
						$query_u = "SELECT * from unidade_consumidora where id_unidade_consumidora = '$uc' ";
						$result_u = mysqli_query($conexao, $query_u);
						$row_u = mysqli_fetch_array($result_u);
						$cpfcnpj = $row_u["numero_cpf_cnpj"];
						$nome_user = $row_u['nome_razao_social'];
						$nome_rg = $row_u['numero_rg'];
						$nome_om = $row_u['orgao_emissor_rg'];
						$nome_ufrg = $row_u['uf_rg'];
						$nome_tf = $row_u['fone_fixo'];
						$nome_tfm = $row_u['fone_movel'];
						$nome_tfz = $row_u['fone_zap'];
						$nome_email = $row_u['email'];
						$data = $row_u['data_cadastro'];

						//trabalhando a data
						$data2 = implode('/', array_reverse(explode('-', $data)));

						//trazendo nome de bairro que esta relacionado com o id , semelhante ao INNER JOIN
						$query_b2 = "SELECT * from bairro where id_bairro = '$bairro_id' ";
						$result_b2 = mysqli_query($conexao, $query_b2);
						$row_b2 = mysqli_fetch_array($result_b2);
						$nome_bairro = $row_b2["nome_bairro"];	

						//trazendo nome de logradouro que esta relacionado com o id, semelhante ao INNER JOIN
						$query_l2 = "SELECT * from logradouro where id_logradouro = '$logradouro_id' ";
						$result_l2 = mysqli_query($conexao, $query_l2);
						$row_l2 = mysqli_fetch_array($result_l2);
						$nome_logradouro = $row_l2["nome_logradouro"];							



						?>

						<tr>

						<td><?php echo $uc; ?></td>

													
						<td><?php echo $nome_user; ?></td>
						<td><?php echo $cpfcnpj; ?></td>
						<td><?php echo $nome_bairro; ?></td>
						<td><?php echo $nome_logradouro; ?></td>								
					
																				
														
						<td>
						<!--chamando modal para envio de mensagem-->
						<a class="text-primary" title="Ver Perfil"href="admin.php?acao=requerimento&func=perfil&id=<?php echo $uc; ?>" ><i class="fas fa-id-card"></i></a>

						<a class="text-secondary" title="Criar Requerimento" href="admin.php?acao=requerimento&func=criar&id=<?php echo $uc; ?>" ><i class="fas fa-plus-square"></i></a>
						</td>
						</tr>
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