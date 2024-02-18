<!--
Author : Aguzrybudy
Created : Selasa, 19-April-2016
Title : Crud Menggunakan Modal Bootsrap
-->
<?php
 include '../library/config.php';
 $FiturID		=@$_GET['FiturID'];
 $LevelID		=@$_GET['LevelID'];
 $LevelName		=@$_GET['LevelName'];
 $LoginID		=@$_GET['LoginID'];
?>

<div class="modal-dialog">
    <div class="modal-content">
    	<div class="modal-header">
		  <h4 id="exampleModalLabel" class="modal-title">Setting Akses Lever</h4>
		  <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
		</div>
        <div class="modal-body">
			<div class="form-group">
				<div class="row">
					<div class="col-lg-12">
						<div id="upload-wrapper">
							<div>
								<form action="SimpanData/SimpanFiturAkses.php" method="post">
								<div class="table-responsive">  
									<table class="table table-striped">
									  <thead>
										<tr>
										  <th>No</th>
										  <th>Fitur Akses</th>
										  <th>Aksi</th>
										</tr>
									  </thead>
									  <tbody>
										<?php 
											$no =1;
											// $sql= @mysqli_query($koneksi, "SELECT * FROM fiturlevel WHERE LevelID='$LevelID' AND FiturID='$FiturID'"); 
											// $data = @mysqli_fetch_array($sql);
											$sql = "SELECT * FROM fiturlevel WHERE LevelID=? AND FiturID=?";
											$stmt = mysqli_prepare($koneksi, $sql);
											mysqli_stmt_bind_param($stmt, "ii", $LevelID, $FiturID);
											mysqli_stmt_execute($stmt);

											mysqli_stmt_store_result($stmt);

											mysqli_stmt_bind_result($stmt, $ViewData, $AddData, $EditData, $DeleteData, $PrintData);

											mysqli_stmt_fetch($stmt);

											mysqli_stmt_close($stmt);
										?>
										<tr>
										  <th scope="row"><?php echo $no++; ?></th>
										  <td>View Data</td>
										  <td width="50px">
											 <input type="checkbox" name="ViewData" <?php if($ViewData=='1'){ echo 'checked'; } ?> value="1">
										  </td>
										</tr>
										<tr>
										  <th scope="row"><?php echo $no++; ?></th>
										  <td>Tambah Data</td>
										  <td width="50px">
											 <input type="checkbox" name="AddData" <?php if($AddData=='1'){ echo 'checked'; } ?> value="1">
										  </td>
										</tr>
										<tr>
										  <th scope="row"><?php echo $no++; ?></th>
										  <td>Edit Data</td>
										  <td width="50px">
											 <input type="checkbox" name="EditData" <?php if($EditData=='1'){ echo 'checked'; } ?> value="1">
										  </td>
										</tr>
										<tr>
										  <th scope="row"><?php echo $no++; ?></th>
										  <td>Hapus Data</td>
										  <td width="50px">
											 <input type="checkbox" name="DeleteData" <?php if($DeleteData=='1'){ echo 'checked'; } ?> value="1">
										  </td>
										</tr>
										<tr>
										  <th scope="row"><?php echo $no++; ?></th>
										  <td>Print Data</td>
										  <td width="50px">
											 <input type="checkbox" name="PrintData" <?php if($PrintData=='1'){ echo 'checked'; } ?> value="1">
											 <input type="hidden" name="LevelID" value="<?php echo $LevelID; ?>"> 
											 <input type="hidden" name="FiturID" value="<?php echo $FiturID; ?>"> 
											 <input type="hidden" name="LevelName" value="<?php echo $LevelName; ?>"> 
											 <input type="hidden" name="LoginID" value="<?php echo $LoginID; ?>"> 
										  </td>
										</tr>
									  </tbody>
									</table>
								</div>
								<div  style="text-align:right;">
									<input type="submit" class="btn btn-md btn-success" value="Simpan" name="Setting" />
								</div>
								</form>
								<?php
									mysqli_stmt_free_result($stmt);
								?>
							</div>
						</div>
					</div>
				</div>
			</div>
        </div>
	</div>
</div>
