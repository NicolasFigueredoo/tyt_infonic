:: Este script permite hacer un commit rapido, sin tener que escribir el mensaje
:: OS: Windows
:: Interpreter: CMD/Powershell
:: Language: batch
:: Extension: bat

:: Defino el mensaje por defecto
set commitMessageDefault=Commit Rapido

:: Pregunto por el mensaje
set /p commitMessage=Ingrese Mensaje: [%commitMessageDefault%]:
:: Si no se ingreso mensaje, uso el por defecto
set commitMessage=%commitMessage%:%commitMessageDefault%

:: Refresco el index, es útil cuando se agregan/eliminan archivos
git update-index --refresh
:: Borro el cache de los archivos eliminados
git rm -r --cached .
:: Desactivo el modo filemode, es útil para que no se modifiquen los permisos de los archivos
git config core.fileMode false
:: Lo mismo que el anterior, pero lo dejo como global
git config --add --global core.filemode false
:: Agrego todos los archivos al index
git add --all
:: Hago el commit
git commit -a -m "%commitMessage%"
:: git push