<html>
<head>
    <script type="text/javascript">
		var centreGot = false;
	</script>
    <?php echo $map['js']; ?>
</head>
<body>
    <div class="container">
    <?php echo $map['html']; ?>
    </div>
    <ul>
        <div><? foreach($basedatos->result() as $list_locales){echo "<li>".$list_locales->ml_nombre_local."</li>";};?></div>
    </ul>
</body>
</html>
