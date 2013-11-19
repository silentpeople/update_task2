<html>
<head>
<title>CRUD APPLICATION</title>
<linkref="<?php echo base_url();?> rel="stylesheet" type="text/css"/>
</head>
<body>
<div class="content">
<h1><?php echo $title; ?></h1>
<?php echo $message; ?>
<?php echo validation_errors(); ?>
<?php echo form_open($action); ?>
<div class="data">
<table>
<tr>
<td width="30">ID</td>
<td><input type="" name="id" disabled="disabled" class="text" value="<?php echo (isset($siswa['id'])), $siswa['id'];'';?>"/></td>
<input type="hidden" name="id" value="<?php echo(isset($siswa['id']))?><?php $siswa['id'];'';?>"/>
</tr>
<tr>
<td valign="top">Nama</td>
<td><input type="" name="nama" class="text" value="<?php echo set_value('nama'), set_value('nama'), $siswa['nama'];?>"/>
<?php echo form_error('nama');?></td>
</tr>
<tr>
<td valign="top">Alamat</td>
<td><input type="" name="alamat" class="text" value="<?php echo set_value('alamat'), set_value('alamat'), $siswa['alamat'];?>"/>
<?php echo form_error('alamat');?></td>
</tr>
<tr>
<td valign="top">Gender<spanstyle="color:red;">*</span></td>
<td><input type="radio" name="gender" value="M"<?php echo set_radio('gender', 'M', TRUE);?>/>Lelaki
<input type="radio" name="gender" value="P"<?php echo ser_radio('gender', 'P');?>/>Perempuan
<?php echo form_error('gender');?></td>
</tr>
<tr>
<td valign="top">Tarikh Lahir<spanstyle="color:red;">*</span></td>
<td><input type="" name="tarikh" class="text" value="<?php echo (set_value('tarikh')), set_value('tarikh'), $siswa['tarikh'];?>"</>
<?php echo form_error('tarikh');?></td>
</td>
<tr>
<td>&nbsp;</td>
<td><input type="submit" value="Tambah"/><input type="submit" value="Padam"/></td>
</tr>
</table>
</div>
</form
<br>
<?php echo $link_back;?>
</div>
</body>
</html>
