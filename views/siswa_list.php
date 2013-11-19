<html>
<head>
<metahttp-euiqv="Content-Type" content="text/html"; charset=iso-8859-1"/>
<title> CRETE UPDATE DELETE APPLICATION</title>
<link href="<?php echo base_url();?>style/style.css" rel="stylesheet" type="text/css"/>
</head>

<body>
<div class="content">
<h1>Insert Update dan Delete</h1>
<div class="pagging"><?php echo $pagination;?></div>
<div class="data"><?php echo $table;?></div>
<div class="paging"><?php echo $pagination;?></div><br>
<?php echo anchor('siswa/add','Tambah Siswa',array('class'=>'add'));?>
</div>
</body>
</html>
