
                    <?php
					
					require('include/config.php');
					$last = $_GET['last'];
					$rs = mysqli_query($config, "SELECT * FROM tbl_surat_masuk WHERE id_surat='$last'");
					//output berupa json
					if(mysqli_num_rows($rs) > 0) {
						$lastSql = mysqli_query($config, "SELECT MAX(id_surat) FROM tbl_surat_masuk");
						$lastId = mysqli_fetch_array($lastSql);
                        echo '<span class="heartbit"></span> <span class="point"></span>';
					} else {
						echo '';
					}
                        ?>