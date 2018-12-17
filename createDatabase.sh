#!/bin/bash
cd database
rm mate.db 
cat mate.sql |  sqlite3 -batch mate.db
cat populate.sql |  sqlite3 -batch mate.db
cd ..
