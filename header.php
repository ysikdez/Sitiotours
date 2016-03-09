
		<header>		
			<nav>
				<div class="navbar-wrapper">
					<div class="container">
						<div class="navbar navbar-inverse">
							<div class="navbar-inner">
								<!-- boton del Navegador Responsive -->
								<button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
									<span class="icon-bar"></span>
									<span class="icon-bar"></span>
									<span class="icon-bar"></span>
									<span class="icon-bar"></span>
								</button>
								<a class="brand" href="/">
									<div itemscope itemtype="http://schema.org/ImageObject">
										<figure>
											<img src="/img/sitio-logo.png" itemprop="contentURL" alt="Logo Sitiotours.com" width="100" height="58">
										</figure>
										<meta itemprop="datePublished" content="2014-07-06">
										<figcaption itemprop="name" class="text-center">sitiotours.com</figcaption>
									</div>
								</a>
								<!-- Menu que se comprime -->
								<div class="nav-collapse collapse">
									<ul class="nav">
									<?php

									//menu
									$dato_pag_menu = "SELECT * FROM pagina WHERE niv_pagina='1' ORDER BY ord_pagina";
									$dato_pag_menu = mysql_db_query($dbname, $dato_pag_menu); 
									while ($row = mysql_fetch_array($dato_pag_menu)){ 

										$ord_menu = $row["ord_pagina"];
										$url_menu = $row["url_pagina"];
										$ico_menu = $row["ico_pagina"];
										$tit_menu = $row["tit_pos_pagina"];

										switch ($ord_menu) {
											case ($ord_menu <= 2):
												?>
												<li><a itemprop="url" href="/<?=$url_menu?>"><?=$tit_menu?></a></li>
												<?php

												break;
											case ($ord_menu == 3):
												?>
												<li class="dropdown active">
													<a href="#" class="dropdown-toggle" data-toggle="dropdown">
														Que Buscas<b class="caret"></b>
													</a>
													<ul class="dropdown-menu">
													<li><a itemprop="url" href="/<?=$url_menu?>"><span class="<?=$ico_menu?> ico-nav"></span><?=$tit_menu?></a></li>
												<?php

												break;
											case ($ord_menu == 15):
												?>
													<li class="divider"></li>
													<li class="nav-header">Más</li>
													<li><a itemprop="url" href="/<?=$url_menu?>"><span class="<?=$ico_menu?> ico-nav"></span><?=$tit_menu?></a></li>
												<?php

												break;


											default:
												?>
													<li><a itemprop="url" href="/<?=$url_menu?>"><span class="<?=$ico_menu?> ico-nav"></span><?=$tit_menu?></a></li>
												<?php
												break;
										}

									?>

										

									<?php
									}
									?>		</ul>
										</li>				
									</ul>

									<form class="navbar-search pull-right" method="get" enctype="multipart/form-data" name="buscar" action="buscar.php">
										<input name="buscar" type="text" class="search-query" placeholder="Buscar">
									</form>
								</div><!--/.nav-collapse -->
							</div><!-- /.navbar-inner -->
						</div>
					</div><!-- /contenedor del menu de navegacion -->
				</div>
			</nav>

			<div id="myCarousel" class="carousel slide apagado-mini">
				<div class="carousel-inner">				
			<?php

				//Imagen Principal
				//id del index predefinido es 0
				$dato_coleccion = "SELECT id_letrero_ima_prin FROM coleccion WHERE id_pagina='0'";
				$dato_coleccion = mysql_db_query($dbname, $dato_coleccion); 
				if ($row = mysql_fetch_array($dato_coleccion)){ $id_letrero_ima_prin = $row["id_letrero_ima_prin"]; }

				if (empty($id_letrero_ima_prin)) { $id_letrero_ima_prin =1; }

				$dato_nom_letrero = "SELECT tip_letrero_ima_prin FROM letrero_ima_prin WHERE id_letrero_ima_prin='$id_letrero_ima_prin'";
				$dato_nom_letrero = mysql_db_query($dbname, $dato_nom_letrero); 
				if ($row = mysql_fetch_array($dato_nom_letrero)){ $tip_letrero_ima_prin = $row["tip_letrero_ima_prin"]; }

				$dato_letrero_ima = "SELECT * FROM
										(ima_prin INNER JOIN letrero_ima_prin
										ON ima_prin.id_ima_prin=letrero_ima_prin.id_ima_prin)

										WHERE letrero_ima_prin.tip_letrero_ima_prin='$tip_letrero_ima_prin'";

				$dato_letrero_ima = mysql_db_query($dbname, $dato_letrero_ima); 
				while ($row = mysql_fetch_array($dato_letrero_ima)){

						$arch_ima = $row["arch_ima_prin"]; 
						$tit_ima = $row["tit_ima_prin"]; 
						$fec_ima = $row["fec_ima_prin"]; 
						$lug_ima = $row["lug_ima_prin"]; 
						$des_ima = $row["des_ima_prin"]; 
						
						$id_letrero = $row["id_letrero"]; 

						$pos_letrero_ima_prin = $row["pos_letrero_ima_prin"];
						$pos=$pos_letrero_ima_prin-1; 

						$dato_letrero = "SELECT * FROM letrero WHERE id_letrero='$id_letrero'";
						$dato_letrero = mysql_db_query($dbname, $dato_letrero); 
						if ($row = mysql_fetch_array($dato_letrero)){ 

							$ico_let = $row["ico_letrero"]; 
							$tit_let = $row["tit_letrero"]; 
							$des_let = $row["des_letrero"]; 
							$btn_let = $row["btn_letrero"]; 
							$link_let = $row["link_letrero"]; 

						}
			?>
					<div class="item <?php if ($pos==0) {	?> active <?php	}?>" itemscope itemtype="http://schema.org/ImageObject">
						<img src="/image/<?=$arch_ima?>" alt="<?=$tit_ima?> - <?=$fec_ima?> : <?=$des_ima?>" itemprop="contentURL">
						<meta itemprop="datePublished" content="<?=$fec_ima?>">
						<div class="container">
							<div class="carousel-caption">
								<h2><span class="<?=$ico_let?> ico-car"></span><?=$tit_let?></h2>
								<p class="lead"><?=$des_let?></p>
								<a class="btn btn-large btn-sitio" href="<?=$link_let?>" itemprop="url"><?=$btn_let?></a>
							</div>
						</div>
					</div>
			<?php
				}
			?>
				</div>

				<ol class="carousel-indicators">
					<?php 
					$pos=$pos+1;
					for ($i=0; $i < $pos; $i++) { 
					?>
					<li data-target="#myCarousel" data-slide-to="<?=$i?>" <?php if ($i==0) { ?> class="active" <?php }?>></li>
				
					<?php
					}?>
				</ol> <!-- / Menu del Carrusel -->
				<a class="left carousel-control" href="#myCarousel" data-slide="prev">&lsaquo;</a>
				<a class="right carousel-control" href="#myCarousel" data-slide="next">&rsaquo;</a>
			</div>
		</header>