<?php

function show($stuff){
  echo "<pre>";
  print_r($stuff);
  echo "</pre>";
}
function splitURL(){
$url = isset($_GET['url']) ? trim($_GET['url'], '/') : 'home';
$url = ($url === '') ? 'home' : $url;
$content = explode('/', $url);
return ($content);
}
function loadPage(){
  $URL=splitURL();
  // if(ucfirst($URL[0]=='home')){
    $filename="../app/controller/".ucfirst($URL[0]).".php";
  // }else{
  //   $filename="../app/controller/".ucfirst($URL[1]).".php"; 
  // }
 
  if(file_exists($filename)){
    require($filename);
  }
  else{
    $filename="../app/controller/_404.php";
    require($filename);  
  }
}
// loadPage();
show(splitURL());
echo "location = /public {
  return 404;
}

location /public/ {
  rewrite ^/public/(.*)$ /$1 last;
  try_files $uri $uri/ /public/index.php?url=$uri&$args;
}

location / {
  try_files $uri $uri/ /public/index.php?url=$uri&$args;
}
";

echo "location = /public {
  try_files /public/index.php =404;
}

location /public/ {
  rewrite ^/public/(.*)$ /$1 last;
  try_files $uri $uri/ /public/index.php?url=$uri&$args;
}

location / {
  try_files $uri $uri/ /public/index.php?url=$uri&$args;
}
";