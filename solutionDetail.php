<?php
header("Content-type: application/pdf");
$file = fopen("uploads/pdf/Linuxserverupgradephp56tophp71-php72.pdf", "r");



fpassthru($file);

fclose($file);