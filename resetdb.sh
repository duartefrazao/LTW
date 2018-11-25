#!/bin/bash
cd database
rm mate.db 
sqlite3 -init mate.sql mate.db
cd ..
php -S localhost:8000
