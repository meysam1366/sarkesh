<?php
#this function render theme file and replace contents with tags that defined in that.

function sys_render($buffer)
{
  // first replace headers 
  // like css java scripts and ect
  $page = new cls_page;
  $buffer = str_replace("</##headers##/>", $page->load_headers(), $buffer);
  
  
  $buffer = str_replace("</##PAGE_TITTLE##/>", "Sarkesh Home Page", $buffer);
  $buffer = str_replace("</##block##sidebar1##/>", "Sarkesh Home Page", $buffer);
  return $buffer;
}



?>