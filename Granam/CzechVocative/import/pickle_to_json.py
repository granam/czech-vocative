#!/usr/bin/python

import sys
import json
import pickle

print json.dumps(pickle.load(sys.stdin))
