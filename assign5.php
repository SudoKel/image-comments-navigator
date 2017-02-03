<?php
	session_start();

	GLOBAL $link;
	if(isset($_POST["path"]))
	{
		$link = $_POST["path"];
	}
	else
	{
		$link = "comments/A.txt";
	}

	if(isset($_POST["comment"]) and isset($_POST["src"]))
	{
		$comment = "\n" . $_POST["comment"];
		$src = $_POST["src"];

		file_put_contents($src, $comment, FILE_APPEND);

		$link = $src;
	}

	$path = scandir("comments/");

	$_SESSION["fnames"] = array();

	foreach ($path as $fname)
	{
		//exclude hidden folders
		if($fname == "." or $fname == "..")	continue;
	
		array_push($_SESSION["fnames"], $fname);
	}

	foreach ($_SESSION["fnames"] as $fname)
	{
		$path = "comments/" . $fname;
		$_SESSION[$path] = file($path);
	}
	
?>

<!DOCTYPE html>
<html>
	<head>
		<title>AJAX - Web Application</title>
		<style>
			td{
				padding: 10px;
				text-align: center;
			}

			.comment{
				border-top: 1px solid #BDBDBD;
				background: #EDEDED;
			}
		</style>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
		<script type="text/javascript">			
			function previous()
			{
				var id = $('#img').attr("src");

				if(id == "img/A.png")
				{
					$.ajax({
						url: "assign5.php",
						type: "POST",
						data: {path: "comments/D.txt"},
						success: function(data)
						{
							$("#container").html(data);
							$("#img").attr("src","img/D.png");
						}
					});
				}
				else if(id == "img/B.png")
				{
					$.ajax({
						url: "assign5.php",
						type: "POST",
						data: {path: "comments/A.txt"},
						success: function(data)
						{
							$("#container").html(data);
							$("#img").attr("src","img/A.png");
						}
					});
				}
				else if(id == "img/C.png")
				{
					$.ajax({
						url: "assign5.php",
						type: "POST",
						data: {path: "comments/B.txt"},
						success: function(data)
						{
							$("#container").html(data);
							$("#img").attr("src","img/B.png");
						}
					});
				}
				else
				{
					$.ajax({
						url: "assign5.php",
						type: "POST",
						data: {path: "comments/C.txt"},
						success: function(data)
						{
							$("#container").html(data);
							$("#img").attr("src","img/C.png");
						}
					});
				}
			}

			function next()
			{
				var id = $('#img').attr("src");

				if(id == "img/A.png")
				{
					$.ajax({
						url: "assign5.php",
						type: "POST",
						data: {path: "comments/B.txt"},
						success: function(data)
						{
							$("#container").html(data);
							$("#img").attr("src","img/B.png");
						}
					});
				}
				else if(id == "img/B.png")
				{
					$.ajax({
						url: "assign5.php",
						type: "POST",
						data: {path: "comments/C.txt"},
						success: function(data)
						{
							$("#container").html(data);
							$("#img").attr("src","img/C.png");
						}
					});
				}
				else if(id == "img/C.png")
				{
					$.ajax({
						url: "assign5.php",
						type: "POST",
						data: {path: "comments/D.txt"},
						success: function(data)
						{
							$("#container").html(data);
							$("#img").attr("src","img/D.png");
						}
					});
				}
				else
				{
					$.ajax({
						url: "assign5.php",
						type: "POST",
						data: {path: "comments/A.txt"},
						success: function(data)
						{
							$("#container").html(data);
							$("#img").attr("src","img/A.png");
						}
					});
				}
			}

			function reply()
			{
				var text = $("#comments").val();
				var img = $("#img").attr("src");
				var source;

				if(img == "img/A.png")
				{
					source = "comments/A.txt";
				}
				else if(img == "img/B.png")
				{
					source = "comments/B.txt";
				}
				else if(img == "img/C.png")
				{
					source = "comments/C.txt";
				}
				else
				{
					source = "comments/D.txt";
				}

				$.ajax({
						url: "assign5.php",
						type: "POST",
						data: {comment: text, src: source},
						success: function(data)
						{
							$("#container").html(data);
							$("#img").attr("src", img);
						}
					});
			}
		</script>
	</head>

	<body>
		<div id="container">
			<h2 align="center">Welcome</h2>
			<table align="center">
				<tr>
					<td>
						<button type="button" id="prev" name="prev" value="previous" onclick="previous()">Previous</button>
					</td>
					<td>
						<img id="img" src="img/A.png" />
					</td>
					<td>
						<button type="button" id="next" name="next" value="next" onclick="next()">Next</button>
					</td>
				</tr>
				<tr>
					<td colspan="3"><b>Comments:</b></td>
				</tr>
				<?php
					if($link != null)
					{
						foreach ($_SESSION[$link] as $comment)
						{
							echo "<tr><td class=\"comment\" colspan=\"3\">$comment</td></tr>";
						}
					}
				?>
				<tr>
					<td colspan="3"><textarea id="comments" name="comments" cols="50" rows="5"></textarea></td>
				</tr>
				<tr>
					<td colspan="3"><button type="button" id="reply" name="reply" onclick="reply()">Reply</button></td>
				</tr>
			</table>
		<div>
	</body>
</html>