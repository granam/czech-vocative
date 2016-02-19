#!/bin/bash
set -x
set -e

curl https://raw.githubusercontent.com/Mimino666/vokativ/master/vokativ/data/man_suffixes |\
import/pickle_to_json.py |\
php import/json_to_serialized_php.php >\
src/data/man_suffixes

curl https://raw.githubusercontent.com/Mimino666/vokativ/master/vokativ/data/man_vs_woman_suffixes |\
import/pickle_to_json.py |\
php import/json_to_serialized_php.php >\
src/data/man_vs_woman_suffixes

curl https://raw.githubusercontent.com/Mimino666/vokativ/master/vokativ/data/woman_first_vs_last_name_suffixes |\
import/pickle_to_json.py |\
php import/json_to_serialized_php.php >\
src/data/woman_first_vs_last_name_suffixes