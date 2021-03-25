#!/usr/bin/php
<?php

$data = file_get_contents('php://stdin');
echo serialize(json_decode($data, true, 512, JSON_THROW_ON_ERROR));
