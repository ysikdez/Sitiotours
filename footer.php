
		<footer class="container pie-pag">
			<hr class="featurette-divider">
			<div>
				<a href="/" class="pull-right pie-margen">
					<figure  itemscope itemtype="http://schema.org/ImageObject">
						<img src="/img/YSIK.png" alt="Logo Sitiotours.com" width="38" height="40" itemprop="contentURL">
					</figure>
				</a>
			</div>
			<div class="pull-right span2">
				<p>
					<strong>Contactanos:</strong>
					<br>
					<br>
					<?php
						//Info del Contacto
						$dato_pagina = "SELECT * FROM info WHERE id_contacto='1' AND vis_info='1' ORDER BY ord_info";
						$dato_pagina = mysql_db_query($dbname, $dato_pagina); 
						while ($row = mysql_fetch_array($dato_pagina)){ 

							$tipo_pie = $row["tipo_info"]; 
							$dato_pie = $row["dato_info"]; 

							switch ($tipo_pie) {
								case 'Dirección':
									?>
									<small><strong><spam class="enlace-pie">Dirección:</spam></strong><?=$dato_pie?></small>
									<?php
									break;
								case 'E-mail':
									?>
									<a class="enlace-pie" href="mailto:<?=$dato_pie?>" itemprop="url"><i class="icon-mail ico-ml"></i> <?=$dato_pie?></a><br>
									<?php
									break;
								case 'Facebook':
									?>
									<a class="enlace-pie" href="<?=$dato_pie?>" itemprop="url"><i class="icon-facebook1 ico-fb"></i> Facebook</a><br>
									<?php
									# code...
									break;
								case 'Google+':
									?>
									<a class="enlace-pie" href="<?=$dato_pie?>" itemprop="url"><i class="icon-google ico-go"></i> Google+</a><br>
									<?php
									break;
								case 'Instagram':
									?>
									<a class="enlace-pie" href="<?=$dato_pie?>" itemprop="url"><i class="icon-instagram ico-in"></i> Instagram</a><br>
									<?php
									break;
								case 'Sitio Web':
									?>
									<a class="enlace-pie" href="<?=$dato_pie?>" itemprop="url"><small><?=$dato_pie?></small></a>
									<?php
									break;
								case 'Skype':
									?>
									<a class="enlace-pie" href="skype:<?=$dato_pie?>?call" itemprop="url"><i class="icon-skype ico-sk"></i> Skype</a><br>
									<?php
									break;
								case 'Telefono':
									?>
									<small><strong>Fono:</strong><?=$dato_pie?></small>
									<?php
									break;
								case 'Twitter':
									?>
									<a class="enlace-pie" href="<?=$dato_pie?>" itemprop="url"><i class="icon-twitter1 ico-tw"></i> Twitter</a><br>
									<?php
									break;
								case 'Youtube':
									?>
									<a class="enlace-pie" href="<?=$dato_pie?>" itemprop="url"><i class="icon-youtube ico-yt"></i> Youtube</a><br>
									<?php
									break;
							}

						}

					?>
				</p>
			</div>

			<div>
				<div class="pull-left span2">
					<a href="/" itemprop="url"><strong>&copy; 2014 Sitiotours.com </strong></a><br><br>
					<a href="/mapa-del-sitio" class="pie-margen" itemprop="url">Mapa del Sitio</a>
					<br>
					<br>
					<br>
					<br>
					<br>
					<br>
				</div>
				
					<span class="span6"><strong>Que Buscas:</strong><br><br></span>
					<?php

					//menu
					$dato_menu_pie = "SELECT * FROM pagina WHERE niv_pagina='1' ORDER BY ord_pagina";
					$dato_menu_pie = mysql_db_query($dbname, $dato_menu_pie); 
					while ($row = mysql_fetch_array($dato_menu_pie)){ 

						$ord_pie = $row["ord_pagina"];
						$url_pie = $row["url_pagina"];
						$ico_pie = $row["ico_pagina"];
						$tit_pie = $row["tit_pos_pagina"];


						if (($ord_pie>=3) and ($ord_pie<=14)){
							
						?>
							<span class="span2"><a itemprop="url" href="/<?=$url_pie?>"><i class="<?=$ico_pie?> ico-nav"></i><?=$tit_pie?></a></span>
						<?php
						
						}
					}
					?>
			</div>
			
		</footer><br>