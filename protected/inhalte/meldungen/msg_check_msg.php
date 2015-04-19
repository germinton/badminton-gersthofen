<div class="check_msg papier">
<p><?php echo $data['msg']; ?></p>
<ol>
<?php foreach ($data['checkmsg'] as $msg) echo '<li>'.$msg.'</li>'."\n";?>
</ol>
<p>Gehe <a href="javascript:history.back(-1)">zurück</a> um die Angaben zu korrigieren.</p>
</div>
