location / {
  try_files $uri @rewriteapp;
}

location @rewriteapp {
  rewrite ^(.*)% /app.php/$1 last;
}

location ~ ^/(app|app_dev|config)\.php(/|$) {
  try_files @heroky-fcgi @heroku-fcgi;
  internal;
}

