@echo off
git add -A
git commit -m %1
git push -u origin main
echo "Mariobross5625."
ssh root@47.252.35.87 "cd /var/www/html/proyectoGraduacion; git pull"
echo "Cambio subidos"