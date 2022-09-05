#!/usr/bin/python3

import sys
import json
import pickle

data = sys.stdin.buffer.read()
print(json.dumps(pickle.loads(data)))
