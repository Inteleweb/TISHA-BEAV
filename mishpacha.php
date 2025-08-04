<?php
// Set London timezone
date_default_timezone_set('Europe/London');
// Deadline: August 4, 2025, 13:06 BST
$deadline = strtotime('2025-08-04 13:06');
if (time() > $deadline) {
    header('Location: https://mishpacha.com/watch-stardust-in-seagate/');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Yossi Green and his most famous compositions</title>
  <meta name="viewport" content="width=400, initial-scale=1.0">
  <style>
    body { font-family: Arial, sans-serif; background: #f8f8fa; text-align: center; margin-top: 100px; }
    .wrap { max-width: 400px; margin: 0 auto; border: 1px solid #ddd; border-radius: 10px; background: #fff; padding: 2em 1em; }
    a { color: #2b47da; text-decoration: underline; }
    .sources {font-size:0.96em; margin-top:1.5em;}
    .proceed {font-size:1.1em; margin-top:2em;}
  </style>
</head>
<body>
  <div class="wrap">
    <h2>No music until after chatzos</h2>
    <p><strong>Chatzos:</strong> 13:06 in London</p>
    <div class="sources">
      <p>See <a href="https://www.myzmanim.com/day.aspx?vars=37993014&q=london" target="_blank">MyZmanim London</a> and <a href="https://outorah.org/p/27303/" target="_blank">halacha guidance</a> for details.</p>
    </div>
    <p>See you later.</p>
    <div class="proceed">
      <a href="https://mishpacha.com/watch-stardust-in-seagate/" rel="noopener">If you are NOT in London, click here to proceed anyway</a>
    </div>
  </div>
</body>
</html>
