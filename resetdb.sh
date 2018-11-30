#!/bin/bash
cd database
rm mate.db 
cat mate.sql |  sqlite3 -batch mate.db
cd ..
php -S localhost:8000
