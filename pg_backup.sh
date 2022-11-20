#! /bin/bash

user="USER"
dir="/home/${USER}/pg_backup/"


if [ ! -e "${dir}/archive" ]; then
    mkdir -p "${dir}/archive"
fi


pg_user="PGUSER"
pg_pass="PGPASS"
filename="rack_db_dump-$(date +'%Y_%m_%d_%I_%M_%S').pgsql"
max_files=7
files=$(ls -1q $dir | wc -l)
files=$(( ${files} ))
PGPASSWORD=$pg_pass pg_dump -U $pg_user -h localhost racks_db > ${dir}${filename}


if [ "$files" -gt "$max_files" ]; then
	tar czf "${dir}${filename}.tar" "${dir}" --exclude='"archive"'
	mv "${dir}${filename}.tar" "${dir}archive/"
	dir+="*.pgsql"
	rm -f $dir
else
	:
fi
exit 0


#sudo -u postgres psql
#drop database racks_db;
#create database racks_db;
#\q
#psql --host=localhost --dbname=racks_db --username=racks -f /file.name
