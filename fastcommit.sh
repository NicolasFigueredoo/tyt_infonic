# Este script permite hacer un commit rapido, sin tener que escribir el mensaje
# OS: Linux
# Interpreter: Bash
# Language: Bash
# Extension: sh
#!/bin/bash
# Defino la funcion commit

# Defino el mensaje por defecto
commitMessageDefault="Commit Rapido"

# Pregunto por el mensaje
read -p "Ingrese Mensaje: [$commitMessageDefault]: " commitMessage
# Si no se ingreso mensaje, uso el por defecto
commitMessage=${commitMessage:-$commitMessageDefault}

# Asigno permisos de escritura a todos los archivos
sudo chmod 777 -R ./
# Refresco el index, es útil cuando se agregan/eliminan archivos
git update-index --refresh
# Borro el cache de los archivos eliminados
git rm -r --cached .
# Desactivo el modo filemode, es útil para que no se modifiquen los permisos de los archivos
git config core.fileMode false
# Lo mismo que el anterior, pero lo dejo como global
git config --add --global core.filemode false
# Agrego todos los archivos al index
git add --all
# Hago el commit
git commit -a -m "$commitMessage"
#git push