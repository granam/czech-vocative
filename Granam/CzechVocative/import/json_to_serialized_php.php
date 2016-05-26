#!/usr/bin/php
<?php

$data = file_get_contents('php://stdin');
echo serialize(json_decode($data, true));