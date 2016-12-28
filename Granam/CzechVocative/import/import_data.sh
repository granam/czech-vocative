#!/bin/bash
set -x
set -e

curl https://raw.githubusercontent.com/Mimino666/vokativ/master/vokativ/data/man_suffixes |\
./pickle_to_json.py |\
./json_to_serialized_php.php >\
../data/man_suffixes

curl https://raw.githubusercontent.com/Mimino666/vokativ/master/vokativ/data/man_vs_woman_suffixes |\
./pickle_to_json.py |\
./json_to_serialized_php.php >\
../data/man_vs_woman_suffixes

curl https://raw.githubusercontent.com/Mimino666/vokativ/master/vokativ/data/woman_first_vs_last_name_suffixes |\
./pickle_to_json.py |\
./json_to_serialized_php.php >\
../data/woman_first_vs_last_name_suffixes
