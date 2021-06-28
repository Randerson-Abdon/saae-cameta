<?php include_once("../conexao.php");

	$id_categoria = $_REQUEST['id_logradouro'];

	$query_u = "SELECT * from logradouro where id_logradouro = '$id_categoria' ";
      $result_u = mysqli_query($conexao, $query_u);
      $row_u = mysqli_fetch_array($result_u);
      $id_tipo_logradouro = $row_u['id_tipo_logradouro'];
	
	$result_sub_cat = "SELECT * FROM tipo_logradouro WHERE id_tipo_logradouro=$id_tipo_logradouro ORDER BY abreviatura_tipo_logradouro";
	$resultado_sub_cat = mysqli_query($conn, $result_sub_cat);
	
	while ($row_sub_cat = mysqli_fetch_assoc($resultado_sub_cat) ) {
		$sub_categorias_post[] = array(
			'id_tipo_logradouro'	=> $row_sub_cat['id_tipo_logradouro'],
			'abreviatura_tipo_logradouro' => utf8_encode($row_sub_cat['abreviatura_tipo_logradouro']),
		);
	}
	
	echo(json_encode($sub_categorias_post));
