	
				<article class="span4 filtro">			
					<div class="tabbable"> <!-- filtro -->
						<ul class="nav nav-tabs">
						  <li <?php if (empty($tip_tab)) {?> class="active" <?php } else { if ($tip_tab=="tour") { ?>  class="active" <?php }}?> >
						  	<a href="#tab1" data-toggle="tab" class="tooltip-test" title="Tour"><span class="icon-tour"></span></a></li>

						  <li <?php if ($tip_tab=="destino") { ?>  class="active" <?php }?>>
						  	<a href="#tab2" data-toggle="tab" class="tooltip-test" title="Destino"><span class="icon-destino"></span></a></li>

						  <li <?php if ($tip_tab=="alojamiento") { ?>  class="active" <?php }?>>
						  	<a href="#tab3" data-toggle="tab" class="tooltip-test" title="Hotel / Alojamiento"><span class="icon-hotel"></span></a>
						  </li>

						  <li <?php if ($tip_tab=="restaurante") { ?>  class="active" <?php }?>>
						  	<a href="#tab4" data-toggle="tab" class="tooltip-test" title="Restaurante"><span class="icon-restaurante"></span></a></li>

						  <li <?php if ($tip_tab=="tienda") { ?>  class="active" <?php }?>>
						  	<a href="#tab5" data-toggle="tab" class="tooltip-test" title="Tienda"><span class="icon-tienda"></span></a></li>
						</ul> <!-- /pestañas del filtro -->

						<div class="tab-content">
							<div <?php if ((empty($tip_tab)) or ($tip_tab=="tour")) {?> class="tab-pane active" <?php } else { ?> class="tab-pane" <?php }?> id="tab1">
								<form method="get" enctype="multipart/form-data" name="tour" action="encuentra_tour.php">
									<fieldset>
										<h2>Encuentra tu Tour</h2>
										<div>
											<div id="opcion">
												<select name="opcion" OnChange="selectOpcion()">
													<option value="Ninguna">Opción de Viaje</option>

													<?php
														//Lista de Opciones de Viaje
														$dato_opcion = "SELECT * FROM opcion";
														$dato_opcion = mysql_db_query($dbname, $dato_opcion); 
														while ($row = mysql_fetch_array($dato_opcion)){ 
															$id_opc = $row["id_opcion"];
															$id_pag_opc = $row["id_pagina"];

															//titulo de la Pagina
															$dato_pag_opcion = "SELECT tit_pos_pagina,id_pagina FROM pagina WHERE id_pagina='$id_pag_opc'";
															$dato_pag_opcion = mysql_db_query($dbname, $dato_pag_opcion); 
															if ($row = mysql_fetch_array($dato_pag_opcion)){ 
																$tit_pag_opcion = $row["tit_pos_pagina"];
																$id_pag_opcion = $row["id_pagina"];
															}

													?>
															<option value="<?=$id_pag_opcion?>"><?=$tit_pag_opcion?></option>
													<?php 
													}
													?>
												</select>
											</div>
										</div>
										<div>
											<p><strong>Destino</strong></p>

											<div id="region">
												<select name="region" OnChange="selectDestino()">
													<option value="Ninguna">Region</option>

													<?php
													//Datos de los detalles del Diseño General
													$des_region = "SELECT * FROM pagina WHERE niv_pagina='2' AND dise_pagina='Destino'  ORDER BY tit_pos_pagina";
													$des_region = mysql_db_query($dbname, $des_region); 
													while ($row = mysql_fetch_array($des_region)){ 

														$id_pag_region = $row["id_pagina"];
														$tit_pag_region = $row["tit_pos_pagina"];

													?>
													<option value="<?=$id_pag_region?>"><?=$tit_pag_region?></option>
													<?php 
													}
													?>
												</select>
											</div>

											<div id="pais">
												<select name="pais" OnChange="selectDestino()">
													<option value="Ninguna">País</option>

													<?php
													//Datos de los detalles del Diseño General
													$des_pais = "SELECT * FROM pagina WHERE niv_pagina='3' AND dise_pagina='Destino'  ORDER BY tit_pos_pagina";
													$des_pais = mysql_db_query($dbname, $des_pais); 
													while ($row = mysql_fetch_array($des_pais)){ 

														$id_pag_pais = $row["id_pagina"];
														$tit_pag_pais = $row["tit_pos_pagina"];

													?>
													<option value="<?=$id_pag_pais?>"><?=$tit_pag_pais?></option>
													<?php 
													}
													?>
												</select>
											</div>

											<div id="ciudad">
												<select name="ciudad" OnChange="selectDestino()">
													<option value="Ninguna">Ciudad</option>

													<?php
													//Datos de los detalles del Diseño General
													$des_ciudad = "SELECT * FROM pagina WHERE niv_pagina='4' AND dise_pagina='Destino'  ORDER BY tit_pos_pagina";
													$des_ciudad = mysql_db_query($dbname, $des_ciudad); 
													while ($row = mysql_fetch_array($des_ciudad)){ 

														$id_pag_ciudad = $row["id_pagina"];
														$tit_pag_ciudad = $row["tit_pos_pagina"];

													?>
													<option value="<?=$id_pag_ciudad?>"><?=$tit_pag_ciudad?></option>
													<?php 
													}
													?>
												</select>
											</div>
											
											<div id="interior">
												<select name="interior" OnChange="selectDestino()">
													<option value="Ninguna">Interior</option>

													<?php
													//Datos de los detalles del Diseño General
													$des_interior = "SELECT * FROM pagina WHERE niv_pagina='5' AND dise_pagina='Destino'  ORDER BY tit_pos_pagina";
													$des_interior = mysql_db_query($dbname, $des_interior); 
													while ($row = mysql_fetch_array($des_interior)){ 

														$id_pag_interior = $row["id_pagina"];
														$tit_pag_interior = $row["tit_pos_pagina"];

													?>
													<option value="<?=$id_pag_interior?>"><?=$tit_pag_interior?></option>
													<?php 
													}
													?>
												</select>
											</div>
										</div>
										<br>
										<div>
											<div id="duracion">
												<select name="duracion" class="input-small" OnChange="selectDuracion()">
													<option value="Ninguna">Duración</option>

													<?php
														$max_duracion = "SELECT MAx(dur_dia_tour) FROM tour";
														$max_duracion = mysql_db_query($dbname, $max_duracion);
														$max_duracion = mysql_result($max_duracion, 0);

														for ($dura=0; $dura <= $max_duracion; $dura+=5) {

															if ($dura==0) {
																$dia=1;
																?>
																<option value="<?=$dia?>"><?=$dia." dia"?></option>
																<?php	
																} else{
																	$dia=$dura;
																?>
																<option value="<?=$dia?>"><?=$min." - ".$dia." dias"?></option>
																<?php
																}
															?>
															<?php
															$min=$dia+1;
														}
														$mod=$max_duracion%5;
														if (($dura > $max_duracion) AND ($mod != 0)) {
															$dia=$max_duracion;
														?>
															<option value="<?=$max_duracion?>"><?=$min." - ".$dia." dias"?></option>
														
														<?php
														}													
													?>

												</select>
											</div>
										</div>
										<br>
										<p><strong>Presupuesto</strong></p>
											<div id="desde" class="inline-block">
												<select name="desde" class="input-small inline-block" OnChange="selectDesde()">
													<option value="Ninguna">Desde</option>

													<?php
														$min_desde = "SELECT MIN(val_tprecio) FROM tprecio";
														$min_desde = mysql_db_query($dbname, $min_desde);
														$min_desde = mysql_result($min_desde, 0);

														$max_desde = "SELECT MAx(val_tprecio) FROM tprecio";
														$max_desde = mysql_db_query($dbname, $max_desde);
														$max_desde = mysql_result($max_desde, 0);

														if ($min_desde!=0) {
															$val_desde=number_format($min_desde,2);
															?>
															<option value="<?=$val_desde?>"><?=$val_desde." USD"?></option>
															<?php
														}

														for ($pre_desde=0; $pre_desde <= $max_desde; $pre_desde+=100) {
															
															if ($pre_desde>$min_desde) {
																$val_desde=number_format($pre_desde,2);
																?>
																<option value="<?=$val_desde?>"><?=$val_desde." USD"?></option>
																<?php
															}
															
														}

														$mod_desde=$max_desde%100;

														if (($pre_desde > $max_desde) AND ($mod_desde != 0)) {
															$val_desde=number_format($max_desde,2);
															?>
															<option value="<?=$val_desde?>"><?=$val_desde." USD"?></option>
														
															<?php
														}													
													?>

												</select>
											</div><strong>- </strong> 
											<div id="hasta" class="inline-block">
												<select name="hasta" class="input-small inline-block" OnChange="selectHasta()">
													<option value="Ninguna">Hasta</option>

													<?php
														$min_hasta = "SELECT MIN(val_tprecio) FROM tprecio";
														$min_hasta = mysql_db_query($dbname, $min_hasta);
														$min_hasta = mysql_result($min_hasta, 0);

														$max_hasta = "SELECT MAx(val_tprecio) FROM tprecio";
														$max_hasta = mysql_db_query($dbname, $max_hasta);
														$max_hasta = mysql_result($max_hasta, 0);

														if ($min_hasta!=0) {
															$val_hasta=number_format($min_hasta,2);
															?>
															<option value="<?=$val_hasta?>"><?=$val_hasta." USD"?></option>
															<?php
														}

														for ($pre_hasta=0; $pre_hasta <= $max_hasta; $pre_hasta+=100) {
															
															if ($pre_hasta>$min_hasta) {
																$val_hasta=number_format($pre_hasta,2);
																?>
																<option value="<?=$val_hasta?>"><?=$val_hasta." USD"?></option>
																<?php
															}

															
														}

														$mod_hasta=$max_hasta%100;
														if (($pre_hasta > $max_hasta) AND ($mod_hasta != 0)) {
															$val_hasta=number_format($max_hasta,2);
														?>
															<option value="<?=$val_hasta?>"><?=$val_hasta." USD"?></option>
														
														<?php
														}													
													?>

												</select>
											</div>				

										<br>
										<br>
										<button type="submit" class="btn btn-filtro btn-large"><div id="tour" class="inline-block">0</div> Tours</button>
									</fieldset>
								</form>
							</div>
							<div <?php if ($tip_tab=="destino") {?> class="tab-pane active" <?php } else { ?> class="tab-pane" <?php }?> id="tab2">
								<form method="get" enctype="multipart/form-data" name="destino" action="encuentra_destino.php">
									<fieldset>
										<h2>Encuentra tu Destino</h2>
										<div>
											<div id="reg_des">
												<select name="region" OnChange="selectDest()">
													<option value="Ninguna">Region</option>

													<?php
													//Datos de los detalles del Diseño General
													$des_region = "SELECT * FROM pagina WHERE niv_pagina='2' AND dise_pagina='Destino'  ORDER BY tit_pos_pagina";
													$des_region = mysql_db_query($dbname, $des_region); 
													while ($row = mysql_fetch_array($des_region)){ 

														$id_pag_region = $row["id_pagina"];
														$tit_pag_region = $row["tit_pos_pagina"];

													?>
													<option value="<?=$id_pag_region?>"><?=$tit_pag_region?></option>
													<?php 
													}
													?>
												</select>
											</div>

											<div id="pai_des">
												<select name="pais" OnChange="selectDest()">
													<option value="Ninguna">País</option>

													<?php
													//Datos de los detalles del Diseño General
													$des_pais = "SELECT * FROM pagina WHERE niv_pagina='3' AND dise_pagina='Destino'  ORDER BY tit_pos_pagina";
													$des_pais = mysql_db_query($dbname, $des_pais); 
													while ($row = mysql_fetch_array($des_pais)){ 

														$id_pag_pais = $row["id_pagina"];
														$tit_pag_pais = $row["tit_pos_pagina"];

													?>
													<option value="<?=$id_pag_pais?>"><?=$tit_pag_pais?></option>
													<?php 
													}
													?>
												</select>
											</div>

											<div id="ciu_des">
												<select name="ciudad" OnChange="selectDest()">
													<option value="Ninguna">Ciudad</option>

													<?php
													//Datos de los detalles del Diseño General
													$des_ciudad = "SELECT * FROM pagina WHERE niv_pagina='4' AND dise_pagina='Destino'  ORDER BY tit_pos_pagina";
													$des_ciudad = mysql_db_query($dbname, $des_ciudad); 
													while ($row = mysql_fetch_array($des_ciudad)){ 

														$id_pag_ciudad = $row["id_pagina"];
														$tit_pag_ciudad = $row["tit_pos_pagina"];

													?>
													<option value="<?=$id_pag_ciudad?>"><?=$tit_pag_ciudad?></option>
													<?php 
													}
													?>
												</select>
											</div>
										</div>

										<br>
										<button type="submit" class="btn btn-filtro btn-large"><div id="total_des" class="inline-block">0</div> Destinos</button>
									</fieldset>
								</form>
							</div>
							<div <?php if ($tip_tab=="alojamiento") {?> class="tab-pane active" <?php } else { ?> class="tab-pane" <?php }?> id="tab3">
								<form method="get" enctype="multipart/form-data" name="alojamiento" action="encuentra_alojamiento.php">
									<fieldset>
										<h2>Encuentra tu Alojamiento</h2>
										<div>
											<p><strong>Destino</strong></p>

											<div id="regaloja">
												<select name="regaloja" OnChange="selectDestAloja()">
													<option value="Ninguna">Region</option>

													<?php
													//Datos de los detalles del Diseño General
													$des_region = "SELECT * FROM pagina WHERE niv_pagina='2' AND dise_pagina='Destino'  ORDER BY tit_pos_pagina";
													$des_region = mysql_db_query($dbname, $des_region); 
													while ($row = mysql_fetch_array($des_region)){ 

														$id_pag_region = $row["id_pagina"];
														$tit_pag_region = $row["tit_pos_pagina"];

													?>
													<option value="<?=$id_pag_region?>"><?=$tit_pag_region?></option>
													<?php 
													}
													?>
												</select>
											</div>

											<div id="paialoja">
												<select name="paialoja" OnChange="selectDestAloja()">
													<option value="Ninguna">País</option>

													<?php
													//Datos de los detalles del Diseño General
													$des_pais = "SELECT * FROM pagina WHERE niv_pagina='3' AND dise_pagina='Destino'  ORDER BY tit_pos_pagina";
													$des_pais = mysql_db_query($dbname, $des_pais); 
													while ($row = mysql_fetch_array($des_pais)){ 

														$id_pag_pais = $row["id_pagina"];
														$tit_pag_pais = $row["tit_pos_pagina"];

													?>
													<option value="<?=$id_pag_pais?>"><?=$tit_pag_pais?></option>
													<?php 
													}
													?>
												</select>
											</div>

											<div id="ciualoja">
												<select name="ciualoja" OnChange="selectDestAloja()">
													<option value="Ninguna">Ciudad</option>

													<?php
													//Datos de los detalles del Diseño General
													$des_ciudad = "SELECT * FROM pagina WHERE niv_pagina='4' AND dise_pagina='Destino'  ORDER BY tit_pos_pagina";
													$des_ciudad = mysql_db_query($dbname, $des_ciudad); 
													while ($row = mysql_fetch_array($des_ciudad)){ 

														$id_pag_ciudad = $row["id_pagina"];
														$tit_pag_ciudad = $row["tit_pos_pagina"];

													?>
													<option value="<?=$id_pag_ciudad?>"><?=$tit_pag_ciudad?></option>
													<?php 
													}
													?>
												</select>
											</div>
											
											<div id="intaloja">
												<select name="intaloja" OnChange="selectDestAloja()">
													<option value="Ninguna">Interior</option>

													<?php
													//Datos de los detalles del Diseño General
													$des_interior = "SELECT * FROM pagina WHERE niv_pagina='5' AND dise_pagina='Destino'  ORDER BY tit_pos_pagina";
													$des_interior = mysql_db_query($dbname, $des_interior); 
													while ($row = mysql_fetch_array($des_interior)){ 

														$id_pag_interior = $row["id_pagina"];
														$tit_pag_interior = $row["tit_pos_pagina"];

													?>
													<option value="<?=$id_pag_interior?>"><?=$tit_pag_interior?></option>
													<?php 
													}
													?>
												</select>
											</div>
										</div>
										<br>
										<div>
											<div id="tipoaloja">
												<select name="tipoaloja" OnChange="selectTipoAloja()">
													<option value="Ninguna">Tipo de Alojamiento</option>

													<?php
													//Datos del Tipo de Alojamiento 
													$des_tip_aloja = "SELECT DISTINCT tipo_alojamiento FROM alojamiento ORDER BY tipo_alojamiento";
													$des_tip_aloja = mysql_db_query($dbname, $des_tip_aloja); 
													while ($row = mysql_fetch_array($des_tip_aloja)){ 

														$tipo_alojamiento = $row["tipo_alojamiento"];

													?>
													<option value="<?=$tipo_alojamiento?>"><?=$tipo_alojamiento?></option>
													<?php 
													}
													?>
												</select>
											</div>
										</div>
										<br>
										<div>
											<div id="catealoja">
												<select name="catealoja" OnChange="selectCateAloja()">
													<option value="Ninguna">Categoria del Alojamiento</option>

													<?php
													//Datos del Tipo de Alojamiento 
													$des_tip_aloja = "SELECT DISTINCT cat_alojamiento FROM alojamiento ORDER BY cat_alojamiento";
													$des_tip_aloja = mysql_db_query($dbname, $des_tip_aloja); 
													while ($row = mysql_fetch_array($des_tip_aloja)){ 

														$cat_alojamiento = $row["cat_alojamiento"];

													?>
													<option value="<?=$cat_alojamiento?>"><?=$cat_alojamiento?> Estrellas</option>
													<?php 
													}
													?>
												</select>
											</div>
										</div>
										<br>
										<div>
											<div id="tiphab">
												<select name="tiphab" OnChange="selectTipHab()">
													<option value="Ninguna">Tipo de Habitacion</option>

													<?php
													//Datos del Tipo de Alojamiento 
													$des_tip_aloja = "SELECT DISTINCT tip_habitacion FROM habitacion ORDER BY tip_habitacion";
													$des_tip_aloja = mysql_db_query($dbname, $des_tip_aloja); 
													while ($row = mysql_fetch_array($des_tip_aloja)){ 

														$tip_habitacion = $row["tip_habitacion"];

													?>
													<option value="<?=$tip_habitacion?>"><?=$tip_habitacion?></option>
													<?php 
													}
													?>
												</select>
											</div>
										</div>
										<br>
										<p><strong>Presupuesto</strong></p>
											<div id="desdehab" class="inline-block">
												<select name="desdehab" class="input-small inline-block" OnChange="selectDesdeHab()">
													<option value="Ninguna">Desde</option>

													<?php
														$min_desde_hab = "SELECT MIN(val_hprecio) FROM hprecio";
														$min_desde_hab = mysql_db_query($dbname, $min_desde_hab);
														$min_desde_hab = mysql_result($min_desde_hab, 0);

														$max_desde_hab = "SELECT MAx(val_hprecio) FROM hprecio";
														$max_desde_hab = mysql_db_query($dbname, $max_desde_hab);
														$max_desde_hab = mysql_result($max_desde_hab, 0);

														if ($min_desde_hab!=0) {
															$val_desde_hab=number_format($min_desde_hab,2);
															?>
															<option value="<?=$val_desde_hab?>"><?=$val_desde_hab." USD"?></option>
															<?php
														}

														for ($pre_desde_hab=0; $pre_desde_hab <= $max_desde_hab; $pre_desde_hab+=20) {
															
															if ($pre_desde_hab>$min_desde_hab) {
																$val_desde_hab=number_format($pre_desde_hab,2);
																?>
																<option value="<?=$val_desde_hab?>"><?=$val_desde_hab." USD"?></option>
																<?php
															}
															
														}

														$mod_desde_hab=$max_desde_hab%20;

														if (($pre_desde_hab > $max_desde_hab) AND ($mod_desde_hab != 0)) {
															$val_desde_hab=number_format($max_desde_hab,2);
															?>
															<option value="<?=$val_desde_hab?>"><?=$val_desde_hab." USD"?></option>
														
															<?php
														}													
													?>

												</select>
											</div><strong>- </strong> 
											<div id="hastahab" class="inline-block">
												<select name="hastahab" class="input-small inline-block" OnChange="selectHastaHab()">
													<option value="Ninguna">Hasta</option>

													<?php
														$min_hasta_hab = "SELECT MIN(val_hprecio) FROM hprecio";
														$min_hasta_hab = mysql_db_query($dbname, $min_hasta_hab);
														$min_hasta_hab = mysql_result($min_hasta_hab, 0);

														$max_hasta_hab = "SELECT MAx(val_hprecio) FROM hprecio";
														$max_hasta_hab = mysql_db_query($dbname, $max_hasta_hab);
														$max_hasta_hab = mysql_result($max_hasta_hab, 0);

														if ($min_hasta_hab!=0) {
															$val_hasta_hab=number_format($min_hasta_hab,2);
															?>
															<option value="<?=$val_hasta_hab?>"><?=$val_hasta_hab." USD"?></option>
															<?php
														}

														for ($pre_hasta_hab=0; $pre_hasta_hab <= $max_hasta_hab; $pre_hasta_hab+=20) {
															
															if ($pre_hasta_hab>$min_hasta_hab) {
																$val_hasta_hab=number_format($pre_hasta_hab,2);
																?>
																<option value="<?=$val_hasta_hab?>"><?=$val_hasta_hab." USD"?></option>
																<?php
															}

															
														}

														$mod_hasta_hab=$max_hasta_hab%20;
														if (($pre_hasta_hab > $max_hasta_hab) AND ($mod_hasta_hab != 0)) {
															$val_hasta_hab=number_format($max_hasta_hab,2);
														?>
															<option value="<?=$val_hasta_hab?>"><?=$val_hasta_hab." USD"?></option>
														
														<?php
														}													
													?>

												</select>
											</div>				

										<br><br>
										<button type="submit" class="btn btn-filtro btn-large"><div id="total_aloja" class="inline-block">0</div> Alojamiento</button>
									</fieldset>
								</form>
							</div>
							<div <?php if ($tip_tab=="restaurante") {?> class="tab-pane active" <?php } else { ?> class="tab-pane" <?php }?> id="tab4">
								<form method="get" enctype="multipart/form-data" name="restaurante" action="encuentra_restaurante.php">
									<fieldset>
										<h2>Encuentra tu Restaurante</h2>
										<div>
											<p><strong>Destino</strong></p>

											<div id="regrest">
												<select name="regrest" OnChange="selectDestRest()">
													<option value="Ninguna">Region</option>

													<?php
													//Datos de los detalles del Diseño General
													$des_region = "SELECT * FROM pagina WHERE niv_pagina='2' AND dise_pagina='Destino'  ORDER BY tit_pos_pagina";
													$des_region = mysql_db_query($dbname, $des_region); 
													while ($row = mysql_fetch_array($des_region)){ 

														$id_pag_region = $row["id_pagina"];
														$tit_pag_region = $row["tit_pos_pagina"];

													?>
													<option value="<?=$id_pag_region?>"><?=$tit_pag_region?></option>
													<?php 
													}
													?>
												</select>
											</div>

											<div id="pairest">
												<select name="pairest" OnChange="selectDestRest()">
													<option value="Ninguna">País</option>

													<?php
													//Datos de los detalles del Diseño General
													$des_pais = "SELECT * FROM pagina WHERE niv_pagina='3' AND dise_pagina='Destino'  ORDER BY tit_pos_pagina";
													$des_pais = mysql_db_query($dbname, $des_pais); 
													while ($row = mysql_fetch_array($des_pais)){ 

														$id_pag_pais = $row["id_pagina"];
														$tit_pag_pais = $row["tit_pos_pagina"];

													?>
													<option value="<?=$id_pag_pais?>"><?=$tit_pag_pais?></option>
													<?php 
													}
													?>
												</select>
											</div>

											<div id="ciurest">
												<select name="ciurest" OnChange="selectDestRest()">
													<option value="Ninguna">Ciudad</option>

													<?php
													//Datos de los detalles del Diseño General
													$des_ciudad = "SELECT * FROM pagina WHERE niv_pagina='4' AND dise_pagina='Destino'  ORDER BY tit_pos_pagina";
													$des_ciudad = mysql_db_query($dbname, $des_ciudad); 
													while ($row = mysql_fetch_array($des_ciudad)){ 

														$id_pag_ciudad = $row["id_pagina"];
														$tit_pag_ciudad = $row["tit_pos_pagina"];

													?>
													<option value="<?=$id_pag_ciudad?>"><?=$tit_pag_ciudad?></option>
													<?php 
													}
													?>
												</select>
											</div>
											
											<div id="intrest">
												<select name="intrest" OnChange="selectDestRest()">
													<option value="Ninguna">Interior</option>

													<?php
													//Datos de los detalles del Diseño General
													$des_interior = "SELECT * FROM pagina WHERE niv_pagina='5' AND dise_pagina='Destino'  ORDER BY tit_pos_pagina";
													$des_interior = mysql_db_query($dbname, $des_interior); 
													while ($row = mysql_fetch_array($des_interior)){ 

														$id_pag_interior = $row["id_pagina"];
														$tit_pag_interior = $row["tit_pos_pagina"];

													?>
													<option value="<?=$id_pag_interior?>"><?=$tit_pag_interior?></option>
													<?php 
													}
													?>
												</select>
											</div>
										</div>
										<br>
										<div>
											<div id="esprest">
												<select name="esprest" OnChange="selectEspRest()">
													<option value="Ninguna">Especialidad</option>

													<?php
													//Datos de los detalles del Diseño General
													$des_especialidad = "SELECT * FROM especialidad ORDER BY nom_especialidad";
													$des_especialidad = mysql_db_query($dbname, $des_especialidad); 
													while ($row = mysql_fetch_array($des_especialidad)){ 

														$id_especialidad = $row["id_especialidad"];
														$nom_especialidad = $row["nom_especialidad"];

													?>
													<option value="<?=$id_especialidad?>"><?=$nom_especialidad?></option>
													<?php 
													}
													?>
												</select>
											</div>
										</div>
										<br>
										<div>
											<div id="tiprest">
												<select name="tiprest" OnChange="selectTipRest()">
													<option value="Ninguna">Tipo</option>

													<?php
													//Datos de los detalles del Diseño General
													$des_region = "SELECT * FROM tipo ORDER BY nom_tipo";
													$des_region = mysql_db_query($dbname, $des_region); 
													while ($row = mysql_fetch_array($des_region)){ 

														$id_tipo = $row["id_tipo"];
														$nom_tipo = $row["nom_tipo"];

													?>
													<option value="<?=$id_tipo?>"><?=$nom_tipo?></option>
													<?php 
													}
													?>
												</select>
											</div>
										</div>
										<br>
										<div>
											<div id="ocarest">
												<select name="ocarest" OnChange="selectOcaRest()">
													<option value="Ninguna">Ocasión</option>

													<?php
													//Datos de los detalles del Diseño General
													$des_rocasion = "SELECT * FROM rocasion ORDER BY nom_rocasion";
													$des_rocasion = mysql_db_query($dbname, $des_rocasion); 
													while ($row = mysql_fetch_array($des_rocasion)){ 

														$id_rocasion = $row["id_rocasion"];
														$nom_rocasion = $row["nom_rocasion"];

													?>
													<option value="<?=$id_rocasion?>"><?=$nom_rocasion?></option>
													<?php 
													}
													?>
												</select>
											</div>
										</div>
										<br><br>
										<p><strong>Presupuesto</strong></p>
											<div id="desdepla" class="inline-block">
												<select name="desdepla" class="input-small inline-block" OnChange="selectDesdeRest()">
													<option value="Ninguna">Desde</option>

													<?php
														$min_desde_pla = "SELECT MIN(val_pprecio) FROM pprecio";
														$min_desde_pla = mysql_db_query($dbname, $min_desde_pla);
														$min_desde_pla = mysql_result($min_desde_pla, 0);

														$max_desde_pla = "SELECT MAx(val_pprecio) FROM pprecio";
														$max_desde_pla = mysql_db_query($dbname, $max_desde_pla);
														$max_desde_pla = mysql_result($max_desde_pla, 0);

														if ($min_desde_pla!=0) {
															$val_desde_pla=number_format($min_desde_pla,2);
															?>
															<option value="<?=$val_desde_pla?>"><?=$val_desde_pla." USD"?></option>
															<?php
														}

														for ($pre_desde_pla=0; $pre_desde_pla <= $max_desde_pla; $pre_desde_pla+=20) {
															
															if ($pre_desde_pla>$min_desde_pla) {
																$val_desde_pla=number_format($pre_desde_pla,2);
																?>
																<option value="<?=$val_desde_pla?>"><?=$val_desde_pla." USD"?></option>
																<?php
															}
															
														}

														$mod_desde_pla=$max_desde_pla%20;

														if (($pre_desde_pla > $max_desde_pla) AND ($mod_desde_pla != 0)) {
															$val_desde_pla=number_format($max_desde_pla,2);
															?>
															<option value="<?=$val_desde_pla?>"><?=$val_desde_pla." USD"?></option>
														
															<?php
														}													
													?>
												</select>
											</div><strong>- </strong> 
											<div id="hastapla" class="inline-block">
												<select name="hastapla" class="input-small inline-block" OnChange="selectHastaRest()">
													<option value="Ninguna">Hasta</option>

													<?php
														$min_hasta_pla = "SELECT MIN(val_pprecio) FROM pprecio";
														$min_hasta_pla = mysql_db_query($dbname, $min_hasta_pla);
														$min_hasta_pla = mysql_result($min_hasta_pla, 0);

														$max_hasta_pla = "SELECT MAx(val_pprecio) FROM pprecio";
														$max_hasta_pla = mysql_db_query($dbname, $max_hasta_pla);
														$max_hasta_pla = mysql_result($max_hasta_pla, 0);

														if ($min_hasta_pla!=0) {
															$val_hasta_pla=number_format($min_hasta_pla,2);
															?>
															<option value="<?=$val_hasta_pla?>"><?=$val_hasta_pla." USD"?></option>
															<?php
														}

														for ($pre_hasta_pla=0; $pre_hasta_pla <= $max_hasta_pla; $pre_hasta_pla+=20) {
															
															if ($pre_hasta_pla>$min_hasta_pla) {
																$val_hasta_pla=number_format($pre_hasta_pla,2);
																?>
																<option value="<?=$val_hasta_pla?>"><?=$val_hasta_pla." USD"?></option>
																<?php
															}

															
														}

														$mod_hasta_pla=$max_hasta_pla%20;
														if (($pre_hasta_pla > $max_hasta_pla) AND ($mod_hasta_pla != 0)) {
															$val_hasta_pla=number_format($max_hasta_pla,2);
														?>
															<option value="<?=$val_hasta_pla?>"><?=$val_hasta_pla." USD"?></option>
														
														<?php
														}													
													?>
												</select>
											</div>				

										<br><br>
										<button type="submit" class="btn btn-filtro btn-large"><div id="total_rest" class="inline-block">0</div> Restaurante</button>
										
									</fieldset>
								</form>
							</div>
							<div <?php if ($tip_tab=="tienda") {?> class="tab-pane active" <?php } else { ?> class="tab-pane" <?php }?> id="tab5">
								<form method="get" enctype="multipart/form-data" name="tienda" action="encuentra_tienda.php">
									<fieldset>
										<h2>Encuentra tu Tienda</h2>
										<div>
											<p><strong>Destino</strong></p>

											<div id="regtien">
												<select name="regtien" OnChange="selectDestTien()">
													<option value="Ninguna">Region</option>

													<?php
													//Datos de los detalles del Diseño General
													$des_region = "SELECT * FROM pagina WHERE niv_pagina='2' AND dise_pagina='Destino'  ORDER BY tit_pos_pagina";
													$des_region = mysql_db_query($dbname, $des_region); 
													while ($row = mysql_fetch_array($des_region)){ 

														$id_pag_region = $row["id_pagina"];
														$tit_pag_region = $row["tit_pos_pagina"];

													?>
													<option value="<?=$id_pag_region?>"><?=$tit_pag_region?></option>
													<?php 
													}
													?>
												</select>
											</div>

											<div id="paitien">
												<select name="paitien" OnChange="selectDestTien()">
													<option value="Ninguna">País</option>

													<?php
													//Datos de los detalles del Diseño General
													$des_pais = "SELECT * FROM pagina WHERE niv_pagina='3' AND dise_pagina='Destino'  ORDER BY tit_pos_pagina";
													$des_pais = mysql_db_query($dbname, $des_pais); 
													while ($row = mysql_fetch_array($des_pais)){ 

														$id_pag_pais = $row["id_pagina"];
														$tit_pag_pais = $row["tit_pos_pagina"];

													?>
													<option value="<?=$id_pag_pais?>"><?=$tit_pag_pais?></option>
													<?php 
													}
													?>
												</select>
											</div>

											<div id="ciutien">
												<select name="ciutien" OnChange="selectDestTien()">
													<option value="Ninguna">Ciudad</option>

													<?php
													//Datos de los detalles del Diseño General
													$des_ciudad = "SELECT * FROM pagina WHERE niv_pagina='4' AND dise_pagina='Destino'  ORDER BY tit_pos_pagina";
													$des_ciudad = mysql_db_query($dbname, $des_ciudad); 
													while ($row = mysql_fetch_array($des_ciudad)){ 

														$id_pag_ciudad = $row["id_pagina"];
														$tit_pag_ciudad = $row["tit_pos_pagina"];

													?>
													<option value="<?=$id_pag_ciudad?>"><?=$tit_pag_ciudad?></option>
													<?php 
													}
													?>
												</select>
											</div>
											
											<div id="inttien">
												<select name="inttien" OnChange="selectDestTien()">
													<option value="Ninguna">Interior</option>

													<?php
													//Datos de los detalles del Diseño General
													$des_interior = "SELECT * FROM pagina WHERE niv_pagina='5' AND dise_pagina='Destino'  ORDER BY tit_pos_pagina";
													$des_interior = mysql_db_query($dbname, $des_interior); 
													while ($row = mysql_fetch_array($des_interior)){ 

														$id_pag_interior = $row["id_pagina"];
														$tit_pag_interior = $row["tit_pos_pagina"];

													?>
													<option value="<?=$id_pag_interior?>"><?=$tit_pag_interior?></option>
													<?php 
													}
													?>
												</select>
											</div>
										</div>
										<br>
										<div>
											<div id="cattien">
												<select name="cattien" OnChange="selectCatTien()">
													<option value="Ninguna">Categoria</option>

													<?php
													//Datos de los detalles del Diseño General
													$des_categoria = "SELECT * FROM categoria";
													$des_categoria = mysql_db_query($dbname, $des_categoria); 
													while ($row = mysql_fetch_array($des_categoria)){ 

														$id_categoria = $row["id_categoria"];
														$nom_categoria = $row["nom_categoria"];

													?>
													<option value="<?=$id_categoria?>"><?=$nom_categoria?></option>
													<?php 
													}
													?>
												</select>
											</div>
										</div>
										<br>
										<p><strong>Presupuesto</strong></p>
											<div id="desdetien" class="inline-block">
												<select name="desdetien" class="input-small inline-block" OnChange="selectDesdeTien()">
													<option value="Ninguna">Desde</option>

													<?php
														$min_desde_art = "SELECT MIN(val_aprecio) FROM aprecio";
														$min_desde_art = mysql_db_query($dbname, $min_desde_art);
														$min_desde_art = mysql_result($min_desde_art, 0);

														$max_desde_art = "SELECT MAx(val_aprecio) FROM aprecio";
														$max_desde_art = mysql_db_query($dbname, $max_desde_art);
														$max_desde_art = mysql_result($max_desde_art, 0);

														if ($min_desde_art!=0) {
															$val_desde_art=number_format($min_desde_art,2);
															?>
															<option value="<?=$val_desde_art?>"><?=$val_desde_art." USD"?></option>
															<?php
														}

														for ($pre_desde_art=0; $pre_desde_art <= $max_desde_art; $pre_desde_art+=20) {
															
															if ($pre_desde_art>$min_desde_art) {
																$val_desde_art=number_format($pre_desde_art,2);
																?>
																<option value="<?=$val_desde_art?>"><?=$val_desde_art." USD"?></option>
																<?php
															}
															
														}

														$mod_desde_art=$max_desde_art%20;

														if (($pre_desde_art > $max_desde_art) AND ($mod_desde_art != 0)) {
															$val_desde_art=number_format($max_desde_art,2);
															?>
															<option value="<?=$val_desde_art?>"><?=$val_desde_art." USD"?></option>
														
															<?php
														}													
													?>
												</select>
											</div><strong>- </strong> 
											<div id="hastatien" class="inline-block">
												<select name="hastatien" class="input-small inline-block" OnChange="selectHastaTien()">
													<option value="Ninguna">Hasta</option>

													<?php
														$min_hasta_art = "SELECT MIN(val_aprecio) FROM aprecio";
														$min_hasta_art = mysql_db_query($dbname, $min_hasta_art);
														$min_hasta_art = mysql_result($min_hasta_art, 0);

														$max_hasta_art = "SELECT MAx(val_aprecio) FROM aprecio";
														$max_hasta_art = mysql_db_query($dbname, $max_hasta_art);
														$max_hasta_art = mysql_result($max_hasta_art, 0);

														if ($min_hasta_art!=0) {
															$val_hasta_art=number_format($min_hasta_art,2);
															?>
															<option value="<?=$val_hasta_art?>"><?=$val_hasta_art." USD"?></option>
															<?php
														}

														for ($pre_hasta_art=0; $pre_hasta_art <= $max_hasta_art; $pre_hasta_art+=20) {
															
															if ($pre_hasta_art>$min_hasta_art) {
																$val_hasta_art=number_format($pre_hasta_art,2);
																?>
																<option value="<?=$val_hasta_art?>"><?=$val_hasta_art." USD"?></option>
																<?php
															}

															
														}

														$mod_hasta_art=$max_hasta_art%20;
														if (($pre_hasta_art > $max_hasta_art) AND ($mod_hasta_art != 0)) {
															$val_hasta_art=number_format($max_hasta_art,2);
														?>
															<option value="<?=$val_hasta_art?>"><?=$val_hasta_art." USD"?></option>
														
														<?php
														}													
													?>
												</select>
											</div>				

										<br><br>
										<button type="submit" class="btn btn-filtro btn-large"><div id="total_tien" class="inline-block">0</div> Tienda</button>
									</fieldset>
								</form>
							</div>
						</div> <!-- /contenido de las pestañas -->
					</div>				
				</article>