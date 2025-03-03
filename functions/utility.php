<?php
function sanitizeString($data)
{
    $data = trim($data);            //rimuove gli spazi prima e dopo la stringa 
    $data = stripslashes($data);    // rimuove gli slashes //
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    return $data;
}
